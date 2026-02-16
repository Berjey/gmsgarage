<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LegalPage;
use Illuminate\Support\Str;

class LegalPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $legalPages = [
            [
                'title' => 'KVKK Aydınlatma Metni',
                'slug' => 'kvkk-aydinlatma-metni',
                'content' => $this->getKvkkContent(),
                'is_active' => true,
                'is_required' => true,
                'version' => 1,
            ],
            [
                'title' => 'Gizlilik Politikası',
                'slug' => 'gizlilik-politikasi',
                'content' => $this->getPrivacyPolicyContent(),
                'is_active' => true,
                'is_required' => true,
                'version' => 1,
            ],
            [
                'title' => 'Kullanım Şartları',
                'slug' => 'kullanim-sartlari',
                'content' => $this->getTermsContent(),
                'is_active' => true,
                'is_required' => true,
                'version' => 1,
            ],
            [
                'title' => 'Çerez Politikası',
                'slug' => 'cerez-politikasi',
                'content' => $this->getCookiePolicyContent(),
                'is_active' => true,
                'is_required' => false,
                'version' => 1,
            ],
        ];

        foreach ($legalPages as $page) {
            LegalPage::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }

        $this->command->info('✅ Yasal sayfalar başarıyla güncellendi!');
    }

    private function getKvkkContent()
    {
        return <<<'EOT'
<div style="max-width: 100%; font-family: system-ui, -apple-system, sans-serif; color: #374151; line-height: 1.8;">

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">1. VERİ SORUMLUSU</h2>

<p style="margin-bottom: 1rem;">6698 sayılı Kişisel Verilerin Korunması Kanunu ("KVKK") uyarınca, <strong>GMS Garage Otomotiv</strong> (bundan böyle "GMS Garage" veya "Şirket" olarak anılacaktır) olarak kişisel verileriniz veri sorumlusu sıfatıyla tarafımızca aşağıda açıklanan kapsamda işlenebilecektir.</p>

<p style="margin-bottom: 1rem;"><strong>İletişim Bilgilerimiz:</strong></p>
<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">E-posta: info@gmsgarage.com</li>
    <li style="margin-bottom: 0.5rem;">Telefon: +90 XXX XXX XX XX</li>
    <li style="margin-bottom: 0.5rem;">Adres: [Şirket Adresi]</li>
</ul>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">2. KİŞİSEL VERİLERİNİZİN İŞLENME AMACI</h2>

<p style="margin-bottom: 1rem;">Toplanan kişisel verileriniz aşağıdaki amaçlarla işlenmektedir:</p>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;"><strong>Araç Alım-Satım Süreçlerinin Yürütülmesi:</strong> Araç alım, satım, değerleme ve danışmanlık hizmetlerinin sunulması</li>
    <li style="margin-bottom: 0.5rem;"><strong>Müşteri İlişkileri Yönetimi:</strong> Müşteri memnuniyetinin sağlanması, talep ve şikayetlerin yönetimi</li>
    <li style="margin-bottom: 0.5rem;"><strong>İletişim Faaliyetleri:</strong> Sizinle iletişime geçilmesi, bilgilendirme mesajları gönderilmesi</li>
    <li style="margin-bottom: 0.5rem;"><strong>Pazarlama ve Tanıtım:</strong> Ürün ve hizmetlerimiz hakkında bilgilendirme, kampanya duyuruları (açık rızanız dahilinde)</li>
    <li style="margin-bottom: 0.5rem;"><strong>Hukuki Yükümlülüklerin Yerine Getirilmesi:</strong> Yasal düzenlemelerin gerektirdiği bilgi ve belgelerin hazırlanması</li>
    <li style="margin-bottom: 0.5rem;"><strong>Güvenlik ve İstatistiksel Analiz:</strong> Web sitesi güvenliğinin sağlanması, kullanıcı deneyiminin iyileştirilmesi</li>
    <li style="margin-bottom: 0.5rem;"><strong>CRM ve Veri Tabanı Yönetimi:</strong> Müşteri portföyünün yönetilmesi, veri tabanının güncellenmesi</li>
</ul>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">3. KİŞİSEL VERİLERİN TOPLANMA YÖNTEMİ VE HUKUKİ SEBEPLERİ</h2>

<p style="margin-bottom: 1rem;">Kişisel verileriniz aşağıdaki yöntemlerle toplanmaktadır:</p>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">Web sitemiz (www.gmsgarage.com) üzerindeki formlar (İletişim, Araç İsteği, Değerleme)</li>
    <li style="margin-bottom: 0.5rem;">E-posta ve telefon iletişimi</li>
    <li style="margin-bottom: 0.5rem;">Fiziksel ziyaretler ve görüşmeler</li>
    <li style="margin-bottom: 0.5rem;">Sosyal medya platformları</li>
    <li style="margin-bottom: 0.5rem;">Otomatik yöntemler (Çerezler, IP adresi kaydı, log kayıtları)</li>
</ul>

<p style="margin-bottom: 1rem;"><strong>Hukuki Sebepler (KVKK Madde 5/2):</strong></p>
<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">Açık rızanızın bulunması (a)</li>
    <li style="margin-bottom: 0.5rem;">Sözleşmenin kurulması veya ifası için gerekli olması (c)</li>
    <li style="margin-bottom: 0.5rem;">Veri sorumlusunun hukuki yükümlülüğünü yerine getirebilmesi için zorunlu olması (ç)</li>
    <li style="margin-bottom: 0.5rem;">Veri sorumlusunun meşru menfaatleri için veri işlenmesinin zorunlu olması (f)</li>
</ul>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">4. İŞLENEN KİŞİSEL VERİ KATEGORİLERİ</h2>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; border: 1px solid #e5e7eb;">
    <thead style="background-color: #f3f4f6;">
        <tr>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb; font-weight: 600;">Veri Kategorisi</th>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb; font-weight: 600;">Veri Örnekleri</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Kimlik Bilgisi</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Ad, soyad, T.C. kimlik numarası (gerektiğinde)</td>
        </tr>
        <tr style="background-color: #f9fafb;">
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">İletişim Bilgisi</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Telefon numarası, e-posta adresi, adres</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Müşteri İşlem Bilgisi</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Araç tercihleri, talep detayları, değerleme bilgileri</td>
        </tr>
        <tr style="background-color: #f9fafb;">
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">İşlem Güvenliği Bilgisi</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">IP adresi, çerez kayıtları, log kayıtları</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Pazarlama Bilgisi</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Tercihler, ilgi alanları, kampanya katılımları</td>
        </tr>
        <tr style="background-color: #f9fafb;">
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Hukuki İşlem Bilgisi</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Sözleşme bilgileri, onay kayıtları, versiyon bilgileri</td>
        </tr>
    </tbody>
</table>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">5. KİŞİSEL VERİLERİN AKTARILMASI</h2>

<p style="margin-bottom: 1rem;">Kişisel verileriniz, KVKK'nın 8. ve 9. maddelerinde belirtilen şartlar dahilinde aşağıdaki kişi ve kuruluşlara aktarılabilir:</p>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;"><strong>İş Ortaklarımız:</strong> Araç tedarikçileri, sigorta şirketleri, ekspertiz firmaları</li>
    <li style="margin-bottom: 0.5rem;"><strong>Hizmet Sağlayıcılar:</strong> Hosting, bulut depolama, e-posta servisleri, analitik hizmetler</li>
    <li style="margin-bottom: 0.5rem;"><strong>Resmi Kurumlar:</strong> Yasal yükümlülüklerimiz gereği yetkili kamu kurum ve kuruluşları</li>
    <li style="margin-bottom: 0.5rem;"><strong>Hukuki Danışmanlar:</strong> Avukatlar, mali müşavirler</li>
</ul>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">6. KİŞİSEL VERİLERİN SAKLANMA SÜRESİ</h2>

<p style="margin-bottom: 1rem;">Kişisel verileriniz, işleme amacının gerektirdiği süre boyunca ve ilgili mevzuatta öngörülen süreler dahilinde saklanmaktadır:</p>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;"><strong>Müşteri Verileri:</strong> İlişkinin sona ermesinden itibaren 10 yıl (Vergi mevzuatı gereği)</li>
    <li style="margin-bottom: 0.5rem;"><strong>İletişim Kayıtları:</strong> 2 yıl veya yasal süre</li>
    <li style="margin-bottom: 0.5rem;"><strong>Çerez ve Log Kayıtları:</strong> 6 ay - 2 yıl arası</li>
    <li style="margin-bottom: 0.5rem;"><strong>Pazarlama İzinleri:</strong> İzin geri alınana kadar veya 3 yıl</li>
</ul>

<p style="margin-bottom: 1rem;">Bu süreler sona erdiğinde, kişisel verileriniz silinir, yok edilir veya anonim hale getirilir.</p>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">7. KVKK KAPSAMINDA HAKLARINIZ</h2>

<p style="margin-bottom: 1rem;">KVKK'nın 11. maddesi uyarınca aşağıdaki haklara sahipsiniz:</p>

<div style="background-color: #fef2f2; border-left: 4px solid #dc2626; padding: 1rem; margin-bottom: 1rem;">
    <ol style="margin-left: 1rem;">
        <li style="margin-bottom: 0.75rem;">Kişisel verilerinizin işlenip işlenmediğini öğrenme</li>
        <li style="margin-bottom: 0.75rem;">Kişisel verileriniz işlenmişse buna ilişkin bilgi talep etme</li>
        <li style="margin-bottom: 0.75rem;">Kişisel verilerin işlenme amacını ve bunların amacına uygun kullanılıp kullanılmadığını öğrenme</li>
        <li style="margin-bottom: 0.75rem;">Yurt içinde veya yurt dışında kişisel verilerin aktarıldığı üçüncü kişileri bilme</li>
        <li style="margin-bottom: 0.75rem;">Kişisel verilerin eksik veya yanlış işlenmiş olması halinde bunların düzeltilmesini isteme</li>
        <li style="margin-bottom: 0.75rem;">KVKK'da öngörülen şartlar çerçevesinde kişisel verilerin silinmesini veya yok edilmesini isteme</li>
        <li style="margin-bottom: 0.75rem;">Düzeltme, silme ve yok edilme işlemlerinin aktarıldığı üçüncü kişilere bildirilmesini isteme</li>
        <li style="margin-bottom: 0.75rem;">İşlenen verilerin münhasıran otomatik sistemler vasıtasıyla analiz edilmesi suretiyle aleyhinize bir sonucun ortaya çıkmasına itiraz etme</li>
        <li style="margin-bottom: 0.75rem;">Kişisel verilerin kanuna aykırı olarak işlenmesi sebebiyle zarara uğramanız halinde zararın giderilmesini talep etme</li>
    </ol>
</div>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">8. BAŞVURU YOLLARI</h2>

<p style="margin-bottom: 1rem;">Yukarıda belirtilen haklarınızı kullanmak için aşağıdaki yollarla başvurabilirsiniz:</p>

<div style="background-color: #f3f4f6; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 1rem;">
    <p style="margin-bottom: 0.75rem;"><strong>📧 E-posta:</strong> kvkk@gmsgarage.com</p>
    <p style="margin-bottom: 0.75rem;"><strong>📝 Yazılı Başvuru:</strong> [Şirket Adresi]</p>
    <p style="margin-bottom: 0.75rem;"><strong>🌐 Online Form:</strong> www.gmsgarage.com/kvkk-basvuru</p>
    <p style="margin-bottom: 0;"><strong>📱 KEP Adresi:</strong> [KEP Adresi]</p>
</div>

<p style="margin-bottom: 1rem;"><strong>Başvurunuzda Bulunması Gereken Bilgiler:</strong></p>
<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">Adınız, soyadınız</li>
    <li style="margin-bottom: 0.5rem;">T.C. kimlik numaranız</li>
    <li style="margin-bottom: 0.5rem;">Tebligata esas yerleşim yeri veya iş yeri adresi</li>
    <li style="margin-bottom: 0.5rem;">Varsa e-posta adresi, telefon veya faks numarası</li>
    <li style="margin-bottom: 0.5rem;">Talep konusu</li>
</ul>

<p style="margin-bottom: 1rem;">Başvurularınız, talebin niteliğine göre <strong>en geç 30 gün</strong> içinde ücretsiz olarak sonuçlandırılacaktır. İşlemin ayrıca bir maliyet gerektirmesi halinde, Kişisel Verileri Koruma Kurulu tarafından belirlenen tarifedeki ücret alınabilir.</p>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">9. VERİ GÜVENLİĞİ</h2>

<p style="margin-bottom: 1rem;">GMS Garage olarak, kişisel verilerinizin güvenliğini sağlamak için gerekli tüm teknik ve idari tedbirleri almaktayız:</p>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">SSL sertifikası ile şifreli veri iletimi</li>
    <li style="margin-bottom: 0.5rem;">Güvenli sunucularda veri depolama</li>
    <li style="margin-bottom: 0.5rem;">Yetkilendirme ve erişim kontrol sistemleri</li>
    <li style="margin-bottom: 0.5rem;">Düzenli güvenlik güncellemeleri ve testler</li>
    <li style="margin-bottom: 0.5rem;">Çalışan eğitimleri ve gizlilik sözleşmeleri</li>
</ul>

<div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-top: 2rem;">
    <p style="margin: 0; font-size: 0.875rem; color: #1e40af;"><strong>ℹ️ Güncellemeler:</strong> Bu aydınlatma metni, yasal düzenlemelerdeki değişiklikler veya şirket politikalarımızdaki güncellemeler nedeniyle zaman zaman revize edilebilir. Güncel versiyonu web sitemizden takip edebilirsiniz.</p>
</div>

<p style="margin-top: 2rem; text-align: center; color: #6b7280; font-size: 0.875rem;"><em>Son Güncelleme: Şubat 2026 | Versiyon: 1.0</em></p>

</div>
EOT;
    }

    private function getPrivacyPolicyContent()
    {
        return <<<'EOT'
<div style="max-width: 100%; font-family: system-ui, -apple-system, sans-serif; color: #374151; line-height: 1.8;">

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">1. GİRİŞ</h2>

<p style="margin-bottom: 1rem;">GMS Garage Otomotiv ("GMS Garage", "biz", "bizim") olarak, gizliliğinize verdiğimiz önemi ve kişisel verilerinizin korunmasına yönelik taahhüdümüzü bu Gizlilik Politikası ile açıklıyoruz.</p>

<p style="margin-bottom: 1rem;">Bu politika, <strong>www.gmsgarage.com</strong> web sitesini ziyaret ettiğinizde, hizmetlerimizi kullandığınızda veya bizimle iletişime geçtiğinizde kişisel bilgilerinizin nasıl toplandığını, kullanıldığını, saklandığını ve korunduğunu detaylı olarak açıklamaktadır.</p>

<div style="background-color: #fef2f2; border-left: 4px solid #dc2626; padding: 1rem; margin-bottom: 1.5rem;">
    <p style="margin: 0;"><strong>⚠️ Önemli:</strong> Web sitemizi kullanarak bu Gizlilik Politikası'nı okuduğunuzu, anladığınızı ve kabul ettiğinizi beyan etmiş olursunuz.</p>
</div>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">2. TOPLANAN BİLGİLER</h2>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">2.1. Doğrudan Topladığımız Bilgiler</h3>

<p style="margin-bottom: 1rem;">Web sitemizi kullanırken aşağıdaki bilgileri bizimle paylaşabilirsiniz:</p>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;"><strong>Kimlik Bilgileri:</strong> Ad, soyad</li>
    <li style="margin-bottom: 0.5rem;"><strong>İletişim Bilgileri:</strong> E-posta adresi, telefon numarası, adres</li>
    <li style="margin-bottom: 0.5rem;"><strong>Araç Bilgileri:</strong> İlgilendiğiniz veya sahip olduğunuz araç detayları</li>
    <li style="margin-bottom: 0.5rem;"><strong>Talep ve Tercihler:</strong> Araç değerleme talepleri, özel istekler, bütçe bilgisi</li>
    <li style="margin-bottom: 0.5rem;"><strong>İletişim İçeriği:</strong> Bizimle paylaştığınız mesajlar, yorumlar ve geri bildirimler</li>
</ul>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">2.2. Otomatik Olarak Toplanan Bilgiler</h3>

<p style="margin-bottom: 1rem;">Web sitemizi ziyaret ettiğinizde aşağıdaki teknik bilgiler otomatik olarak toplanır:</p>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; border: 1px solid #e5e7eb;">
    <thead style="background-color: #f3f4f6;">
        <tr>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb;">Bilgi Türü</th>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb;">Açıklama</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">IP Adresi</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">İnternet servis sağlayıcınız tarafından atanan benzersiz numara</td>
        </tr>
        <tr style="background-color: #f9fafb;">
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Tarayıcı Bilgisi</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Tarayıcı türü, versiyonu, dil tercihi</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Cihaz Bilgisi</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">İşletim sistemi, ekran çözünürlüğü, cihaz türü</td>
        </tr>
        <tr style="background-color: #f9fafb;">
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Ziyaret Bilgisi</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Ziyaret edilen sayfalar, tıklamalar, geçirilen süre</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Referans URL</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Sitemize hangi sayfadan geldiğiniz</td>
        </tr>
    </tbody>
</table>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">3. BİLGİLERİN KULLANIM AMAÇLARI</h2>

<p style="margin-bottom: 1rem;">Topladığımız bilgileri aşağıdaki amaçlarla kullanıyoruz:</p>

<div style="display: grid; gap: 1rem; margin-bottom: 1.5rem;">
    <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0; color: #166534; font-weight: 600;">✓ Hizmet Sunumu</h4>
        <p style="margin: 0; font-size: 0.875rem;">Araç alım, satım, değerleme ve danışmanlık hizmetlerinin sunulması, taleplerinizin karşılanması</p>
    </div>
    
    <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0; color: #1e40af; font-weight: 600;">✓ İletişim ve Destek</h4>
        <p style="margin: 0; font-size: 0.875rem;">Sorularınızı yanıtlama, müşteri desteği sağlama, bilgilendirme mesajları gönderme</p>
    </div>
    
    <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0; color: #92400e; font-weight: 600;">✓ Pazarlama (İzninizle)</h4>
        <p style="margin: 0; font-size: 0.875rem;">Ürün ve hizmetlerimiz hakkında bilgilendirme, özel teklifler ve kampanya duyuruları</p>
    </div>
    
    <div style="background-color: #f5f3ff; border-left: 4px solid #8b5cf6; padding: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0; color: #5b21b6; font-weight: 600;">✓ İyileştirme ve Analiz</h4>
        <p style="margin: 0; font-size: 0.875rem;">Web sitesi performansının artırılması, kullanıcı deneyiminin iyileştirilmesi, istatistiksel analizler</p>
    </div>
    
    <div style="background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0; color: #991b1b; font-weight: 600;">✓ Güvenlik ve Yasal Yükümlülükler</h4>
        <p style="margin: 0; font-size: 0.875rem;">Dolandırıcılık önleme, güvenlik tedbirleri, yasal düzenlemelere uyum</p>
    </div>
</div>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">4. BİLGİ GÜVENLİĞİ</h2>

<p style="margin-bottom: 1rem;">Kişisel verilerinizi korumak için endüstri standardı güvenlik önlemleri kullanıyoruz:</p>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">🔒 <strong>SSL/TLS Şifreleme:</strong> Tüm veri iletimi 256-bit SSL sertifikası ile şifrelenir</li>
    <li style="margin-bottom: 0.5rem;">🛡️ <strong>Güvenli Sunucular:</strong> Verileriniz güncel güvenlik protokolleriyle korunan sunucularda saklanır</li>
    <li style="margin-bottom: 0.5rem;">🔐 <strong>Erişim Kontrolü:</strong> Kişisel verilere sadece yetkili personel erişebilir</li>
    <li style="margin-bottom: 0.5rem;">🔄 <strong>Düzenli Yedekleme:</strong> Veri kaybını önlemek için düzenli yedekleme yapılır</li>
    <li style="margin-bottom: 0.5rem;">🔍 <strong>Güvenlik Testleri:</strong> Sistemlerimiz düzenli olarak güvenlik açıklarına karşı test edilir</li>
    <li style="margin-bottom: 0.5rem;">📚 <strong>Personel Eğitimi:</strong> Çalışanlarımız veri güvenliği konusunda düzenli eğitim alır</li>
</ul>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">5. ÜÇÜNCÜ TARAFLARLA PAYLAŞIM</h2>

<p style="margin-bottom: 1rem;">Kişisel bilgilerinizi, aşağıdaki durumlar dışında üçüncü taraflarla <strong>satmıyor, kiralamıyor veya paylaşmıyoruz:</strong></p>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">5.1. Hizmet Sağlayıcılar</h3>
<p style="margin-bottom: 1rem;">Hizmetlerimizi sunmak için çalıştığımız güvenilir üçüncü taraf hizmet sağlayıcılar:</p>
<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">Hosting ve sunucu hizmetleri</li>
    <li style="margin-bottom: 0.5rem;">E-posta servisleri</li>
    <li style="margin-bottom: 0.5rem;">Analitik hizmetler (Google Analytics vb.)</li>
    <li style="margin-bottom: 0.5rem;">CRM ve müşteri yönetim sistemleri</li>
</ul>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">5.2. İş Ortakları</h3>
<p style="margin-bottom: 1rem;">Hizmet kalitesini artırmak için:</p>
<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">Araç tedarikçileri ve oto galeriler</li>
    <li style="margin-bottom: 0.5rem;">Sigorta şirketleri</li>
    <li style="margin-bottom: 0.5rem;">Ekspertiz ve değerleme firmaları</li>
</ul>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">5.3. Yasal Zorunluluklar</h3>
<p style="margin-bottom: 1rem;">Aşağıdaki durumlarda bilgilerinizi paylaşabiliriz:</p>
<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">Yasal düzenlemelerin gerektirdiği hallerde</li>
    <li style="margin-bottom: 0.5rem;">Mahkeme kararı veya resmi talep olması durumunda</li>
    <li style="margin-bottom: 0.5rem;">Haklarımızı, güvenliğimizi veya mülkiyetimizi korumak için gerekli olduğunda</li>
</ul>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">6. ÇEREZLER (COOKIES)</h2>

<p style="margin-bottom: 1rem;">Web sitemiz, kullanıcı deneyimini iyileştirmek için çerezler kullanmaktadır. Detaylı bilgi için <a href="/sayfa/cerez-politikasi" style="color: #dc2626; text-decoration: underline;">Çerez Politikası</a> sayfamızı ziyaret edebilirsiniz.</p>

<p style="margin-bottom: 1rem;">Tarayıcı ayarlarınızdan çerezleri yönetebilir veya reddedebilirsiniz. Ancak, çerezleri devre dışı bırakmanız web sitesinin bazı özelliklerinin düzgün çalışmamasına neden olabilir.</p>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">7. VERİ SAKLAMA SÜRESİ</h2>

<p style="margin-bottom: 1rem;">Kişisel verilerinizi, toplandıkları amaç için gerekli olduğu sürece ve yasal saklama süreleri boyunca saklarız:</p>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;"><strong>Müşteri Kayıtları:</strong> İlişkinin sona ermesinden itibaren 10 yıl</li>
    <li style="margin-bottom: 0.5rem;"><strong>İletişim Kayıtları:</strong> 2 yıl</li>
    <li style="margin-bottom: 0.5rem;"><strong>Pazarlama İzinleri:</strong> İzin geri alınana kadar veya 3 yıl</li>
    <li style="margin-bottom: 0.5rem;"><strong>Çerez ve Log Dosyaları:</strong> 6 ay - 2 yıl</li>
</ul>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">8. HAKLARINIZ</h2>

<p style="margin-bottom: 1rem;">Gizliliğinizle ilgili aşağıdaki haklara sahipsiniz:</p>

<div style="background-color: #f0fdf4; border: 1px solid #86efac; border-radius: 0.5rem; padding: 1.5rem; margin-bottom: 1.5rem;">
    <ul style="margin: 0; padding-left: 1.5rem;">
        <li style="margin-bottom: 0.75rem;">✓ Hangi kişisel verilerinize sahip olduğumuzu öğrenme</li>
        <li style="margin-bottom: 0.75rem;">✓ Kişisel verilerinizin bir kopyasını talep etme</li>
        <li style="margin-bottom: 0.75rem;">✓ Yanlış veya eksik bilgilerin düzeltilmesini isteme</li>
        <li style="margin-bottom: 0.75rem;">✓ Kişisel verilerinizin silinmesini talep etme</li>
        <li style="margin-bottom: 0.75rem;">✓ Veri işleme faaliyetlerine itiraz etme</li>
        <li style="margin-bottom: 0.75rem;">✓ Pazarlama iletişimlerinden çıkma (opt-out)</li>
    </ul>
</div>

<p style="margin-bottom: 1rem;">Haklarınızı kullanmak için bizimle <strong>info@gmsgarage.com</strong> adresinden iletişime geçebilirsiniz.</p>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">9. ÇOCUKLARIN GİZLİLİĞİ</h2>

<p style="margin-bottom: 1rem;">Web sitemiz ve hizmetlerimiz 18 yaş altındaki kişilere yönelik değildir. Bilerek 18 yaş altındaki bireylerden kişisel bilgi toplamıyoruz. Eğer 18 yaşından küçükseniz, lütfen web sitemizi kullanmayın ve bizimle kişisel bilgi paylaşmayın.</p>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">10. POLİTİKA DEĞİŞİKLİKLERİ</h2>

<p style="margin-bottom: 1rem;">Bu Gizlilik Politikası'nı zaman zaman güncelleyebiliriz. Önemli değişiklikler yapıldığında, bu değişiklikleri web sitemizde yayınlayarak ve/veya size e-posta göndererek bildiririz. Bu sayfayı düzenli olarak ziyaret ederek güncellemelerden haberdar olmanızı öneririz.</p>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">11. İLETİŞİM</h2>

<p style="margin-bottom: 1rem;">Gizlilik Politikamız veya kişisel verilerinizin işlenmesi hakkında sorularınız varsa, lütfen bizimle iletişime geçin:</p>

<div style="background-color: #f3f4f6; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem;">
    <p style="margin-bottom: 0.75rem;"><strong>GMS Garage Otomotiv</strong></p>
    <p style="margin-bottom: 0.75rem;">📧 <strong>E-posta:</strong> info@gmsgarage.com</p>
    <p style="margin-bottom: 0.75rem;">📧 <strong>Gizlilik İletişim:</strong> privacy@gmsgarage.com</p>
    <p style="margin-bottom: 0.75rem;">📞 <strong>Telefon:</strong> +90 XXX XXX XX XX</p>
    <p style="margin-bottom: 0.75rem;">📍 <strong>Adres:</strong> [Şirket Adresi]</p>
    <p style="margin-bottom: 0;">🌐 <strong>Website:</strong> www.gmsgarage.com</p>
</div>

<div style="background-color: #eff6ff; border: 1px solid #93c5fd; border-radius: 0.5rem; padding: 1rem; margin-top: 2rem;">
    <p style="margin: 0; font-size: 0.875rem; color: #1e40af;">
        <strong>📢 Not:</strong> Bu politika, KVKK (6698 sayılı Kişisel Verilerin Korunması Kanunu) ve ilgili mevzuata uygun olarak hazırlanmıştır. Yasal haklarınız hakkında daha fazla bilgi için KVKK Aydınlatma Metni'mizi inceleyebilirsiniz.
    </p>
</div>

<p style="margin-top: 2rem; text-align: center; color: #6b7280; font-size: 0.875rem;"><em>Son Güncelleme: Şubat 2026 | Versiyon: 1.0</em></p>

</div>
EOT;
    }

    private function getTermsContent()
    {
        return <<<'EOT'
<div style="max-width: 100%; font-family: system-ui, -apple-system, sans-serif; color: #374151; line-height: 1.8;">

<div style="background-color: #fef2f2; border: 2px solid #dc2626; border-radius: 0.5rem; padding: 1.5rem; margin-bottom: 2rem;">
    <h3 style="margin: 0 0 0.75rem 0; color: #dc2626; font-size: 1.25rem; font-weight: 700;">⚖️ Önemli Hukuki Uyarı</h3>
    <p style="margin: 0; font-size: 0.875rem;">İşbu Kullanım Şartları, GMS Garage web sitesinin (www.gmsgarage.com) kullanımına ilişkin hukuki bir sözleşme niteliğindedir. Sitemizi kullanarak bu şartları kabul etmiş sayılırsınız.</p>
</div>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">1. TANIMLAR</h2>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; border: 1px solid #e5e7eb;">
    <tbody>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb; font-weight: 600; background-color: #f9fafb; width: 30%;">Şirket / Biz</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">GMS Garage Otomotiv</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb; font-weight: 600; background-color: #f9fafb;">Web Sitesi / Site</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">www.gmsgarage.com alan adı ve tüm alt sayfaları</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb; font-weight: 600; background-color: #f9fafb;">Kullanıcı / Siz</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Web sitemizi ziyaret eden veya hizmetlerimizi kullanan gerçek veya tüzel kişi</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb; font-weight: 600; background-color: #f9fafb;">Hizmetler</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Araç alım-satım, değerleme, danışmanlık ve web sitesi üzerinden sunulan tüm hizmetler</td>
        </tr>
    </tbody>
</table>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">2. GENEL HÜKÜMLER</h2>

<p style="margin-bottom: 1rem;">İşbu Kullanım Şartları, GMS Garage web sitesinin kullanımına ilişkin koşulları düzenlemektedir. Web sitemizi ziyaret ederek veya hizmetlerimizi kullanarak:</p>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">✓ Bu şartları okuduğunuzu ve anladığınızı</li>
    <li style="margin-bottom: 0.5rem;">✓ Bu şartlara uymayı kabul ettiğinizi</li>
    <li style="margin-bottom: 0.5rem;">✓ Türkiye Cumhuriyeti yasalarına tabi olduğunuzu</li>
    <li style="margin-bottom: 0.5rem;">✓ 18 yaşından büyük olduğunuzu</li>
</ul>

<p style="margin-bottom: 1rem;">beyan ve taahhüt etmiş sayılırsınız.</p>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">3. HİZMETLERİMİZ</h2>

<p style="margin-bottom: 1rem;">GMS Garage olarak sunduğumuz hizmetler:</p>

<div style="display: grid; gap: 1rem; margin-bottom: 1.5rem;">
    <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0; color: #166534; font-weight: 600;">🚗 Araç Alım-Satım</h4>
        <p style="margin: 0; font-size: 0.875rem;">İkinci el araç alım satım aracılığı, araç portföyü sergileme</p>
    </div>
    
    <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0; color: #1e40af; font-weight: 600;">📊 Araç Değerleme</h4>
        <p style="margin: 0; font-size: 0.875rem;">Profesyonel araç değerleme ve ekspertiz hizmetleri</p>
    </div>
    
    <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0; color: #92400e; font-weight: 600;">💼 Danışmanlık</h4>
        <p style="margin: 0; font-size: 0.875rem;">Araç alım satım sürecinde uzman danışmanlık desteği</p>
    </div>
    
    <div style="background-color: #f5f3ff; border-left: 4px solid #8b5cf6; padding: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0; color: #5b21b6; font-weight: 600;">🔍 Araç Arama</h4>
        <p style="margin: 0; font-size: 0.875rem;">Özel talep araç bulma ve aracılık hizmetleri</p>
    </div>
</div>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">4. KULLANICI SORUMLULUKLARI</h2>

<p style="margin-bottom: 1rem;">Web sitemizi kullanırken aşağıdaki kurallara uymayı taahhüt edersiniz:</p>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">4.1. Yapmanız Gerekenler</h3>
<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">✓ Doğru ve güncel bilgiler vermek</li>
    <li style="margin-bottom: 0.5rem;">✓ Yasalara ve bu kullanım şartlarına uymak</li>
    <li style="margin-bottom: 0.5rem;">✓ Başkalarının haklarına saygı göstermek</li>
    <li style="margin-bottom: 0.5rem;">✓ Güvenlik ve gizlilik kurallarına riayet etmek</li>
</ul>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">4.2. Yapmamanız Gerekenler</h3>
<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">✗ Yanlış veya yanıltıcı bilgi vermek</li>
    <li style="margin-bottom: 0.5rem;">✗ Başkalarının kimliğine bürünmek</li>
    <li style="margin-bottom: 0.5rem;">✗ Yasadışı veya zararlı içerik paylaşmak</li>
    <li style="margin-bottom: 0.5rem;">✗ Virüs veya zararlı yazılım göndermek</li>
    <li style="margin-bottom: 0.5rem;">✗ Sistemi kötüye kullanmak veya sabote etmeye çalışmak</li>
    <li style="margin-bottom: 0.5rem;">✗ İçerikleri izinsiz kopyalamak veya çoğaltmak</li>
</ul>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">5. FİKRİ MÜLKİYET HAKLARI</h2>

<p style="margin-bottom: 1rem;">Web sitemizdeki tüm içerik GMS Garage'ın mülkiyetindedir ve fikri mülkiyet yasaları ile korunmaktadır:</p>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">© <strong>Logo ve Marka:</strong> GMS Garage logosu ve markası tescilli ticari markalardır</li>
    <li style="margin-bottom: 0.5rem;">📝 <strong>Metin ve Yazılı İçerik:</strong> Tüm metinler, açıklamalar ve blog yazıları telif hakkı ile korunmaktadır</li>
    <li style="margin-bottom: 0.5rem;">📸 <strong>Görseller ve Fotoğraflar:</strong> Araç fotoğrafları ve tasarım öğeleri izinsiz kullanılamaz</li>
    <li style="margin-bottom: 0.5rem;">💻 <strong>Yazılım ve Kod:</strong> Web sitesi kaynak kodu ve yazılım bileşenleri korumalıdır</li>
    <li style="margin-bottom: 0.5rem;">🎨 <strong>Tasarım ve Grafik:</strong> Tasarım öğeleri, düzen ve grafik unsurlar telif hakkına tabidir</li>
</ul>

<div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 0.5rem; padding: 1rem; margin-bottom: 1.5rem;">
    <p style="margin: 0; font-size: 0.875rem; color: #991b1b;"><strong>⚠️ Uyarı:</strong> İzinsiz kullanım, çoğaltma veya dağıtım cezai ve hukuki yaptırımlara tabidir. 5846 sayılı Fikir ve Sanat Eserleri Kanunu uyarınca işlem yapılabilir.</p>
</div>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">6. ARAÇ ALIM-SATIM ŞARTLARI</h2>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">6.1. Araç Bilgileri ve Gösterim</h3>
<p style="margin-bottom: 1rem;">Web sitemizde sergilenen araçlarla ilgili:</p>
<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">Tüm araçlar profesyonel ekspertiz raporuyla sunulur</li>
    <li style="margin-bottom: 0.5rem;">Araç bilgileri mevcut durumu yansıtır, ancak garanti teşkil etmez</li>
    <li style="margin-bottom: 0.5rem;">Fotoğraflar ve açıklamalar bilgilendirme amaçlıdır</li>
    <li style="margin-bottom: 0.5rem;">Araç fiyatları güncel piyasa koşullarına göre belirlenir ve değişebilir</li>
</ul>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">6.2. Alım-Satım Süreci</h3>
<p style="margin-bottom: 1rem;">Araç alım-satım işlemlerinde:</p>
<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">Tüm işlemler yazılı sözleşme ile gerçekleştirilir</li>
    <li style="margin-bottom: 0.5rem;">Ödeme ve teslimat şartları ayrıca belirlenir</li>
    <li style="margin-bottom: 0.5rem;">Yasal evraklar ve ruhsat devir işlemleri tamamlanır</li>
    <li style="margin-bottom: 0.5rem;">Garanti koşulları araç ve işleme özgü olarak düzenlenir</li>
</ul>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">6.3. İptal ve İade</h3>
<p style="margin-bottom: 1rem;">Mesafeli satış sözleşmesi kapsamında:</p>
<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">Cayma hakkı kullanımı sözleşme şartlarına tabidir</li>
    <li style="margin-bottom: 0.5rem;">14 günlük cayma hakkı belirli koşullar altında geçerlidir</li>
    <li style="margin-bottom: 0.5rem;">İade koşulları satış sözleşmesinde detaylı olarak belirtilir</li>
</ul>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">7. SORUMLULUK REDDİ VE SINIRLAMALARI</h2>

<div style="background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 1rem; margin-bottom: 1rem;">
    <h4 style="margin: 0 0 0.5rem 0; color: #92400e; font-weight: 600;">📢 Önemli Yasal Uyarı</h4>
    <p style="margin: 0; font-size: 0.875rem;">GMS Garage, aşağıdaki konularda sorumluluk kabul etmez ve garanti vermez:</p>
</div>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;"><strong>Web Sitesi Erişimi:</strong> Kesintisiz, hatasız veya güvenli erişim garantisi verilmez</li>
    <li style="margin-bottom: 0.5rem;"><strong>İçerik Doğruluğu:</strong> Web sitesindeki bilgilerin %100 doğru, güncel veya eksiksiz olması garanti edilmez</li>
    <li style="margin-bottom: 0.5rem;"><strong>Üçüncü Taraf Linkleri:</strong> Dış bağlantıların içeriğinden sorumlu değiliz</li>
    <li style="margin-bottom: 0.5rem;"><strong>Kullanıcı Kararları:</strong> Kullanıcıların kendi kararlarından kaynaklanan zararlar</li>
    <li style="margin-bottom: 0.5rem;"><strong>Teknik Sorunlar:</strong> Sunucu hataları, veri kaybı, hizmet kesintileri</li>
    <li style="margin-bottom: 0.5rem;"><strong>Dolaylı Zararlar:</strong> Kar kaybı, veri kaybı veya diğer dolaylı zararlar</li>
</ul>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">8. GİZLİLİK VE KİŞİSEL VERİLER</h2>

<p style="margin-bottom: 1rem;">Kişisel verilerinizin işlenmesi ayrı belgelerle düzenlenmektedir:</p>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">📄 <a href="/sayfa/gizlilik-politikasi" style="color: #dc2626; text-decoration: underline;">Gizlilik Politikası</a></li>
    <li style="margin-bottom: 0.5rem;">📄 <a href="/sayfa/kvkk-aydinlatma-metni" style="color: #dc2626; text-decoration: underline;">KVKK Aydınlatma Metni</a></li>
    <li style="margin-bottom: 0.5rem;">📄 <a href="/sayfa/cerez-politikasi" style="color: #dc2626; text-decoration: underline;">Çerez Politikası</a></li>
</ul>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">9. DEĞİŞİKLİKLER VE GÜNCELLEMELER</h2>

<p style="margin-bottom: 1rem;">GMS Garage, bu kullanım şartlarını önceden haber vermeksizin değiştirme hakkını saklı tutar:</p>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">Değişiklikler web sitesinde yayınlandığı anda yürürlüğe girer</li>
    <li style="margin-bottom: 0.5rem;">Önemli değişiklikler için bildirim gönderilebilir</li>
    <li style="margin-bottom: 0.5rem;">Güncel versiyonu düzenli olarak kontrol etmeniz önerilir</li>
    <li style="margin-bottom: 0.5rem;">Değişikliklerden sonra siteyi kullanmaya devam etmeniz yeni şartları kabul ettiğiniz anlamına gelir</li>
</ul>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">10. HİZMETİN DURDURULMASI</h2>

<p style="margin-bottom: 1rem;">GMS Garage, aşağıdaki durumlarda önceden haber vermeksizin hizmetleri durdurma hakkına sahiptir:</p>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">Kullanım şartlarının ihlal edilmesi</li>
    <li style="margin-bottom: 0.5rem;">Yasalara aykırı faaliyet tespit edilmesi</li>
    <li style="margin-bottom: 0.5rem;">Teknik bakım ve güncelleme gereklilikleri</li>
    <li style="margin-bottom: 0.5rem;">Güvenlik tehditleri ve sistem bütünlüğü riskleri</li>
</ul>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">11. UYUŞMAZLIKLARIN ÇÖZÜMÜ</h2>

<p style="margin-bottom: 1rem;">İşbu sözleşmeden doğacak her türlü uyuşmazlıkta:</p>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;"><strong>Uygulanacak Hukuk:</strong> Türkiye Cumhuriyeti yasaları</li>
    <li style="margin-bottom: 0.5rem;"><strong>Yetkili Mahkeme:</strong> [İl] Mahkemeleri ve İcra Daireleri</li>
    <li style="margin-bottom: 0.5rem;"><strong>Tüketici Hakları:</strong> Tüketici mahkemeleri ve hakem heyetleri yetkilidir</li>
    <li style="margin-bottom: 0.5rem;"><strong>Alternatif Çözüm:</strong> Taraflar öncelikle dostane çözüm aramayı taahhüt eder</li>
</ul>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">12. İLETİŞİM</h2>

<p style="margin-bottom: 1rem;">Kullanım şartları hakkında sorularınız için:</p>

<div style="background-color: #f3f4f6; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem;">
    <p style="margin-bottom: 0.75rem;"><strong>GMS Garage Otomotiv</strong></p>
    <p style="margin-bottom: 0.75rem;">📧 <strong>E-posta:</strong> info@gmsgarage.com</p>
    <p style="margin-bottom: 0.75rem;">📧 <strong>Hukuki İşler:</strong> legal@gmsgarage.com</p>
    <p style="margin-bottom: 0.75rem;">📞 <strong>Telefon:</strong> +90 XXX XXX XX XX</p>
    <p style="margin-bottom: 0.75rem;">📍 <strong>Adres:</strong> [Şirket Adresi]</p>
    <p style="margin-bottom: 0;">🌐 <strong>Website:</strong> www.gmsgarage.com</p>
</div>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">13. YÜRÜRLÜK</h2>

<p style="margin-bottom: 1rem;">İşbu Kullanım Şartları, web sitemizi ziyaret ettiğiniz veya hizmetlerimizi kullanmaya başladığınız andan itibaren yürürlüğe girer ve taraflar arasında bağlayıcıdır.</p>

<div style="background-color: #f0fdf4; border: 1px solid #86efac; border-radius: 0.5rem; padding: 1rem; margin-top: 2rem;">
    <p style="margin: 0; font-size: 0.875rem; color: #166534;">
        <strong>✅ Onay:</strong> "Kabul Ediyorum" butonuna tıklayarak veya web sitemizi kullanmaya devam ederek, bu Kullanım Şartları'nın tamamını okuduğunuzu, anladığınızı ve kabul ettiğinizi beyan etmiş olursunuz.
    </p>
</div>

<p style="margin-top: 2rem; text-align: center; color: #6b7280; font-size: 0.875rem;"><em>Son Güncelleme: Şubat 2026 | Versiyon: 1.0</em></p>

</div>
EOT;
    }

    private function getCookiePolicyContent()
    {
        return <<<'EOT'
<div style="max-width: 100%; font-family: system-ui, -apple-system, sans-serif; color: #374151; line-height: 1.8;">

<div style="background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 1.5rem; margin-bottom: 2rem;">
    <h3 style="margin: 0 0 0.75rem 0; color: #92400e; font-size: 1.25rem; font-weight: 700;">🍪 Çerez Bildirimi</h3>
    <p style="margin: 0; font-size: 0.875rem;">Bu sayfada, GMS Garage web sitesinde kullanılan çerezler (cookies) hakkında detaylı bilgi bulabilirsiniz. Web sitemizi ziyaret ederek çerez kullanımını kabul etmiş sayılırsınız.</p>
</div>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">1. ÇEREZ NEDİR?</h2>

<p style="margin-bottom: 1rem;">Çerezler (cookies), web sitelerini ziyaret ettiğinizde tarayıcınız aracılığıyla cihazınıza (bilgisayar, tablet, telefon) kaydedilen küçük metin dosyalarıdır. Çerezler, web sitesinin daha verimli çalışmasını sağlar ve size daha iyi bir kullanıcı deneyimi sunar.</p>

<div style="background-color: #f0fdf4; border: 1px solid #86efac; border-radius: 0.5rem; padding: 1.5rem; margin-bottom: 1.5rem;">
    <h4 style="margin: 0 0 0.75rem 0; color: #166534; font-weight: 600;">✓ Çerezlerin Özellikleri</h4>
    <ul style="margin: 0; padding-left: 1.5rem; font-size: 0.875rem;">
        <li style="margin-bottom: 0.5rem;">Kişisel olarak sizi tanımlamazlar</li>
        <li style="margin-bottom: 0.5rem;">Zararlı yazılım içermezler</li>
        <li style="margin-bottom: 0.5rem;">Virüs veya kötü amaçlı kod taşımazlar</li>
        <li style="margin-bottom: 0;">Tarayıcınızdan dilediğiniz zaman silebilirsiniz</li>
    </ul>
</div>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">2. ÇEREZ TÜRLERİ</h2>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">2.1. Süreye Göre Çerezler</h3>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; border: 1px solid #e5e7eb;">
    <thead style="background-color: #f3f4f6;">
        <tr>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb; width: 30%;">Çerez Türü</th>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb;">Açıklama</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb; font-weight: 600;">Oturum Çerezleri</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Tarayıcıyı kapattığınızda otomatik olarak silinir. Geçici bilgileri saklar.</td>
        </tr>
        <tr style="background-color: #f9fafb;">
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb; font-weight: 600;">Kalıcı Çerezler</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Belirli bir süre boyunca cihazınızda kalır. Tercihlerinizi hatırlar.</td>
        </tr>
    </tbody>
</table>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">2.2. Sahibine Göre Çerezler</h3>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; border: 1px solid #e5e7eb;">
    <thead style="background-color: #f3f4f6;">
        <tr>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb; width: 30%;">Çerez Türü</th>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb;">Açıklama</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb; font-weight: 600;">Birinci Taraf Çerezler</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">GMS Garage tarafından oluşturulan ve yönetilen çerezler</td>
        </tr>
        <tr style="background-color: #f9fafb;">
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb; font-weight: 600;">Üçüncü Taraf Çerezler</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Analitik araçlar (Google Analytics gibi) tarafından oluşturulan çerezler</td>
        </tr>
    </tbody>
</table>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">3. KULLANDIĞIMIZ ÇEREZLER</h2>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">3.1. Zorunlu Çerezler</h3>

<div style="background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 1rem; margin-bottom: 1rem;">
    <p style="margin: 0; font-size: 0.875rem;"><strong>⚠️ Önemli:</strong> Bu çerezler web sitesinin temel işlevleri için gereklidir ve devre dışı bırakılamazlar.</p>
</div>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; border: 1px solid #e5e7eb;">
    <thead style="background-color: #f3f4f6;">
        <tr>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb;">Çerez Adı</th>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb;">Amaç</th>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb; width: 15%;">Süre</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb; font-family: monospace;">XSRF-TOKEN</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Güvenlik ve CSRF koruması</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Oturum</td>
        </tr>
        <tr style="background-color: #f9fafb;">
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb; font-family: monospace;">laravel_session</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Oturum yönetimi</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">2 saat</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb; font-family: monospace;">cookie_consent</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Çerez tercihlerinizi hatırlar</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">1 yıl</td>
        </tr>
    </tbody>
</table>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">3.2. İşlevsellik Çerezleri</h3>

<p style="margin-bottom: 1rem;">Tercihlerinizi hatırlamak ve daha kişiselleştirilmiş bir deneyim sunmak için kullanılır:</p>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; border: 1px solid #e5e7eb;">
    <thead style="background-color: #f3f4f6;">
        <tr>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb;">Çerez Adı</th>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb;">Amaç</th>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb; width: 15%;">Süre</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb; font-family: monospace;">theme_preference</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Tema tercihi (açık/koyu mod)</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">1 yıl</td>
        </tr>
        <tr style="background-color: #f9fafb;">
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb; font-family: monospace;">language</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Dil tercihi</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">1 yıl</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb; font-family: monospace;">recent_searches</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Son aramaları hatırlar</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">30 gün</td>
        </tr>
    </tbody>
</table>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">3.3. Analitik ve Performans Çerezleri</h3>

<p style="margin-bottom: 1rem;">Web sitesi trafiğini ve kullanıcı davranışlarını analiz etmek için kullanılır:</p>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; border: 1px solid #e5e7eb;">
    <thead style="background-color: #f3f4f6;">
        <tr>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb;">Servis</th>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb;">Çerez Adı</th>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb;">Amaç</th>
            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb; width: 15%;">Süre</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Google Analytics</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb; font-family: monospace;">_ga</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Kullanıcı ayırt etme</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">2 yıl</td>
        </tr>
        <tr style="background-color: #f9fafb;">
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Google Analytics</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb; font-family: monospace;">_gid</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Kullanıcı ayırt etme</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">24 saat</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">Google Analytics</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb; font-family: monospace;">_gat</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">İstek hızını sınırlar</td>
            <td style="padding: 0.75rem; border: 1px solid #e5e7eb;">1 dakika</td>
        </tr>
    </tbody>
</table>

<div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-bottom: 1.5rem;">
    <p style="margin: 0; font-size: 0.875rem;"><strong>ℹ️ Not:</strong> Analitik çerezler, ziyaretçi sayısını, popüler sayfaları ve kullanıcı davranışlarını anlamamıza yardımcı olur. Bu veriler toplu ve anonim şekilde işlenir.</p>
</div>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">3.4. Pazarlama ve Reklam Çerezleri (İzninizle)</h3>

<p style="margin-bottom: 1rem;">Size özel reklamlar göstermek ve pazarlama kampanyalarının etkinliğini ölçmek için kullanılır:</p>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;">Google Ads remarketing çerezleri</li>
    <li style="margin-bottom: 0.5rem;">Facebook Pixel</li>
    <li style="margin-bottom: 0.5rem;">Sosyal medya paylaşım çerezleri</li>
</ul>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">4. ÇEREZLERİN KULLANIM AMAÇLARI</h2>

<div style="display: grid; gap: 1rem; margin-bottom: 1.5rem;">
    <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0; color: #166534; font-weight: 600;">✓ Web Sitesi İşlevselliği</h4>
        <p style="margin: 0; font-size: 0.875rem;">Temel özelliklerin çalışması, güvenli oturum yönetimi, form verilerinin saklanması</p>
    </div>
    
    <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0; color: #1e40af; font-weight: 600;">✓ Kullanıcı Deneyimi</h4>
        <p style="margin: 0; font-size: 0.875rem;">Tercihlerinizi hatırlama, kişiselleştirilmiş içerik sunma, daha hızlı yükleme</p>
    </div>
    
    <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0; color: #92400e; font-weight: 600;">✓ Performans ve Analiz</h4>
        <p style="margin: 0; font-size: 0.875rem;">Site trafiği analizi, kullanıcı davranışlarının anlaşılması, hizmet iyileştirme</p>
    </div>
    
    <div style="background-color: #f5f3ff; border-left: 4px solid #8b5cf6; padding: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0; color: #5b21b6; font-weight: 600;">✓ Güvenlik</h4>
        <p style="margin: 0; font-size: 0.875rem;">Dolandırıcılık önleme, güvenlik tehditleri tespit, spam koruması</p>
    </div>
    
    <div style="background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0; color: #991b1b; font-weight: 600;">✓ Pazarlama (İzninizle)</h4>
        <p style="margin: 0; font-size: 0.875rem;">İlgi alanlarınıza uygun reklamlar, kampanya etkinliği ölçümü</p>
    </div>
</div>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">5. ÇEREZLERİ NASIL YÖNETEBİLİRSİNİZ?</h2>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">5.1. Tarayıcı Ayarları</h3>

<p style="margin-bottom: 1rem;">Çerezleri tarayıcı ayarlarınızdan yönetebilirsiniz. Popüler tarayıcılar için ayarlar:</p>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;"><strong>Google Chrome:</strong> Ayarlar > Gizlilik ve güvenlik > Çerezler ve diğer site verileri</li>
    <li style="margin-bottom: 0.5rem;"><strong>Firefox:</strong> Ayarlar > Gizlilik ve Güvenlik > Çerezler ve Site Verileri</li>
    <li style="margin-bottom: 0.5rem;"><strong>Safari:</strong> Tercihler > Gizlilik > Çerezleri Yönet</li>
    <li style="margin-bottom: 0.5rem;"><strong>Edge:</strong> Ayarlar > Çerezler ve site izinleri</li>
</ul>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">5.2. Çerez Tercih Merkezi</h3>

<p style="margin-bottom: 1rem;">Web sitemizde bulunan çerez ayarları panelinden tercihlerinizi değiştirebilirsiniz:</p>

<div style="background-color: #f3f4f6; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; text-align: center;">
    <button style="background-color: #dc2626; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; border: none; font-weight: 600; cursor: pointer;" onclick="alert('Çerez ayarları paneli açılacak')">🍪 Çerez Ayarlarını Yönet</button>
</div>

<h3 style="color: #991b1b; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem;">5.3. Üçüncü Taraf Çerezleri Reddetme</h3>

<p style="margin-bottom: 1rem;">Üçüncü taraf çerezleri için doğrudan hizmet sağlayıcıları ziyaret edebilirsiniz:</p>

<ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
    <li style="margin-bottom: 0.5rem;"><strong>Google Analytics:</strong> <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" style="color: #dc2626; text-decoration: underline;">Google Analytics Opt-out</a></li>
    <li style="margin-bottom: 0.5rem;"><strong>Google Ads:</strong> <a href="https://adssettings.google.com" target="_blank" style="color: #dc2626; text-decoration: underline;">Reklam Ayarları</a></li>
    <li style="margin-bottom: 0.5rem;"><strong>Facebook:</strong> <a href="https://www.facebook.com/settings?tab=ads" target="_blank" style="color: #dc2626; text-decoration: underline;">Reklam Tercihleri</a></li>
</ul>

<div style="background-color: #fffbeb; border: 1px solid #fde68a; border-radius: 0.5rem; padding: 1rem; margin-bottom: 1.5rem;">
    <p style="margin: 0; font-size: 0.875rem; color: #92400e;"><strong>⚠️ Uyarı:</strong> Çerezleri tamamen devre dışı bırakırsanız, web sitesinin bazı özellikleri düzgün çalışmayabilir. Örneğin, oturum açma, form doldurma veya tercihlerinizin kaydedilmesi gibi işlevler etkilenebilir.</p>
</div>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">6. ÇEREZ POLİTİKASI DEĞİŞİKLİKLERİ</h2>

<p style="margin-bottom: 1rem;">Bu Çerez Politikası, yasal düzenlemeler veya web sitesi değişiklikleri nedeniyle güncellenebilir. Önemli değişiklikler yapıldığında sizi bilgilendireceğiz. Güncel versiyonu düzenli olarak kontrol etmenizi öneririz.</p>

<h2 style="color: #dc2626; font-size: 1.75rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #dc2626; padding-bottom: 0.5rem;">7. İLETİŞİM</h2>

<p style="margin-bottom: 1rem;">Çerez kullanımı hakkında sorularınız için bizimle iletişime geçebilirsiniz:</p>

<div style="background-color: #f3f4f6; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem;">
    <p style="margin-bottom: 0.75rem;"><strong>GMS Garage Otomotiv</strong></p>
    <p style="margin-bottom: 0.75rem;">📧 <strong>E-posta:</strong> privacy@gmsgarage.com</p>
    <p style="margin-bottom: 0.75rem;">📞 <strong>Telefon:</strong> +90 XXX XXX XX XX</p>
    <p style="margin-bottom: 0;">🌐 <strong>Website:</strong> www.gmsgarage.com</p>
</div>

<div style="background-color: #eff6ff; border: 1px solid #93c5fd; border-radius: 0.5rem; padding: 1rem; margin-top: 2rem;">
    <p style="margin: 0; font-size: 0.875rem; color: #1e40af;">
        <strong>ℹ️ İlgili Belgeler:</strong> Kişisel verilerinizin işlenmesi hakkında daha fazla bilgi için <a href="/sayfa/gizlilik-politikasi" style="color: #dc2626; text-decoration: underline;">Gizlilik Politikası</a> ve <a href="/sayfa/kvkk-aydinlatma-metni" style="color: #dc2626; text-decoration: underline;">KVKK Aydınlatma Metni</a> sayfalarımızı ziyaret edebilirsiniz.
    </p>
</div>

<p style="margin-top: 2rem; text-align: center; color: #6b7280; font-size: 0.875rem;"><em>Son Güncelleme: Şubat 2026 | Versiyon: 1.0</em></p>

</div>
EOT;
    }
}
