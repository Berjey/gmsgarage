<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Yeni İletişim Formu Mesajı</title>
    <!--[if mso]>
    <style type="text/css">
        body, table, td {font-family: Arial, sans-serif !important;}
    </style>
    <![endif]-->
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; line-height: 1.6; color: #1f2937; background-color: #f3f4f6;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f3f4f6; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="max-width: 600px; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white; padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; font-size: 28px; font-weight: 700; margin-bottom: 8px; letter-spacing: -0.5px;">Yeni İletişim Formu Mesajı</h1>
                            <p style="margin: 0; font-size: 14px; opacity: 0.95; font-weight: 300;">GMSGARAGE Web Sitesi</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px; background: #ffffff;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <!-- Gönderen Adı -->
                                <tr>
                                    <td style="padding-bottom: 20px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: #f9fafb; border-radius: 8px; border-left: 3px solid #dc2626;">
                                            <tr>
                                                <td style="padding: 16px;">
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tr>
                                                            <td width="24" valign="top" style="padding-right: 12px;">
                                                                <svg width="24" height="24" fill="none" stroke="#dc2626" viewBox="0 0 24 24" style="display: block;">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                                </svg>
                                                            </td>
                                                            <td valign="top">
                                                                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; color: #6b7280; letter-spacing: 0.5px; margin-bottom: 4px;">Gönderen Adı</div>
                                                                <div style="font-size: 15px; font-weight: 500; color: #1f2937; word-break: break-word;">{{ $name }}</div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                
                                <!-- E-posta Adresi -->
                                <tr>
                                    <td style="padding-bottom: 20px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: #f9fafb; border-radius: 8px; border-left: 3px solid #dc2626;">
                                            <tr>
                                                <td style="padding: 16px;">
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tr>
                                                            <td width="24" valign="top" style="padding-right: 12px;">
                                                                <svg width="24" height="24" fill="none" stroke="#dc2626" viewBox="0 0 24 24" style="display: block;">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                                </svg>
                                                            </td>
                                                            <td valign="top">
                                                                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; color: #6b7280; letter-spacing: 0.5px; margin-bottom: 4px;">E-posta Adresi</div>
                                                                <div style="font-size: 15px; font-weight: 500; color: #1f2937; word-break: break-word;">
                                                                    <a href="mailto:{{ $email }}" style="color: #dc2626; text-decoration: none;">{{ $email }}</a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                
                                @if($phone)
                                <!-- Telefon -->
                                <tr>
                                    <td style="padding-bottom: 20px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: #f9fafb; border-radius: 8px; border-left: 3px solid #dc2626;">
                                            <tr>
                                                <td style="padding: 16px;">
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tr>
                                                            <td width="24" valign="top" style="padding-right: 12px;">
                                                                <svg width="24" height="24" fill="none" stroke="#dc2626" viewBox="0 0 24 24" style="display: block;">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                                </svg>
                                                            </td>
                                                            <td valign="top">
                                                                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; color: #6b7280; letter-spacing: 0.5px; margin-bottom: 4px;">Telefon</div>
                                                                <div style="font-size: 15px; font-weight: 500; color: #1f2937; word-break: break-word;">
                                                                    <a href="tel:{{ $phone }}" style="color: #dc2626; text-decoration: none;">{{ $phone }}</a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                @endif
                                
                                <!-- Konu -->
                                <tr>
                                    <td style="padding-bottom: 20px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: #f9fafb; border-radius: 8px; border-left: 3px solid #dc2626;">
                                            <tr>
                                                <td style="padding: 16px;">
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tr>
                                                            <td width="24" valign="top" style="padding-right: 12px;">
                                                                <svg width="24" height="24" fill="none" stroke="#dc2626" viewBox="0 0 24 24" style="display: block;">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                                </svg>
                                                            </td>
                                                            <td valign="top">
                                                                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; color: #6b7280; letter-spacing: 0.5px; margin-bottom: 4px;">Konu</div>
                                                                <div style="font-size: 15px; font-weight: 500; color: #1f2937; word-break: break-word;">{{ $subject }}</div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                
                                <!-- Gönderim Tarihi -->
                                <tr>
                                    <td style="padding-bottom: 20px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: #f9fafb; border-radius: 8px; border-left: 3px solid #dc2626;">
                                            <tr>
                                                <td style="padding: 16px;">
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tr>
                                                            <td width="24" valign="top" style="padding-right: 12px;">
                                                                <svg width="24" height="24" fill="none" stroke="#dc2626" viewBox="0 0 24 24" style="display: block;">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                </svg>
                                                            </td>
                                                            <td valign="top">
                                                                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; color: #6b7280; letter-spacing: 0.5px; margin-bottom: 4px;">Gönderim Tarihi</div>
                                                                <div style="font-size: 15px; font-weight: 500; color: #1f2937; word-break: break-word;">{{ $created_at }}</div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                
                                <!-- Mesaj İçeriği -->
                                <tr>
                                    <td style="padding-bottom: 20px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: #f9fafb; border-radius: 8px; border-left: 3px solid #dc2626;">
                                            <tr>
                                                <td style="padding: 16px;">
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tr>
                                                            <td width="24" valign="top" style="padding-right: 12px;">
                                                                <svg width="24" height="24" fill="none" stroke="#dc2626" viewBox="0 0 24 24" style="display: block;">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                                                </svg>
                                                            </td>
                                                            <td valign="top" style="width: 100%;">
                                                                <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; color: #6b7280; letter-spacing: 0.5px; margin-bottom: 4px;">Mesaj İçeriği</div>
                                                                <div style="font-size: 15px; font-weight: 500; color: #1f2937; word-break: break-word; white-space: pre-wrap; line-height: 1.8;">{{ $messageContent }}</div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background: #1f2937; color: #9ca3af; padding: 24px 30px; text-align: center; font-size: 12px; line-height: 1.6;">
                            <p style="margin: 0 0 8px 0;">Bu e-posta GMSGARAGE web sitesi iletişim formundan otomatik olarak gönderilmiştir.</p>
                            <p style="margin: 0;">Yanıtlamak için bu e-postaya doğrudan yanıt gönderebilirsiniz.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
