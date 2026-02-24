<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\EvaluationRequest;
use Illuminate\Console\Command;

class SyncEvaluationCustomers extends Command
{
    protected $signature = 'evaluation:sync-customers';
    protected $description = 'Mevcut değerleme isteklerindeki müşterileri CRM listesine aktarır';

    public function handle(): int
    {
        $requests = EvaluationRequest::whereNotNull('email')->get();

        if ($requests->isEmpty()) {
            $this->info('Senkronize edilecek değerleme isteği bulunamadı.');
            return self::SUCCESS;
        }

        $created = 0;
        $skipped = 0;

        foreach ($requests as $eval) {
            $existing = Customer::where('email', $eval->email)->first();

            if ($existing) {
                $skipped++;
                continue;
            }

            $legalConsents = [];
            $legalPages = \App\Models\LegalPage::getActive();
            foreach ($legalPages as $page) {
                $legalConsents[$page->slug] = [
                    'title'       => $page->title,
                    'version'     => $page->version,
                    'accepted_at' => $eval->created_at->toDateTimeString(),
                ];
            }

            Customer::create([
                'name'             => $eval->name,
                'email'            => $eval->email,
                'phone'            => $eval->phone,
                'source'           => 'evaluation_request',
                'kvkk_consent'     => true,
                'ip_address'       => null,
                'legal_consents'   => $legalConsents,
                'consent_given_at' => $eval->created_at,
                'consent_ip'       => null,
                'is_new'           => false,
                'created_at'       => $eval->created_at,
                'updated_at'       => $eval->updated_at,
            ]);

            $created++;
        }

        $this->info("Tamamlandı: {$created} yeni müşteri eklendi, {$skipped} zaten kayıtlı atlandı.");
        return self::SUCCESS;
    }
}
