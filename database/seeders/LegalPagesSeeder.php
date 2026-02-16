<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Setting;

class LegalPagesSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Yasal sayfaları oluştur
        $legalPages = [
            [
                'slug' => 'gizlilik-politikasi',
                'title' => 'Gizlilik Politikası',
                'excerpt' => 'Kişisel verilerinizin korunması ve gizliliğiniz bizim için önemlidir.',
                'content' => '<h2>Gizlilik Politikası</h2><p>GMSGARAGE olarak, müşterilerimizin gizliliğini korumayı taahhüt ediyoruz.</p>',
                'is_active' => true,
            ],
            [
                'slug' => 'kullanim-kosullari',
                'title' => 'Kullanım Koşulları',
                'excerpt' => 'Web sitemizi kullanırken kabul etmeniz gereken şartlar ve koşullar.',
                'content' => '<h2>Kullanım Koşulları</h2><p>Bu web sitesini kullanarak aşağıdaki koşulları kabul etmiş sayılırsınız.</p>',
                'is_active' => true,
            ],
            [
                'slug' => 'cerez-politikasi',
                'title' => 'Çerez Politikası',
                'excerpt' => 'Web sitemizde kullanılan çerezler hakkında bilgilendirme.',
                'content' => '<h2>Çerez Politikası</h2><p>Web sitemizde deneyiminizi geliştirmek için çerezler kullanıyoruz.</p>',
                'is_active' => true,
            ],
            [
                'slug' => 'kvkk',
                'title' => 'KVKK Aydınlatma Metni',
                'excerpt' => '6698 sayılı Kişisel Verilerin Korunması Kanunu kapsamında aydınlatma metni.',
                'content' => '<h2>KVKK Aydınlatma Metni</h2><p>Kişisel verileriniz 6698 sayılı Kanun kapsamında işlenmektedir.</p>',
                'is_active' => true,
            ],
            [
                'slug' => 'mesafeli-satis-sozlesmesi',
                'title' => 'Mesafeli Satış Sözleşmesi',
                'excerpt' => 'Online araç satışlarında geçerli olan mesafeli satış sözleşmesi şartları.',
                'content' => '<h2>Mesafeli Satış Sözleşmesi</h2><p>Bu sözleşme, satıcı ile alıcı arasında düzenlenmiştir.</p>',
                'is_active' => true,
            ],
            [
                'slug' => 'iade-ve-degisim-kosullari',
                'title' => 'İade ve Değişim Koşulları',
                'excerpt' => 'Satın aldığınız araçlar için iade ve değişim şartları.',
                'content' => '<h2>İade ve Değişim Koşulları</h2><p>Belirtilen koşullarda iade ve değişim talebinde bulunabilirsiniz.</p>',
                'is_active' => true,
            ],
        ];

        // Her bir yasal sayfayı oluştur veya güncelle
        foreach ($legalPages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }

        // Footer'daki yasal link listesini güncelle
        $footerLinks = [];
        foreach ($legalPages as $page) {
            $footerLinks[] = [
                'label' => $page['title'],
                'url' => $page['slug']
            ];
        }

        Setting::updateOrCreate(
            ['key' => 'footer_bottom_links'],
            ['value' => json_encode($footerLinks, JSON_UNESCAPED_UNICODE)]
        );
    }
}
