<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MailboxController extends Controller
{
    private $imapHost;
    private $imapUsername;
    private $imapPassword;
    
    public function __construct()
    {
        $this->imapHost = config('mail.mailers.smtp.host');
        $this->imapUsername = config('mail.mailers.smtp.username');
        $this->imapPassword = config('mail.mailers.smtp.password');
    }
    
    /**
     * Mail kutusu ana sayfa
     */
    public function index()
    {
        return view('admin.mailbox.index');
    }
    
    /**
     * Gelen kutusu
     */
    public function inbox()
    {
        $emails = $this->getEmails('INBOX');
        return view('admin.mailbox.folder', [
            'folder' => 'INBOX',
            'folder_name' => 'Gelen Kutusu',
            'emails' => $emails
        ]);
    }
    
    /**
     * Giden kutusu
     */
    public function sent()
    {
        $emails = $this->getEmails('Sent');
        return view('admin.mailbox.folder', [
            'folder' => 'Sent',
            'folder_name' => 'Giden Kutusu',
            'emails' => $emails
        ]);
    }
    
    /**
     * Silinen kutusu
     */
    public function trash()
    {
        $emails = $this->getEmails('Trash');
        return view('admin.mailbox.folder', [
            'folder' => 'Trash',
            'folder_name' => 'Silinen Kutusu',
            'emails' => $emails
        ]);
    }
    
    /**
     * Mail detay
     */
    public function show($folder, $uid)
    {
        $email = $this->getEmailDetail($folder, $uid);
        
        if (!$email) {
            return redirect()->route('admin.mailbox.inbox')->with('error', 'E-posta bulunamadı.');
        }
        
        return view('admin.mailbox.show', [
            'folder' => $folder,
            'folder_name' => $this->getFolderName($folder),
            'email' => $email
        ]);
    }
    
    /**
     * IMAP ile mail listesini çek
     */
    private function getEmails($folder, $limit = 50)
    {
        try {
            $imapPath = '{' . $this->imapHost . ':993/imap/ssl}' . $folder;
            $imap = @imap_open($imapPath, $this->imapUsername, $this->imapPassword);
            
            if (!$imap) {
                Log::error('IMAP bağlantı hatası: ' . imap_last_error());
                return [];
            }
            
            $emails = [];
            $totalEmails = imap_num_msg($imap);
            
            // Son N maili çek
            $start = max(1, $totalEmails - $limit + 1);
            
            for ($i = $totalEmails; $i >= $start; $i--) {
                $header = imap_headerinfo($imap, $i);
                $uid = imap_uid($imap, $i);
                
                if ($header) {
                    $from = isset($header->from[0]) ? $header->from[0] : null;
                    $fromEmail = $from ? $from->mailbox . '@' . $from->host : 'Bilinmeyen';
                    $fromName = $from && isset($from->personal) ? $this->decodeMimeStr($from->personal) : $fromEmail;
                    
                    $emails[] = [
                        'uid' => $uid,
                        'msg_num' => $i,
                        'subject' => isset($header->subject) ? $this->decodeMimeStr($header->subject) : '(Konu yok)',
                        'from_name' => $fromName,
                        'from_email' => $fromEmail,
                        'date' => isset($header->date) ? strtotime($header->date) : time(),
                        'unseen' => $header->Unseen ?? false,
                        'flagged' => $header->Flagged ?? false,
                        'answered' => $header->Answered ?? false,
                    ];
                }
            }
            
            imap_close($imap);
            return $emails;
            
        } catch (\Exception $e) {
            Log::error('Mail listesi çekme hatası: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Mail detayını çek
     */
    private function getEmailDetail($folder, $uid)
    {
        try {
            $imapPath = '{' . $this->imapHost . ':993/imap/ssl}' . $folder;
            $imap = @imap_open($imapPath, $this->imapUsername, $this->imapPassword);
            
            if (!$imap) {
                Log::error('IMAP bağlantı hatası: ' . imap_last_error());
                return null;
            }
            
            $msgNum = imap_msgno($imap, $uid);
            
            if (!$msgNum) {
                imap_close($imap);
                return null;
            }
            
            $header = imap_headerinfo($imap, $msgNum);
            $structure = imap_fetchstructure($imap, $msgNum);
            
            // From bilgisi
            $from = isset($header->from[0]) ? $header->from[0] : null;
            $fromEmail = $from ? $from->mailbox . '@' . $from->host : 'Bilinmeyen';
            $fromName = $from && isset($from->personal) ? $this->decodeMimeStr($from->personal) : $fromEmail;
            
            // To bilgisi
            $to = isset($header->to[0]) ? $header->to[0] : null;
            $toEmail = $to ? $to->mailbox . '@' . $to->host : 'Bilinmeyen';
            $toName = $to && isset($to->personal) ? $this->decodeMimeStr($to->personal) : $toEmail;
            
            // Mail içeriğini çek
            $body = $this->getMailBody($imap, $msgNum, $structure);
            
            // Okundu olarak işaretle
            imap_setflag_full($imap, $uid, '\\Seen', ST_UID);
            
            $email = [
                'uid' => $uid,
                'msg_num' => $msgNum,
                'subject' => isset($header->subject) ? $this->decodeMimeStr($header->subject) : '(Konu yok)',
                'from_name' => $fromName,
                'from_email' => $fromEmail,
                'to_name' => $toName,
                'to_email' => $toEmail,
                'date' => isset($header->date) ? $header->date : '',
                'timestamp' => isset($header->date) ? strtotime($header->date) : time(),
                'body_html' => $body['html'] ?? '',
                'body_text' => $body['text'] ?? '',
                'unseen' => $header->Unseen ?? false,
                'flagged' => $header->Flagged ?? false,
            ];
            
            imap_close($imap);
            return $email;
            
        } catch (\Exception $e) {
            Log::error('Mail detay çekme hatası: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Mail içeriğini çek
     */
    private function getMailBody($imap, $msgNum, $structure)
    {
        $body = ['text' => '', 'html' => ''];
        
        if (isset($structure->parts) && count($structure->parts)) {
            foreach ($structure->parts as $partNum => $part) {
                $data = imap_fetchbody($imap, $msgNum, $partNum + 1);
                
                // Encoding'e göre decode et
                if ($part->encoding == 3) { // BASE64
                    $data = base64_decode($data);
                } elseif ($part->encoding == 4) { // QUOTED-PRINTABLE
                    $data = quoted_printable_decode($data);
                }
                
                // Subtype'a göre ayır
                if ($part->subtype == 'PLAIN') {
                    $body['text'] .= $data;
                } elseif ($part->subtype == 'HTML') {
                    $body['html'] .= $data;
                }
            }
        } else {
            // Part yoksa direkt body'yi al
            $data = imap_body($imap, $msgNum);
            
            if ($structure->encoding == 3) {
                $data = base64_decode($data);
            } elseif ($structure->encoding == 4) {
                $data = quoted_printable_decode($data);
            }
            
            if ($structure->subtype == 'HTML') {
                $body['html'] = $data;
            } else {
                $body['text'] = $data;
            }
        }
        
        return $body;
    }
    
    /**
     * MIME başlıklarını decode et
     */
    private function decodeMimeStr($string)
    {
        $elements = imap_mime_header_decode($string);
        $decoded = '';
        
        foreach ($elements as $element) {
            $charset = ($element->charset == 'default') ? 'UTF-8' : $element->charset;
            $decoded .= mb_convert_encoding($element->text, 'UTF-8', $charset);
        }
        
        return $decoded;
    }
    
    /**
     * Klasör adını çevir
     */
    private function getFolderName($folder)
    {
        $names = [
            'INBOX' => 'Gelen Kutusu',
            'Sent' => 'Giden Kutusu',
            'Trash' => 'Silinen Kutusu',
            'Drafts' => 'Taslaklar',
            'Spam' => 'Spam',
        ];
        
        return $names[$folder] ?? $folder;
    }
}
