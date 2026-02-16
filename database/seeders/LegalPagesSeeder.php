<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Support\Str;

class LegalPagesSeeder extends Seeder
{
    public function run(): void
    {
        $legalPages = [
            [
                'slug' => 'gizlilik-politikasi',
                'title' => 'Gizlilik Politikası',
                'content' => <<<'HTML'
<h2>Gizlilik Politikası</h2>
<p>GMSGARAGE olarak, müşterilerimizin gizliliğini korumayı ve kişisel verilerini güvenli bir şekilde işlemeyi taahhüt ediyoruz.</p>

<h3>1. Toplanan Bilgiler</h3>
<p>Web sitemizi ziyaret ettiğinizde veya hizmetlerimizi kullandığınızda aşağıdaki bilgileri toplayabiliriz:</p>
<ul>
    <li>Ad, soyad ve iletişim bilgileri</li>
    <li>E-posta adresi ve telefon numarası</li>
    <li>IP adresi ve tarayıcı bilgileri</li>
    <li>Araç tercihleri ve arama geçmişi</li>
</ul>

<h3>2. Bilgilerin Kullanımı</h3>
<p>Topladığımız bilgileri şu amaçlarla kullanırız:</p>
<ul>
    <li>Size daha iyi hizmet sunmak</li>
    <li>Araç önerilerinde bulunmak</li>
    <li>Müşteri desteği sağlamak</li>
    <li>Hizmetlerimizi geliştirmek</li>
</ul>

<h3>3. Bilgi Güvenliği</h3>
<p>Kişisel verilerinizin güvenliğini sağlamak için endüstri standardı güvenlik önlemleri kullanıyoruz.</p>

<h3>4. İletişim</h3>
<p>Gizlilik politikamız hakkında sorularınız varsa, lütfen bizimle iletişime geçin.</p>
HTML
            ],
            [
                'slug' => 'kullanim-kosullari',
                'title' => 'Kullanım Koşulları',
                'content' => <<<'HTML'
<h2>Kullanım Koşulları</h2>
<p>GMSGARAGE web sitesini kullanarak aşağıdaki kullanım koşullarını kabul etmiş sayılırsınız.</p>

<h3>1. Hizmet Kullanımı</h3>
<p>Web sitemiz ve hizmetlerimiz yalnızca yasal amaçlar için kullanılabilir. Yasadışı veya yetkisiz kullanım kesinlikle yasaktır.</p>

<h3>2. Fikri Mülkiyet Hakları</h3>
<p>Web sitemizdeki tüm içerik, görseller, logolar ve materyaller GMSGARAGE'ın mülkiyetindedir ve telif hakkı yasalarıyla korunmaktadır.</p>

<h3>3. Araç Listeleri ve Fiyatlar</h3>
<ul>
    <li>Araç fiyatları ve özellikleri önceden haber verilmeksizin değiştirilebilir</li>
    <li>Stok durumu anlık olarak güncellenebilir</li>
    <li>Görseller temsilidir, gerçek ürün farklılık gösterebilir</li>
</ul>

<h3>4. Sorumluluk Sınırlaması</h3>
<p>GMSGARAGE, web sitesinin kesintisiz veya hatasız çalışacağını garanti etmez.</p>

<h3>5. Değişiklikler</h3>
<p>Bu kullanım koşullarını dilediğimiz zaman değiştirme hakkını saklı tutarız.</p>
HTML
            ],
            [
                'slug' => 'cerez-politikasi',
                'title' => 'Çerez Politikası',
                'content' => <<<'HTML'
<h2>Çerez Politikası</h2>
<p>GMSGARAGE olarak, web sitemizde çerezler kullanarak kullanıcı deneyimini iyileştiriyoruz.</p>

<h3>1. Çerez Nedir?</h3>
<p>Çerezler, web sitesini ziyaret ettiğinizde cihazınıza kaydedilen küçük metin dosyalarıdır. Çerezler, web sitesinin düzgün çalışmasını ve kullanıcı deneyimini geliştirmesini sağlar.</p>

<h3>2. Kullandığımız Çerez Türleri</h3>
<ul>
    <li><strong>Zorunlu Çerezler:</strong> Web sitesinin temel işlevlerini yerine getirmesi için gereklidir</li>
    <li><strong>Performans Çerezleri:</strong> Ziyaretçilerin siteyi nasıl kullandığını anlamamızı sağlar</li>
    <li><strong>İşlevsellik Çerezleri:</strong> Tercihlerinizi hatırlar ve kişiselleştirilmiş özellikler sunar</li>
    <li><strong>Hedefleme Çerezleri:</strong> Sizin için ilgili reklamlar göstermemize yardımcı olur</li>
</ul>

<h3>3. Çerez Yönetimi</h3>
<p>Tarayıcı ayarlarınızdan çerezleri kabul etmemeyi veya silmeyi seçebilirsiniz. Ancak bu durumda web sitesinin bazı özellikleri düzgün çalışmayabilir.</p>

<h3>4. Üçüncü Taraf Çerezler</h3>
<p>Google Analytics gibi üçüncü taraf hizmetler, web sitemizde çerez kullanabilir.</p>
HTML
            ],
            [
                'slug' => 'kvkk',
                'title' => 'KVKK Aydınlatma Metni',
                'content' => <<<'HTML'
<h2>KVKK Aydınlatma Metni</h2>
<p>6698 sayılı Kişisel Verilerin Korunması Kanunu ("KVKK") uyarınca, veri sorumlusu sıfatıyla GMSGARAGE olarak kişisel verilerinizin işlenmesine ilişkin sizi bilgilendirmek isteriz.</p>

<h3>1. Veri Sorumlusu</h3>
<p><strong>Şirket:</strong> GMSGARAGE<br>
<strong>Adres:</strong> [Şirket Adresi]<br>
<strong>E-posta:</strong> info@gmsgarage.com</p>

<h3>2. İşlenen Kişisel Veriler</h3>
<p>Aşağıdaki kişisel verileriniz işlenmektedir:</p>
<ul>
    <li>Kimlik bilgileri (ad, soyad, TC kimlik numarası)</li>
    <li>İletişim bilgileri (telefon, e-posta, adres)</li>
    <li>Müşteri işlem bilgileri</li>
    <li>Finansal bilgiler (ödeme bilgileri)</li>
    <li>Görsel ve işitsel kayıtlar (CCTV kayıtları)</li>
</ul>

<h3>3. Kişisel Verilerin İşlenme Amaçları</h3>
<ul>
    <li>Araç satış ve kiralama hizmetlerinin sunulması</li>
    <li>Müşteri memnuniyetinin sağlanması</li>
    <li>Yasal yükümlülüklerin yerine getirilmesi</li>
    <li>Güvenlik önlemlerinin alınması</li>
    <li>İstatistiksel analizler yapılması</li>
</ul>

<h3>4. Kişisel Verilerin Aktarılması</h3>
<p>Kişisel verileriniz, yasal yükümlülüklerimiz çerçevesinde kamu kurum ve kuruluşlarına, iş ortaklarımıza ve tedarikçilerimize aktarılabilir.</p>

<h3>5. Kişisel Veri Sahibinin Hakları</h3>
<p>KVKK Madde 11 uyarınca, kişisel veri sahibi olarak:</p>
<ul>
    <li>Kişisel verilerinizin işlenip işlenmediğini öğrenme</li>
    <li>İşlenmişse buna ilişkin bilgi talep etme</li>
    <li>İşlenme amacını ve amacına uygun kullanılıp kullanılmadığını öğrenme</li>
    <li>Yurt içinde veya yurt dışında aktarıldığı üçüncü kişileri bilme</li>
    <li>Eksik veya yanlış işlenmişse düzeltilmesini isteme</li>
    <li>KVKK'da öngörülen şartlar çerçevesinde silinmesini veya yok edilmesini isteme</li>
    <li>Aktarıldığı üçüncü kişilere yukarıdaki işlemlerin bildirilmesini isteme</li>
    <li>Münhasıran otomatik sistemler ile analiz edilmesi nedeniyle aleyhinize bir sonuç doğmasına itiraz etme</li>
    <li>Kanuna aykırı olarak işlenmesi sebebiyle zarara uğramanız hâlinde zararın giderilmesini talep etme</li>
</ul>
<p>haklarına sahipsiniz.</p>

<h3>6. Başvuru Yöntemi</h3>
<p>Yukarıda belirtilen haklarınızı kullanmak için kimliğinizi tespit edici belgeler ile birlikte info@gmsgarage.com adresine başvurabilirsiniz.</p>
HTML
            ],
            [
                'slug' => 'mesafeli-satis-sozlesmesi',
                'title' => 'Mesafeli Satış Sözleşmesi',
                'content' => <<<'HTML'
<h2>Mesafeli Satış Sözleşmesi</h2>
<p>İşbu Mesafeli Satış Sözleşmesi, 6502 sayılı Tüketicinin Korunması Hakkında Kanun ve Mesafeli Sözleşmeler Yönetmeliği hükümleri gereğince düzenlenmiştir.</p>

<h3>Madde 1 - Taraflar</h3>
<p><strong>SATICI:</strong><br>
Ünvan: GMSGARAGE<br>
Adres: [Şirket Adresi]<br>
Telefon: [Telefon]<br>
E-posta: info@gmsgarage.com</p>

<p><strong>ALICI:</strong><br>
Web sitesi üzerinden sipariş veren müşteri</p>

<h3>Madde 2 - Konu</h3>
<p>İşbu sözleşmenin konusu, ALICI\'nın SATICI\'ya ait web sitesi üzerinden elektronik ortamda siparişini verdiği aşağıda nitelikleri ve satış fiyatı belirtilen ürünün satışı ve teslimi ile ilgili olarak 6502 sayılı Tüketicinin Korunması Hakkında Kanun ve Mesafeli Sözleşmeler Yönetmeliği hükümleri gereğince tarafların hak ve yükümlülüklerinin belirlenmesidir.</p>

<h3>Madde 3 - Sözleşme Konusu Ürün/Hizmet Bilgileri</h3>
<p>Ürün/hizmetin temel özellikleri, cinsi, miktarı, marka/modeli, rengi, adedi, satış bedeli, ödeme şekli ve teslimat bilgileri sipariş formunda belirtilmiştir.</p>

<h3>Madde 4 - Genel Hükümler</h3>
<ul>
    <li>ALICI, web sitesinde yer alan ürün/hizmetin temel nitelikleri, satış fiyatı ve ödeme şekli ile teslimata ilişkin tüm ön bilgileri okuyup bilgi sahibi olduğunu ve elektronik ortamda gerekli teyidi verdiğini beyan eder.</li>
    <li>Sözleşme konusu ürün/hizmet, yasal 30 günlük süreyi aşmamak koşulu ile her bir ürün/hizmet için ALICI\'nın yerleşim yerinin uzaklığına bağlı olarak ön bilgiler içinde belirtilen süre zarfında ALICI veya gösterdiği adresteki kişi/kuruluşa teslim edilir.</li>
</ul>

<h3>Madde 5 - Cayma Hakkı</h3>
<p>ALICI, sözleşme konusu ürün/hizmeti teslim aldığı tarihten itibaren 14 (on dört) gün içinde herhangi bir gerekçe göstermeksizin ve cezai şart ödemeksizin sözleşmeden cayma hakkına sahiptir.</p>

<h3>Madde 6 - Uyuşmazlık Çözümü</h3>
<p>İşbu sözleşmeden doğabilecek ihtilaflarda, Gümrük ve Ticaret Bakanlığınca her yıl Aralık ayında belirlenen parasal sınırlar dahilinde ALICInın yerleşim yerinin bulunduğu veya tüketici işleminin yapıldığı yerdeki İlçe/İl Tüketici Hakem Heyetleri ile Tüketici Mahkemeleri yetkilidir.</p>
HTML
            ],
            [
                'slug' => 'iade-ve-degisim',
                'title' => 'İade ve Değişim Koşulları',
                'content' => <<<'HTML'
<h2>İade ve Değişim Koşulları</h2>
<p>GMSGARAGE olarak müşteri memnuniyetini ön planda tutuyoruz. İade ve değişim süreçlerimiz hakkında bilgilendirme yapmak isteriz.</p>

<h3>1. İade Şartları</h3>
<p>Araç iadesi için aşağıdaki koşulların sağlanması gerekmektedir:</p>
<ul>
    <li>İade süresi araç teslim tarihinden itibaren 14 gündür</li>
    <li>Araç orijinal durumunda olmalıdır</li>
    <li>Araç üzerinde herhangi bir hasar veya değişiklik yapılmamış olmalıdır</li>
    <li>Araç belgeleri eksiksiz olmalıdır</li>
    <li>İade talebinizin yazılı olarak bildirilmesi gerekmektedir</li>
</ul>

<h3>2. İade Edilemeyen Durumlar</h3>
<ul>
    <li>Kullanım izleri taşıyan araçlar</li>
    <li>Hasar görmüş veya değiştirilmiş araçlar</li>
    <li>Belgeleri eksik olan araçlar</li>
    <li>14 günlük iade süresini geçmiş talepler</li>
</ul>

<h3>3. İade Süreci</h3>
<ol>
    <li>İade talebinizi info@gmsgarage.com adresine veya müşteri hizmetlerimize bildirin</li>
    <li>İade formunu doldurun</li>
    <li>Aracı belirlenen adrese teslim edin</li>
    <li>İnceleme süreci 7 iş günü içinde tamamlanır</li>
    <li>Onay durumunda ödemeniz 14 iş günü içinde iade edilir</li>
</ol>

<h3>4. Değişim Koşulları</h3>
<p>Araç değişim talepleri için:</p>
<ul>
    <li>Değişim süresi teslimattan itibaren 7 gündür</li>
    <li>Araç orijinal durumunda olmalıdır</li>
    <li>Fiyat farkı olması durumunda ödeme yapılmalıdır</li>
    <li>Müşteri hizmetlerimiz ile görüşülmelidir</li>
</ul>

<h3>5. Para İadesi</h3>
<p>İade onaylandığında, ödemeniz aynı ödeme yöntemi ile 14 iş günü içinde iade edilecektir.</p>

<h3>6. İletişim</h3>
<p>İade ve değişim konularında bizimle iletişime geçebilirsiniz:<br>
E-posta: info@gmsgarage.com<br>
Telefon: [Telefon Numarası]</p>
HTML
            ]
        ];

        // Sayfaları oluştur
        $footerLinks = [];
        foreach ($legalPages as $pageData) {
            $page = Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                [
                    'title' => $pageData['title'],
                    'content' => $pageData['content'],
                    'is_active' => true
                ]
            );

            $footerLinks[] = [
                'label' => $pageData['title'],
                'url' => $pageData['slug']
            ];
        }

        // footer_bottom_links ayarını güncelle
        Setting::updateOrCreate(
            ['key' => 'footer_bottom_links'],
            [
                'value' => json_encode($footerLinks, JSON_UNESCAPED_UNICODE),
                'group' => 'footer',
                'description' => 'Footer alt kısmındaki yasal linkler'
            ]
        );

        $this->command->info('✅ Yasal sayfalar ve footer linkleri başarıyla oluşturuldu!');
    }
}
