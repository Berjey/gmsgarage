<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LegalPage;

class LegalPagesSeeder extends Seeder
{
    public function run()
    {
        $legalPages = [
            [
                'title' => 'KVKK Aydınlatma Metni',
                'slug' => 'kvkk-aydinlatma-metni',
                'content' => $this->getKvkkContent(),
                'is_active' => true,
                'is_required_in_forms' => true,
                'version' => 1,
            ],
            [
                'title' => 'Gizlilik Politikası',
                'slug' => 'gizlilik-politikasi',
                'content' => $this->getPrivacyPolicyContent(),
                'is_active' => true,
                'is_required_in_forms' => false,
                'version' => 1,
            ],
            [
                'title' => 'Kullanım Şartları',
                'slug' => 'kullanim-sartlari',
                'content' => $this->getTermsContent(),
                'is_active' => true,
                'is_required_in_forms' => false,
                'version' => 1,
            ],
            [
                'title' => 'Çerez Politikası',
                'slug' => 'cerez-politikasi',
                'content' => $this->getCookiePolicyContent(),
                'is_active' => true,
                'is_required_in_forms' => false,
                'version' => 1,
            ],
            [
                'title' => 'İptal ve İade Koşulları',
                'slug' => 'iptal-iade-kosullari',
                'content' => $this->getRefundPolicyContent(),
                'is_active' => true,
                'is_required_in_forms' => false,
                'version' => 1,
            ],
            [
                'title' => 'Ticari Elektronik İleti Açık Rıza Metni',
                'slug' => 'ticari-elektronik-ileti-acik-riza',
                'content' => $this->getCommercialConsentContent(),
                'is_active' => true,
                'is_required_in_forms' => true,
                'is_optional_in_forms' => true,
                'version' => 1,
            ],
        ];

        foreach ($legalPages as $page) {
            LegalPage::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }

    private function getKvkkContent()
    {
        return <<<'EOT'
<h2>1. VERİ SORUMLUSU</h2>

<p>6698 sayılı Kişisel Verilerin Korunması Kanunu ("KVKK") uyarınca, <strong>GMS Garage Otomotiv</strong> (bundan böyle "GMS Garage" veya "Şirket" olarak anılacaktır) olarak kişisel verileriniz veri sorumlusu sıfatıyla tarafımızca aşağıda açıklanan kapsamda işlenebilecektir.</p>

<p><strong>İletişim Bilgilerimiz:</strong></p>
<ul>
    <li>E-posta: info@gmsgarage.com</li>
    <li>Telefon: +90 XXX XXX XX XX</li>
    <li>Adres: [Şirket Adresi]</li>
</ul>

<h2>2. KİŞİSEL VERİLERİNİZİN İŞLENME AMACI</h2>

<p>Toplanan kişisel verileriniz aşağıdaki amaçlarla işlenmektedir:</p>

<ul>
    <li><strong>Araç Alım-Satım Süreçlerinin Yürütülmesi:</strong> Araç alım, satım, değerleme ve danışmanlık hizmetlerinin sunulması</li>
    <li><strong>Müşteri İlişkileri Yönetimi:</strong> Müşteri memnuniyetinin sağlanması, talep ve şikayetlerin yönetimi</li>
    <li><strong>İletişim Faaliyetleri:</strong> Sizinle iletişime geçilmesi, bilgilendirme mesajları gönderilmesi</li>
    <li><strong>Pazarlama ve Tanıtım:</strong> Ürün ve hizmetlerimiz hakkında bilgilendirme, kampanya duyuruları (açık rızanız dahilinde)</li>
    <li><strong>Hukuki Yükümlülüklerin Yerine Getirilmesi:</strong> Yasal düzenlemelerin gerektirdiği bilgi ve belgelerin hazırlanması</li>
    <li><strong>Güvenlik ve İstatistiksel Analiz:</strong> Web sitesi güvenliğinin sağlanması, kullanıcı deneyiminin iyileştirilmesi</li>
</ul>

<h2>3. KİŞİSEL VERİLERİN TOPLANMA YÖNTEMİ</h2>

<p>Kişisel verileriniz aşağıdaki yöntemlerle toplanmaktadır:</p>

<ul>
    <li>Web sitemiz (www.gmsgarage.com) üzerindeki formlar</li>
    <li>E-posta ve telefon iletişimi</li>
    <li>Fiziksel ziyaretler ve görüşmeler</li>
    <li>Sosyal medya platformları</li>
    <li>Otomatik yöntemler (Çerezler, IP adresi, log kayıtları)</li>
</ul>

<p><strong>Hukuki Sebepler (KVKK Madde 5/2):</strong></p>
<ul>
    <li>Açık rızanızın bulunması</li>
    <li>Sözleşmenin kurulması veya ifası için gerekli olması</li>
    <li>Veri sorumlusunun hukuki yükümlülüğünü yerine getirebilmesi için zorunlu olması</li>
    <li>Veri sorumlusunun meşru menfaatleri için veri işlenmesinin zorunlu olması</li>
</ul>

<h2>4. İŞLENEN KİŞİSEL VERİLER</h2>

<table>
    <thead>
        <tr>
            <th>Veri Kategorisi</th>
            <th>Veri Örnekleri</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Kimlik Bilgisi</td>
            <td>Ad, soyad, T.C. kimlik numarası (gerektiğinde)</td>
        </tr>
        <tr>
            <td>İletişim Bilgisi</td>
            <td>Telefon numarası, e-posta adresi, adres</td>
        </tr>
        <tr>
            <td>Müşteri İşlem Bilgisi</td>
            <td>Araç tercihleri, talep detayları, değerleme bilgileri</td>
        </tr>
        <tr>
            <td>İşlem Güvenliği Bilgisi</td>
            <td>IP adresi, çerez kayıtları, log kayıtları</td>
        </tr>
    </tbody>
</table>

<h2>5. KİŞİSEL VERİLERİN AKTARILMASI</h2>

<p>Kişisel verileriniz, KVKK'nın 8. ve 9. maddelerinde belirtilen şartlar dahilinde aşağıdaki kişi ve kuruluşlara aktarılabilir:</p>

<ul>
    <li><strong>İş Ortaklarımız:</strong> Araç tedarikçileri, sigorta şirketleri, ekspertiz firmaları</li>
    <li><strong>Hizmet Sağlayıcılar:</strong> Hosting, bulut depolama, e-posta servisleri</li>
    <li><strong>Resmi Kurumlar:</strong> Yasal yükümlülüklerimiz gereği yetkili kamu kurum ve kuruluşları</li>
    <li><strong>Hukuki Danışmanlar:</strong> Avukatlar, mali müşavirler</li>
</ul>

<h2>6. SAKLAMA SÜRESİ</h2>

<p>Kişisel verileriniz, işleme amacının gerektirdiği süre boyunca ve ilgili mevzuatta öngörülen süreler dahilinde saklanmaktadır:</p>

<ul>
    <li><strong>Müşteri Verileri:</strong> İlişkinin sona ermesinden itibaren 10 yıl</li>
    <li><strong>İletişim Kayıtları:</strong> 2 yıl veya yasal süre</li>
    <li><strong>Çerez ve Log Kayıtları:</strong> 6 ay - 2 yıl arası</li>
    <li><strong>Pazarlama İzinleri:</strong> İzin geri alınana kadar veya 3 yıl</li>
</ul>

<p>Bu süreler sona erdiğinde, kişisel verileriniz silinir, yok edilir veya anonim hale getirilir.</p>

<h2>7. HAKLARINIZ</h2>

<p>KVKK'nın 11. maddesi uyarınca aşağıdaki haklara sahipsiniz:</p>

<ol>
    <li>Kişisel verilerinizin işlenip işlenmediğini öğrenme</li>
    <li>Kişisel verileriniz işlenmişse buna ilişkin bilgi talep etme</li>
    <li>Kişisel verilerin işlenme amacını ve bunların amacına uygun kullanılıp kullanılmadığını öğrenme</li>
    <li>Yurt içinde veya yurt dışında kişisel verilerin aktarıldığı üçüncü kişileri bilme</li>
    <li>Kişisel verilerin eksik veya yanlış işlenmiş olması halinde bunların düzeltilmesini isteme</li>
    <li>KVKK'da öngörülen şartlar çerçevesinde kişisel verilerin silinmesini veya yok edilmesini isteme</li>
    <li>Düzeltme, silme ve yok edilme işlemlerinin aktarıldığı üçüncü kişilere bildirilmesini isteme</li>
    <li>İşlenen verilerin münhasıran otomatik sistemler vasıtasıyla analiz edilmesi suretiyle aleyhinize bir sonucun ortaya çıkmasına itiraz etme</li>
    <li>Kişisel verilerin kanuna aykırı olarak işlenmesi sebebiyle zarara uğramanız halinde zararın giderilmesini talep etme</li>
</ol>

<h2>8. BAŞVURU YOLU</h2>

<p>Haklarınızı kullanmak için aşağıdaki yöntemlerle başvuruda bulunabilirsiniz:</p>

<ul>
    <li><strong>E-posta:</strong> kvkk@gmsgarage.com</li>
    <li><strong>Posta:</strong> [Şirket Adresi] (KVKK Birimi)</li>
    <li><strong>Web Sitesi:</strong> www.gmsgarage.com/kvkk-basvuru</li>
</ul>

<p>Başvurularınız en geç 30 gün içinde sonuçlandırılır.</p>

<h2>9. GÜVENLİK</h2>

<p>GMS Garage olarak, kişisel verilerinizin korunmasına azami özen göstermekteyiz:</p>

<ul>
    <li>SSL Sertifikası ile güvenli veri iletimi</li>
    <li>Düzenli güvenlik taramaları ve güncellemeleri</li>
    <li>Çalışan eğitimleri ve KVKK farkındalık programları</li>
    <li>Yedekleme ve erişim kontrol sistemleri</li>
</ul>

<p><strong>ÖNEMLİ:</strong> GMS Garage hiçbir zaman telefon, e-posta veya SMS yoluyla şifre, kredi kartı bilgisi veya kimlik bilgilerinizi talep etmez.</p>

<h2>10. GÜNCELLEMELER</h2>

<p>Bu Aydınlatma Metni, yasal düzenlemelerdeki değişiklikler veya şirket politikalarımızdaki güncellemeler nedeniyle zaman zaman revize edilebilir.</p>

<p><strong>Son Güncellenme:</strong> Şubat 2026</p>

<p><strong>İletişim:</strong> kvkk@gmsgarage.com</p>

EOT;
    }

    private function getPrivacyPolicyContent()
    {
        return <<<'EOT'
<h2>1. GİRİŞ</h2>

<p>GMS Garage Otomotiv olarak, gizliliğinize verdiğimiz önemi ve kişisel verilerinizin korunmasına yönelik taahhüdümüzü bu Gizlilik Politikası ile açıklıyoruz.</p>

<p>Bu politika, web sitemizi ziyaret ettiğinizde, hizmetlerimizi kullandığınızda ve bizimle iletişime geçtiğinizde hangi bilgileri topladığımızı, bu bilgileri nasıl kullandığımızı ve koruduğumuzu açıklamaktadır.</p>

<h2>2. TOPLANAN BİLGİLER</h2>

<p>Aşağıdaki türdeki bilgileri toplayabiliriz:</p>

<ul>
    <li><strong>Kimlik Bilgileri:</strong> Ad, soyad</li>
    <li><strong>İletişim Bilgileri:</strong> E-posta adresi, telefon numarası, posta adresi</li>
    <li><strong>İşlem Bilgileri:</strong> Araç tercihleri, satın alma geçmişi, değerleme talepleri</li>
    <li><strong>Teknik Bilgiler:</strong> IP adresi, tarayıcı türü, işletim sistemi, çerez verileri</li>
    <li><strong>Kullanım Bilgileri:</strong> Web sitesinde gezinme davranışları, tıklama verileri</li>
</ul>

<h2>3. BİLGİLERİN KULLANIMI</h2>

<p>Topladığımız bilgileri aşağıdaki amaçlarla kullanırız:</p>

<ul>
    <li>Hizmetlerimizi sunmak ve iyileştirmek</li>
    <li>Müşteri destek taleplerini yanıtlamak</li>
    <li>Araç alım-satım işlemlerini gerçekleştirmek</li>
    <li>Pazarlama ve tanıtım faaliyetleri yürütmek (onayınız dahilinde)</li>
    <li>Web sitesi güvenliğini sağlamak</li>
    <li>Yasal yükümlülüklerimizi yerine getirmek</li>
</ul>

<h2>4. BİLGİLERİN PAYLAŞIMI</h2>

<p>Kişisel bilgilerinizi aşağıdaki durumlar dışında üçüncü taraflarla paylaşmayız:</p>

<ul>
    <li>Açık rızanızı aldığımızda</li>
    <li>Yasal yükümlülüklerimizi yerine getirmek için gerekli olduğunda</li>
    <li>Hizmet sağlayıcılarımızla (hosting, analitik, ödeme işlemcileri) - Gizlilik sözleşmeleri kapsamında</li>
    <li>İş ortaklarımızla (araç tedarikçileri, ekspertiz firmaları) - İşlem gereksinimleri için</li>
</ul>

<h2>5. ÇEREZLER</h2>

<p>Web sitemiz, kullanıcı deneyimini iyileştirmek için çerezler kullanmaktadır:</p>

<ul>
    <li><strong>Zorunlu Çerezler:</strong> Web sitesinin temel işlevlerini yerine getirmek için gereklidir</li>
    <li><strong>Analitik Çerezler:</strong> Web sitesi kullanımını analiz etmek ve performansı iyileştirmek için kullanılır</li>
    <li><strong>Pazarlama Çerezleri:</strong> Size özel reklamlar sunmak için kullanılır (onayınız dahilinde)</li>
</ul>

<p>Çerezleri tarayıcı ayarlarınızdan yönetebilir veya silebilirsiniz. Detaylı bilgi için <strong>Çerez Politikamızı</strong> inceleyebilirsiniz.</p>

<h2>6. VERİ GÜVENLİĞİ</h2>

<p>Kişisel bilgilerinizi korumak için aşağıdaki güvenlik önlemlerini alıyoruz:</p>

<ul>
    <li>SSL/TLS şifrelemesi ile güvenli veri iletimi</li>
    <li>Güvenli sunucularda veri depolama</li>
    <li>Erişim kontrol sistemleri</li>
    <li>Düzenli güvenlik denetimleri ve güncellemeleri</li>
    <li>Çalışan eğitimleri ve gizlilik sözleşmeleri</li>
</ul>

<h2>7. HAKLARINIZ</h2>

<p>Kişisel bilgilerinizle ilgili olarak aşağıdaki haklara sahipsiniz:</p>

<ul>
    <li>Kişisel verilerinize erişim talep etme</li>
    <li>Kişisel verilerinizi düzeltme veya güncelleme</li>
    <li>Kişisel verilerinizi silme (unutulma hakkı)</li>
    <li>Veri işlemeye itiraz etme</li>
    <li>Veri taşınabilirliği talep etme</li>
    <li>Pazarlama iletişimlerinden çıkma</li>
</ul>

<p>Bu haklarınızı kullanmak için bizimle iletişime geçebilirsiniz: <strong>info@gmsgarage.com</strong></p>

<h2>8. ÜÇÜNCÜ TARAF LİNKLER</h2>

<p>Web sitemiz, üçüncü taraf web sitelerine linkler içerebilir. Bu sitelerin gizlilik uygulamalarından sorumlu değiliz. Bu siteleri ziyaret ettiğinizde gizlilik politikalarını incelemenizi öneririz.</p>

<h2>9. ÇOCUKLARIN GİZLİLİĞİ</h2>

<p>Hizmetlerimiz 18 yaşın altındaki çocuklara yönelik değildir. Bilerek 18 yaşın altındaki bireylerden kişisel bilgi toplamayız.</p>

<h2>10. POLİTİKA DEĞİŞİKLİKLERİ</h2>

<p>Bu Gizlilik Politikasını zaman zaman güncelleyebiliriz. Değişiklikler web sitemizde yayınlandığında yürürlüğe girer. Önemli değişiklikler için size bildirim gönderilebilir.</p>

<p><strong>Son Güncellenme:</strong> Şubat 2026</p>

<h2>11. İLETİŞİM</h2>

<p>Gizlilik politikamız hakkında sorularınız için:</p>

<ul>
    <li><strong>E-posta:</strong> info@gmsgarage.com</li>
    <li><strong>Telefon:</strong> +90 XXX XXX XX XX</li>
    <li><strong>Adres:</strong> [Şirket Adresi]</li>
</ul>

EOT;
    }

    private function getTermsContent()
    {
        return <<<'EOT'
<h2>1. GENEL HÜKÜMLER</h2>

<p>İşbu Kullanım Şartları ("Şartlar"), GMS Garage Otomotiv ("GMS Garage", "biz", "bizim") tarafından işletilen www.gmsgarage.com web sitesinin kullanımına ilişkin kuralları belirlemektedir.</p>

<p>Web sitemizi ziyaret ederek veya hizmetlerimizi kullanarak, bu Şartları kabul etmiş olursunuz. Şartları kabul etmiyorsanız, lütfen web sitemizi kullanmayınız.</p>

<h2>2. HİZMET TANIMI</h2>

<p>GMS Garage, aşağıdaki hizmetleri sunmaktadır:</p>

<ul>
    <li>İkinci el araç alım-satım hizmetleri</li>
    <li>Araç değerleme ve ekspertiz hizmetleri</li>
    <li>Otomotiv danışmanlık hizmetleri</li>
    <li>Online araç listeleme ve arama platformu</li>
</ul>

<h2>3. KULLANIM KURALLARI</h2>

<p>Web sitemizi kullanırken aşağıdaki kurallara uymanız gerekmektedir:</p>

<ul>
    <li>Doğru, güncel ve eksiksiz bilgi sağlamak</li>
    <li>Yasalara ve bu Şartlara uymak</li>
    <li>Diğer kullanıcıların haklarına saygı göstermek</li>
    <li>Web sitesinin güvenliğini veya işlevselliğini tehlikeye atmamak</li>
    <li>Ticari olmayan amaçlarla kullanmak (izin verilmedikçe)</li>
</ul>

<p><strong>Yasak Faaliyetler:</strong></p>

<ul>
    <li>Sahte veya yanıltıcı bilgi sağlamak</li>
    <li>Web sitesini kötüye kullanmak veya spam göndermek</li>
    <li>Zararlı yazılım veya virüs yüklemek</li>
    <li>Diğer kullanıcıların verilerine yetkisiz erişim sağlamak</li>
    <li>Telif hakkı veya fikri mülkiyet haklarını ihlal etmek</li>
</ul>

<h2>4. ÜCRETLER VE ÖDEME</h2>

<p>Bazı hizmetlerimiz ücretli olabilir. Ücretler web sitesinde açıkça belirtilecektir.</p>

<ul>
    <li>Tüm ödemeler Türk Lirası (TL) üzerinden yapılır</li>
    <li>Ödeme işlemleri güvenli ödeme sağlayıcıları aracılığıyla gerçekleştirilir</li>
    <li>Ücretler KDV dahildir (aksi belirtilmedikçe)</li>
    <li>İptal ve iade koşulları İptal ve İade Politikamızda belirtilmiştir</li>
</ul>

<h2>5. FİKRİ MÜLKİYET HAKLARI</h2>

<p>Web sitesindeki tüm içerik, tasarım, logo, yazılım ve diğer materyaller GMS Garage'ın veya lisans verenlerin mülkiyetindedir ve telif hakkı, ticari marka ve diğer fikri mülkiyet yasalarıyla korunmaktadır.</p>

<p>İzin vermediğimiz sürece, web sitesindeki hiçbir içeriği kopyalayamaz, çoğaltamaz, dağıtamaz veya ticari amaçlarla kullanamazsınız.</p>

<h2>6. SORUMLULUK SINIRLAMASI</h2>

<p>GMS Garage, aşağıdaki durumlardan sorumlu tutulamaz:</p>

<ul>
    <li>Web sitesinin kesintisiz veya hatasız çalışmaması</li>
    <li>Üçüncü taraf web siteleri veya hizmetleri</li>
    <li>Kullanıcılar tarafından sağlanan yanlış veya eksik bilgiler</li>
    <li>Yetkisiz erişim veya veri ihlalleri (makul güvenlik önlemlerine rağmen)</li>
    <li>Dolaylı, arızi veya özel zararlar</li>
</ul>

<p>Hizmetlerimizi "olduğu gibi" sunuyoruz ve herhangi bir garanti vermiyoruz.</p>

<h2>7. TAZMİNAT</h2>

<p>Bu Şartları ihlal etmeniz durumunda, GMS Garage'ı, çalışanlarını, müdürlerini ve iş ortaklarını tüm zarar, kayıp, talep ve masraflardan (avukatlık ücretleri dahil) tazmin etmeyi kabul edersiniz.</p>

<h2>8. HESAP ASKIYA ALMA VE FESİH</h2>

<p>GMS Garage, aşağıdaki durumlarda hesabınızı askıya alma veya feshetme hakkını saklı tutar:</p>

<ul>
    <li>Bu Şartların ihlali</li>
    <li>Yasadışı faaliyetler</li>
    <li>Diğer kullanıcılara zarar verme</li>
    <li>Sahte veya yanıltıcı bilgi sağlama</li>
</ul>

<h2>9. ÜÇÜNCÜ TARAF HİZMETLERİ</h2>

<p>Web sitemiz, üçüncü taraf hizmetlerini (ödeme işlemcileri, analitik araçlar, sosyal medya entegrasyonları) kullanabilir. Bu hizmetlerin kendi şartları ve gizlilik politikaları vardır.</p>

<h2>10. UYGULANACAK HUKUK VE YETKİ</h2>

<p>Bu Şartlar, Türkiye Cumhuriyeti yasalarına tabidir. Bu Şartlardan kaynaklanan uyuşmazlıklar, [İl] Mahkemeleri ve İcra Daireleri'nin münhasır yetkisine tabidir.</p>

<h2>11. ŞARTLARIN DEĞİŞTİRİLMESİ</h2>

<p>GMS Garage, bu Şartları dilediği zaman değiştirme hakkını saklı tutar. Değişiklikler web sitesinde yayınlandığında yürürlüğe girer. Web sitemizi kullanmaya devam ederek, güncellenmiş Şartları kabul etmiş olursunuz.</p>

<h2>12. İLETİŞİM</h2>

<p>Kullanım Şartları hakkında sorularınız için:</p>

<ul>
    <li><strong>E-posta:</strong> info@gmsgarage.com</li>
    <li><strong>Telefon:</strong> +90 XXX XXX XX XX</li>
    <li><strong>Adres:</strong> [Şirket Adresi]</li>
</ul>

<p><strong>Son Güncellenme:</strong> Şubat 2026</p>

EOT;
    }

    private function getCookiePolicyContent()
    {
        return <<<'EOT'
<h2>1. ÇEREZ NEDİR?</h2>

<p>Çerezler, bir web sitesini ziyaret ettiğinizde bilgisayarınıza veya mobil cihazınıza kaydedilen küçük metin dosyalarıdır. Çerezler, web sitelerinin daha verimli çalışmasını sağlar ve web sitesi sahiplerine bilgi sağlar.</p>

<h2>2. ÇEREZ TÜRLERİ</h2>

<p>Web sitemizde kullanılan çerez türleri:</p>

<h3>A. Zorunlu Çerezler</h3>

<p>Bu çerezler, web sitesinin temel işlevlerini yerine getirmek için gereklidir ve kapatılamaz:</p>

<ul>
    <li><strong>Oturum Çerezleri:</strong> Oturumunuzu aktif tutar</li>
    <li><strong>Güvenlik Çerezleri:</strong> Güvenlik özelliklerini etkinleştirir</li>
    <li><strong>Yük Dengeleme Çerezleri:</strong> Web sitesi trafiğini yönetir</li>
</ul>

<h3>B. Performans ve Analitik Çerezler</h3>

<p>Bu çerezler, web sitesinin nasıl kullanıldığını anlamamıza yardımcı olur:</p>

<ul>
    <li><strong>Google Analytics:</strong> Ziyaretçi istatistikleri ve site kullanım bilgileri</li>
    <li><strong>Isı Haritaları:</strong> Kullanıcıların web sitesinde nasıl gezindiğini gösterir</li>
</ul>

<h3>C. İşlevsellik Çerezleri</h3>

<p>Bu çerezler, tercihlerinizi hatırlar ve kişiselleştirilmiş deneyim sunar:</p>

<ul>
    <li><strong>Dil Tercihi:</strong> Seçtiğiniz dili hatırlar</li>
    <li><strong>Tema Tercihi:</strong> Açık/Koyu mod seçiminizi kaydeder</li>
</ul>

<h3>D. Pazarlama ve Reklamcılık Çerezleri</h3>

<p>Bu çerezler, size özel reklamlar göstermek için kullanılır (onayınız dahilinde):</p>

<ul>
    <li><strong>Facebook Pixel:</strong> Facebook reklamlarını optimize eder</li>
    <li><strong>Google Ads:</strong> Google reklamlarını yönetir</li>
    <li><strong>Yeniden Pazarlama:</strong> Daha önce ziyaret ettiğiniz ürünleri hatırlatır</li>
</ul>

<h2>3. KULLANDIĞIMIZ ÇEREZLER</h2>

<table>
    <thead>
        <tr>
            <th>Çerez Adı</th>
            <th>Tür</th>
            <th>Süre</th>
            <th>Amaç</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>PHPSESSID</td>
            <td>Zorunlu</td>
            <td>Oturum</td>
            <td>Oturum yönetimi</td>
        </tr>
        <tr>
            <td>csrf_token</td>
            <td>Zorunlu</td>
            <td>Oturum</td>
            <td>Güvenlik</td>
        </tr>
        <tr>
            <td>_ga</td>
            <td>Analitik</td>
            <td>2 yıl</td>
            <td>Google Analytics - Kullanıcı tanımlama</td>
        </tr>
        <tr>
            <td>_gid</td>
            <td>Analitik</td>
            <td>24 saat</td>
            <td>Google Analytics - Oturum tanımlama</td>
        </tr>
        <tr>
            <td>_fbp</td>
            <td>Pazarlama</td>
            <td>3 ay</td>
            <td>Facebook Pixel</td>
        </tr>
    </tbody>
</table>

<h2>4. ÇEREZLERİ NASIL YÖNETEBİLİRSİNİZ?</h2>

<p>Çerez tercihlerinizi aşağıdaki yöntemlerle yönetebilirsiniz:</p>

<h3>Tarayıcı Ayarları</h3>

<p>Çoğu tarayıcı çerezleri kabul edecek şekilde ayarlanmıştır, ancak çerezleri engellemek veya silmek için tarayıcı ayarlarınızı değiştirebilirsiniz:</p>

<ul>
    <li><strong>Chrome:</strong> Ayarlar > Gizlilik ve güvenlik > Çerezler ve diğer site verileri</li>
    <li><strong>Firefox:</strong> Ayarlar > Gizlilik ve Güvenlik > Çerezler ve Site Verileri</li>
    <li><strong>Safari:</strong> Tercihler > Gizlilik > Çerezleri Yönet</li>
    <li><strong>Edge:</strong> Ayarlar > Çerezler ve site izinleri</li>
</ul>

<h3>Çerez Onay Paneli</h3>

<p>Web sitemizi ilk ziyaretinizde, çerez tercihlerinizi belirlemeniz için bir onay paneli görüntülenir. Tercihlerinizi dilediğiniz zaman değiştirebilirsiniz.</p>

<h2>5. ÇEREZLERİ REDDETME ETKİSİ</h2>

<p>Çerezleri reddetmeniz durumunda:</p>

<ul>
    <li>Bazı web sitesi özellikleri çalışmayabilir</li>
    <li>Tercihleriniz hatırlanmayabilir</li>
    <li>Oturum açma işlevi etkilenebilir</li>
    <li>Kişiselleştirilmiş içerik göremeyebilirsiniz</li>
</ul>

<h2>6. ÜÇÜNCÜ TARAF ÇEREZLERİ</h2>

<p>Web sitemiz, üçüncü taraf hizmetlerden çerezler kullanabilir:</p>

<ul>
    <li><strong>Google Analytics:</strong> <a href="https://policies.google.com/privacy" target="_blank">Google Gizlilik Politikası</a></li>
    <li><strong>Facebook:</strong> <a href="https://www.facebook.com/privacy/explanation" target="_blank">Facebook Veri Politikası</a></li>
    <li><strong>YouTube:</strong> <a href="https://policies.google.com/privacy" target="_blank">YouTube Gizlilik Politikası</a></li>
</ul>

<p>Bu üçüncü taraf çerezler, ilgili şirketlerin gizlilik politikalarına tabidir.</p>

<h2>7. ÇEREZ POLİTİKASI GÜNCELLEMELERİ</h2>

<p>Bu Çerez Politikası zaman zaman güncellenebilir. Değişiklikler web sitesinde yayınlandığında yürürlüğe girer.</p>

<p><strong>Son Güncellenme:</strong> Şubat 2026</p>

<h2>8. İLETİŞİM</h2>

<p>Çerez politikamız hakkında sorularınız için:</p>

<ul>
    <li><strong>E-posta:</strong> info@gmsgarage.com</li>
    <li><strong>Telefon:</strong> +90 XXX XXX XX XX</li>
</ul>

EOT;
    }

    private function getRefundPolicyContent()
    {
        return <<<'EOT'
<h2>1. GENEL HÜKÜMLER</h2>

<p>İşbu İptal ve İade Koşulları, GMS Garage Otomotiv tarafından sunulan hizmetlere ilişkin iptal ve iade prosedürlerini belirlemektedir.</p>

<p>6502 sayılı Tüketicinin Korunması Hakkında Kanun ve Mesafeli Sözleşmeler Yönetmeliği uyarınca düzenlenmiştir.</p>

<h2>2. CAYMA HAKKI</h2>

<p>Tüketiciler, 14 gün içinde herhangi bir gerekçe göstermeksizin ve cezai şart ödemeksizin sözleşmeden cayma hakkına sahiptir.</p>

<p>Cayma hakkının kullanılması için bu süre içinde GMS Garage'a yazılı bildirimde bulunulması gerekmektedir.</p>

<p><strong>Cayma Hakkı Süresi:</strong></p>

<ul>
    <li><strong>Hizmet Sözleşmeleri:</strong> Sözleşmenin kurulduğu günden itibaren 14 gün</li>
    <li><strong>Araç Alımı:</strong> Aracın teslim edildiği günden itibaren 14 gün</li>
</ul>

<h2>3. CAYMA HAKKININ KULLANILAMAYACAĞI HALLER</h2>

<p>Aşağıdaki durumlarda cayma hakkı kullanılamaz:</p>

<ul>
    <li>Tüketicinin onayı ile ifasına başlanan hizmetler</li>
    <li>Tüketicinin istekleri veya açıkça kişisel ihtiyaçları doğrultusunda hazırlanan hizmetler</li>
    <li>Niteliği itibariyle iade edilemeyecek hizmetler</li>
    <li>Cayma hakkı süresi sona erdikten sonra</li>
</ul>

<h2>4. CAYMA HAKKININ KULLANILMASI</h2>

<p>Cayma hakkını kullanmak için aşağıdaki yöntemlerle başvurabilirsiniz:</p>

<ul>
    <li><strong>E-posta:</strong> iade@gmsgarage.com</li>
    <li><strong>Telefon:</strong> +90 XXX XXX XX XX</li>
    <li><strong>Posta:</strong> [Şirket Adresi]</li>
</ul>

<p><strong>Bildirimde Bulunması Gereken Bilgiler:</strong></p>

<ul>
    <li>Ad, soyad</li>
    <li>İletişim bilgileri</li>
    <li>Sözleşme numarası veya fatura bilgileri</li>
    <li>Cayma talebinin nedeni (isteğe bağlı)</li>
</ul>

<h2>5. İADE SÜRECİ</h2>

<p>Cayma bildirimi alındıktan sonra:</p>

<ol>
    <li>Talebiniz 2 iş günü içinde incelenir</li>
    <li>Onay durumunda, ödediğiniz tutar 14 gün içinde iade edilir</li>
    <li>İade, ödemeyi yaptığınız yöntemle yapılır</li>
    <li>İade süreci tamamlandığında e-posta ile bilgilendirilirsiniz</li>
</ol>

<h2>6. ARAÇ ALIMLARINDA İADE KOŞULLARI</h2>

<p>Araç alımlarında iade talebi için:</p>

<ul>
    <li>Araç, teslim alındığı haliyle iade edilmelidir</li>
    <li>Aracın kullanılmamış olması gerekmektedir</li>
    <li>Tüm belgeler ve aksesuarlar eksiksiz olmalıdır</li>
    <li>Hasar veya değer kaybı oluşmamış olmalıdır</li>
</ul>

<p><strong>Önemli Not:</strong> İade sırasında tespit edilen hasar veya değer kaybı, iade tutarından düşülebilir.</p>

<h2>7. ÜCRET İADESİ</h2>

<p>İade onaylandıktan sonra:</p>

<ul>
    <li>Ödeme iade süreci 14 gün içinde başlatılır</li>
    <li>İade, orijinal ödeme yönteminize yapılır</li>
    <li>Kredi kartı ödemeleri: 2-8 iş günü (bankanıza bağlı)</li>
    <li>Banka havalesi: 2-5 iş günü</li>
</ul>

<h2>8. İPTAL VE İADE ÜCRETLERİ</h2>

<p>Geçerli cayma hakkı kullanımında:</p>

<ul>
    <li>İptal ücreti alınmaz</li>
    <li>Ödediğiniz tutar tam olarak iade edilir</li>
    <li>Araç teslimatı yapılmışsa, iade nakliye masrafı müşteriye aittir</li>
</ul>

<h2>9. HİZMET İPTALİ</h2>

<p>Devam eden hizmetler için iptal talebi:</p>

<ul>
    <li>Hizmet başlamadıysa: Tam ücret iadesi</li>
    <li>Hizmet kısmen tamamlandıysa: Tamamlanan kısım ücreti düşülerek iade</li>
    <li>Hizmet tamamlandıysa: İade yapılamaz</li>
</ul>

<h2>10. SORUN ÇÖZÜMÜ</h2>

<p>İade veya iptal talebinizle ilgili sorun yaşarsanız:</p>

<ol>
    <li>Öncelikle müşteri hizmetlerimizle iletişime geçin</li>
    <li>Şikayetinizi yazılı olarak bildirin</li>
    <li>Talep numaranızı saklayın ve takip edin</li>
</ol>

<p>Anlaşmazlık durumunda, Tüketici Hakem Heyetleri'ne veya Tüketici Mahkemelerine başvurabilirsiniz.</p>

<h2>11. İLETİŞİM</h2>

<p>İptal ve iade işlemleri için:</p>

<ul>
    <li><strong>E-posta:</strong> iade@gmsgarage.com</li>
    <li><strong>Telefon:</strong> +90 XXX XXX XX XX</li>
    <li><strong>Adres:</strong> [Şirket Adresi]</li>
    <li><strong>Çalışma Saatleri:</strong> Pazartesi - Cuma, 09:00 - 18:00</li>
</ul>

<p><strong>Son Güncellenme:</strong> Şubat 2026</p>

EOT;
    }

    private function getCommercialConsentContent()
    {
        return <<<'EOT'
<h2>TİCARİ ELEKTRONİK İLETİ AÇIK RIZA METNİ</h2>

<p>6563 sayılı Elektronik Ticaretin Düzenlenmesi Hakkında Kanun uyarınca düzenlenmiştir.</p>

<h2>1. AÇIK RIZA BEYANI</h2>

<p>İşbu metni onaylayarak, <strong>GMS Garage Otomotiv</strong> ("GMS Garage" veya "Şirket") tarafından tarafıma ticari elektronik ileti gönderilmesine açık rıza veriyorum.</p>

<p><strong>Onayladığım İletişim Kanalları:</strong></p>

<ul>
    <li>E-posta (E-mail)</li>
    <li>SMS (Kısa Mesaj)</li>
    <li>Telefon Araması</li>
    <li>Otomatik Arama Makineleri</li>
    <li>WhatsApp ve diğer anlık mesajlaşma uygulamaları</li>
</ul>

<h2>2. GÖNDERİLECEK İLETİLERİN İÇERİĞİ</h2>

<p>Tarafıma aşağıdaki konularda ticari elektronik ileti gönderilebilir:</p>

<ul>
    <li><strong>Ürün ve Hizmet Tanıtımları:</strong> Yeni araç ilanları, ekspertiz hizmetleri, otomotiv danışmanlık</li>
    <li><strong>Kampanya ve İndirimler:</strong> Özel fırsatlar, sezonluk kampanyalar, indirim duyuruları</li>
    <li><strong>Duyurular:</strong> Yeni hizmetler, etkinlik bilgilendirmeleri, önemli güncellemeler</li>
    <li><strong>Anketler ve Geri Bildirim Talepleri:</strong> Memnuniyet anketleri, görüş toplama formları</li>
    <li><strong>Hatırlatmalar:</strong> Randevu hatırlatmaları, araç bakım bildirimleri, yıl dönümü mesajları</li>
</ul>

<h2>3. AÇIK RIZA SÜRESİ</h2>

<p>Bu açık rıza beyanı, geri alınıncaya kadar geçerlidir. Rızanızı istediğiniz zaman geri alabilirsiniz.</p>

<h2>4. KİŞİSEL VERİLERİN İŞLENMESİ</h2>

<p>İletişim bilgileriniz (ad, soyad, e-posta, telefon) KVKK uyarınca güvenli bir şekilde saklanır ve yalnızca ticari elektronik ileti gönderimi amacıyla kullanılır.</p>

<p>Verileriniz, onayınız olmadan üçüncü taraflarla paylaşılmaz.</p>

<h2>5. AÇIK RIZANIN GERİ ALINMASI</h2>

<p>Ticari elektronik ileti almayı istemediğiniz takdirde, rızanızı aşağıdaki yöntemlerle geri alabilirsiniz:</p>

<ul>
    <li><strong>İletideki Ret Linki:</strong> Aldığınız her e-posta veya SMS'teki "Abonelikten Çık" linkine tıklayın</li>
    <li><strong>E-posta:</strong> bilgi@gmsgarage.com adresine "Ticari İleti Ret" konulu e-posta gönderin</li>
    <li><strong>Telefon:</strong> +90 XXX XXX XX XX numaralı hattımızı arayın</li>
    <li><strong>Web Sitesi:</strong> Hesabınıza giriş yaparak iletişim tercihlerinizi güncelleyin</li>
    <li><strong>İYS (İleti Yönetim Sistemi):</strong> https://www.iys.org.tr adresinden ret işlemi yapabilirsiniz</li>
</ul>

<p>Ret işleminiz en geç 3 iş günü içinde sistem tarafımızda güncellenir ve tarafınıza yeni ticari elektronik ileti gönderilmez.</p>

<h2>6. İLETİ SIKLIĞI</h2>

<p>Ticari elektronik iletiler, abonelik tercihinize bağlı olarak aşağıdaki sıklıklarda gönderilebilir:</p>

<ul>
    <li>Kampanya duyuruları: Ayda 2-4 kez</li>
    <li>Yeni araç ilanları: Haftada 1-2 kez</li>
    <li>Önemli duyurular: Gerektiğinde</li>
    <li>Anketler ve geri bildirim talepleri: 3 ayda bir</li>
</ul>

<h2>7. SPAM OLMAYAN İÇERİK</h2>

<p>GMS Garage olarak, gönderdiğimiz tüm ticari elektronik iletilerin:</p>

<ul>
    <li>İçeriğinin açık ve anlaşılır olmasını,</li>
    <li>Spam veya yanıltıcı bilgi içermemesini,</li>
    <li>Yasal düzenlemelere uygun olmasını,</li>
    <li>Ret mekanizmasını kolayca görünür ve erişilebilir olmasını taahhüt ediyoruz.</li>
</ul>

<h2>8. GÜVENLİK</h2>

<p>İletişim bilgileriniz güvenli sunucularda saklanır ve yetkisiz erişime karşı korunur:</p>

<ul>
    <li>SSL/TLS şifrelemesi</li>
    <li>Güvenli veri tabanı sistemleri</li>
    <li>Erişim kontrol mekanizmaları</li>
    <li>Düzenli güvenlik güncellemeleri</li>
</ul>

<h2>9. ÜÇÜNCÜ TARAF PAYLAŞIMI</h2>

<p>İletişim bilgileriniz, açık rızanız olmadan pazarlama amacıyla üçüncü taraflarla paylaşılmaz.</p>

<p>Yalnızca teknik hizmet sağlayıcılarımız (e-posta gönderim servisleri, SMS operatörleri) ile gizlilik sözleşmeleri kapsamında paylaşılır.</p>

<h2>10. ÇOCUKLARIN GİZLİLİĞİ</h2>

<p>18 yaşın altındaki bireylerden ticari elektronik ileti onayı toplamıyoruz. Ebeveyn veya vasi onayı gereklidir.</p>

<h2>11. ONAY TARİHİ VE KAYITLAR</h2>

<p>Açık rıza beyanınız, onay tarihi, IP adresi ve onay kanalı ile birlikte kayıt altına alınır:</p>

<ul>
    <li><strong>Onay Tarihi:</strong> Formun gönderildiği tarih ve saat</li>
    <li><strong>Onay Yöntemi:</strong> Web sitesi formu, mobil uygulama, fiziksel form vb.</li>
    <li><strong>IP Adresi:</strong> Güvenlik ve doğrulama amacıyla</li>
</ul>

<p>Bu kayıtlar, yasal yükümlülüklerimiz gereği 3 yıl süreyle saklanır.</p>

<h2>12. DEĞİŞİKLİKLER</h2>

<p>Bu Açık Rıza Metni, yasal düzenlemelerdeki değişiklikler nedeniyle güncellenebilir. Önemli değişiklikler için tarafınıza bilgilendirme yapılır.</p>

<p><strong>Son Güncellenme:</strong> Şubat 2026</p>

<h2>13. İLETİŞİM</h2>

<p>Ticari elektronik ileti onayı hakkında sorularınız için:</p>

<ul>
    <li><strong>E-posta:</strong> bilgi@gmsgarage.com</li>
    <li><strong>Telefon:</strong> +90 XXX XXX XX XX</li>
    <li><strong>Adres:</strong> [Şirket Adresi]</li>
</ul>

<hr>

<p><strong>ÖNEMLİ:</strong> Bu onay tamamen gönüllüdür. Onay vermemeniz durumunda, GMS Garage hizmetlerinden yararlanmaya devam edebilirsiniz. Ancak kampanya ve özel fırsatlardan haberdar olamayabilirsiniz.</p>

<p><strong>ONAY BEYANI:</strong> İşbu metni okuyup anladığımı ve GMS Garage tarafından tarafıma yukarıda belirtilen kanallardan ticari elektronik ileti gönderilmesine açık rıza verdiğimi beyan ederim.</p>

EOT;
    }
}

