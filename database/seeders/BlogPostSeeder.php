<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mevcut blog yazılarını sil
        BlogPost::truncate();

        $posts = [
            // ========== ARAÇ ALIM SATIM REHBERİ ==========
            [
                'title' => 'İkinci El Araç Alırken Dikkat Edilmesi Gerekenler: Detaylı Rehber',
                'excerpt' => 'İkinci el araç satın alırken nelere dikkat etmelisiniz? Bu kapsamlı rehberde, doğru araç seçimi için tüm önemli noktaları bulacaksınız.',
                'content' => '<h2>İkinci El Araç Alırken Dikkat Edilmesi Gerekenler</h2>
                
                <p>İkinci el araç satın almak, yeni bir araç almak kadar önemli bir karardır. Doğru seçim yapmak için dikkat etmeniz gereken birçok faktör bulunmaktadır. Bu rehberde, ikinci el araç alırken dikkat etmeniz gereken tüm önemli noktaları bulacaksınız.</p>

                <h3>1. Araç Geçmişini Kontrol Edin</h3>
                <p>Araç geçmişi, satın alma kararınızı etkileyen en önemli faktörlerden biridir. Araç geçmişinde şunları kontrol etmelisiniz:</p>
                <ul>
                    <li><strong>Kaza geçmişi:</strong> Araç kaza geçirmiş mi? Hasar kayıtları var mı?</li>
                    <li><strong>Bakım kayıtları:</strong> Düzenli servis bakımları yapılmış mı?</li>
                    <li><strong>Önceki sahipleri:</strong> Kaç kişi kullanmış? Özel mi, ticari mi kullanılmış?</li>
                    <li><strong>Kilometre bilgisi:</strong> Kilometre gerçekçi mi? Araç çok kullanılmış mı?</li>
                </ul>

                <h3>2. Fiziksel Kontrol</h3>
                <p>Araç görünümü, iç ve dış hasarlar hakkında önemli ipuçları verir. Dikkat etmeniz gerekenler:</p>
                <ul>
                    <li>Boyası ve çizikler: Boya kalitesi, renk uyumu, çizikler</li>
                    <li>Kapı ve bagaj açılışları: Düzgün kapanıyor mu?</li>
                    <li>Lastik durumu: Diş derinliği, yaş, marka</li>
                    <li>İç mekan temizliği: Kullanım izleri, kokular</li>
                </ul>

                <h3>3. Test Sürüşü</h3>
                <p>Mutlaka test sürüşü yapın. Test sürüşü sırasında:</p>
                <ul>
                    <li>Motor sesini dinleyin: Anormal sesler var mı?</li>
                    <li>Fren ve direksiyon kontrolü yapın</li>
                    <li>Vites geçişlerini test edin</li>
                    <li>Klima ve elektronik sistemleri kontrol edin</li>
                </ul>

                <h3>4. Profesyonel Muayene</h3>
                <p>Önemli bir yatırım yapmadan önce, profesyonel bir muayene yaptırmanızı öneririz. GMSGARAGE olarak, tüm araçlarımız profesyonel muayeneden geçmektedir.</p>

                <blockquote>
                    <p>Güvenilir bir satıcı seçmek, ikinci el araç alırken en önemli adımdır. GMSGARAGE, şeffaf bilgilendirme ve kaliteli hizmet anlayışıyla yanınızdadır.</p>
                </blockquote>',
                'category' => 'Araç Alım Satım Rehberi',
                'meta_keywords' => ['ikinci el araç', 'araç alım rehberi', 'ikinci el araç alırken', 'araç satın alma ipuçları', 'araç muayenesi'],
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'İkinci El Elektrikli Araç Alırken Nelere Dikkat Edilmeli?',
                'excerpt' => 'Elektrikli araçların ikinci el piyasası hızla büyüyor. İkinci el elektrikli araç alırken dikkat edilmesi gereken önemli noktalar.',
                'content' => '<h2>İkinci El Elektrikli Araç Alırken Nelere Dikkat Edilmeli?</h2>
                
                <p>Elektrikli araçların ikinci el piyasası hızla büyüyor. Ancak ikinci el elektrikli araç alırken, geleneksel araçlardan farklı olarak dikkat edilmesi gereken özel noktalar bulunmaktadır.</p>

                <h3>1. Batarya Durumu</h3>
                <p>Elektrikli araçlarda en önemli faktör batarya sağlığıdır:</p>
                <ul>
                    <li>Batarya kapasitesi: Orijinal kapasitenin yüzde kaçı kalmış?</li>
                    <li>Şarj döngüsü sayısı: Batarya ne kadar kullanılmış?</li>
                    <li>Garanti durumu: Batarya garantisi devam ediyor mu?</li>
                    <li>Soğutma sistemi: Batarya soğutma sistemi çalışıyor mu?</li>
                </ul>

                <h3>2. Şarj Altyapısı</h3>
                <p>Elektrikli araç kullanımı için şarj altyapısı kritik öneme sahiptir:</p>
                <ul>
                    <li>Evde şarj imkanı var mı?</li>
                    <li>Yakınınızda şarj istasyonu var mı?</li>
                    <li>Şarj kablosu ve adaptörler mevcut mu?</li>
                </ul>

                <h3>3. Menzil ve Performans</h3>
                <p>Elektrikli araçlarda menzil, kullanım senaryonuza uygun mu?</p>
                <ul>
                    <li>Günlük kullanım için yeterli menzil var mı?</li>
                    <li>Hızlı şarj desteği var mı?</li>
                    <li>Performans beklentilerinize uygun mu?</li>
                </ul>

                <p>GMSGARAGE, elektrikli araç portföyünü genişletmekte ve müşterilerimize detaylı bilgilendirme yapmaktadır.</p>',
                'category' => 'Araç Alım Satım Rehberi',
                'meta_keywords' => ['ikinci el elektrikli araç', 'elektrikli araç alım', 'EV alım rehberi', 'elektrikli araç batarya'],
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Noter Araç Satış Ücretleri ve Devir İşlemleri (2026)',
                'excerpt' => 'Araç alımı ya da satışı yapılırken devir işlemlerinin gerçekleştirilmesi gerekir. Noter araç satış ücretleri ve devir işlemleri hakkında bilgiler.',
                'content' => '<h2>Noter Araç Satış Ücretleri ve Devir İşlemleri</h2>
                
                <p>Araç alımı ya da satışı yapılırken devir işlemlerinin gerçekleştirilmesi gerekir. Bu işlemler noter huzurunda yapılır ve belirli ücretler ödenir.</p>

                <h3>Noter Ücretleri</h3>
                <p>2026 yılı noter araç satış ücretleri:</p>
                <ul>
                    <li>Devir işlemi: Araç değerine göre değişken</li>
                    <li>Vekaletname: Sabit ücret</li>
                    <li>Diğer belgeler: İşlem türüne göre değişken</li>
                </ul>

                <h3>Gerekli Belgeler</h3>
                <ul>
                    <li>Araç ruhsatı</li>
                    <li>Kimlik belgesi</li>
                    <li>Muayene belgesi</li>
                    <li>Sigorta belgesi</li>
                </ul>

                <h3>İşlem Süreci</h3>
                <p>Noter devir işlemi genellikle şu adımlardan oluşur:</p>
                <ol>
                    <li>Belgelerin hazırlanması</li>
                    <li>Noter randevusu alınması</li>
                    <li>İşlemlerin tamamlanması</li>
                    <li>Ruhsat güncellemesi</li>
                </ol>

                <p>GMSGARAGE, müşterilerimize devir işlemlerinde rehberlik hizmeti sunmaktadır.</p>',
                'category' => 'Araç Alım Satım Rehberi',
                'meta_keywords' => ['noter araç satış', 'araç devir işlemi', 'noter ücretleri', 'araç ruhsat devri'],
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(8),
            ],

            // ========== SÜRÜCÜ REHBERİ ==========
            [
                'title' => 'Araç Bakımı İpuçları: Aracınızı Uzun Süre Kullanmak İçin',
                'excerpt' => 'Aracınızın ömrünü uzatmak ve performansını korumak için düzenli bakım şarttır. İşte araç bakımı hakkında bilmeniz gerekenler.',
                'content' => '<h2>Araç Bakımı İpuçları: Aracınızı Uzun Süre Kullanmak İçin</h2>
                
                <p>Düzenli bakım, aracınızın ömrünü uzatır ve performansını korur. Bu yazıda, aracınızı uzun süre kullanmak için dikkat etmeniz gereken bakım ipuçlarını bulacaksınız.</p>

                <h3>1. Düzenli Yağ Değişimi</h3>
                <p>Motor yağı, aracınızın kalbidir. Düzenli yağ değişimi:</p>
                <ul>
                    <li>Motor ömrünü uzatır</li>
                    <li>Yakıt tüketimini azaltır</li>
                    <li>Performansı artırır</li>
                </ul>
                <p>Genellikle 10.000-15.000 km aralığında yağ değişimi yapılması önerilir.</p>

                <h3>2. Lastik Bakımı</h3>
                <p>Lastikler, güvenliğiniz için kritik öneme sahiptir:</p>
                <ul>
                    <li>Lastik basıncını düzenli kontrol edin (ayda bir kez)</li>
                    <li>Rot-balans ayarlarını yaptırın</li>
                    <li>Lastik diş derinliğini kontrol edin (minimum 3mm)</li>
                    <li>Lastik rotasyonunu düzenli yaptırın</li>
                </ul>

                <h3>3. Fren Sistemi Kontrolü</h3>
                <p>Fren sistemi, güvenliğiniz için hayati öneme sahiptir. Düzenli kontrol:</p>
                <ul>
                    <li>Fren balatalarını kontrol edin (20.000-30.000 km)</li>
                    <li>Fren disklerini inceleyin</li>
                    <li>Fren hidroliğini kontrol edin</li>
                </ul>

                <h3>4. Klima Bakımı</h3>
                <p>Klima sisteminin düzenli bakımı:</p>
                <ul>
                    <li>Filtre değişimi (yılda bir kez)</li>
                    <li>Gaz kontrolü</li>
                    <li>Temizlik</li>
                </ul>

                <p>GMSGARAGE, tüm araçlarımızın düzenli bakımlarını yapmaktadır. Satın aldığınız araçlarımız, bakımlı ve hazır durumda teslim edilmektedir.</p>',
                'category' => 'Sürücü Rehberi',
                'meta_keywords' => ['araç bakımı', 'motor bakımı', 'lastik bakımı', 'araç servisi', 'bakım ipuçları'],
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Aracınızın Lastik Hava Basınç Değeri Ne Kadar Olmalı?',
                'excerpt' => 'Lastik hava basıncı, güvenlik ve yakıt tüketimi açısından kritik öneme sahiptir. Doğru lastik basıncı değerleri ve kontrol yöntemleri.',
                'content' => '<h2>Aracınızın Lastik Hava Basınç Değeri Ne Kadar Olmalı?</h2>
                
                <p>Son zamanlarda benzin tüketiminin neden normalden daha yüksek olduğunu veya aracınızın neden hızını eskisi kadar koruyamadığını merak ediyorsanız, bunun nedeni lastik basıncı olabilir.</p>

                <h3>Doğru Lastik Basıncı Neden Önemli?</h3>
                <ul>
                    <li><strong>Güvenlik:</strong> Düşük basınç, patlama riskini artırır</li>
                    <li><strong>Yakıt Tüketimi:</strong> Yanlış basınç, yakıt tüketimini %5-10 artırabilir</li>
                    <li><strong>Lastik Ömrü:</strong> Düzensiz aşınma ve erken yıpranma</li>
                    <li><strong>Performans:</strong> Yol tutuşu ve fren mesafesi etkilenir</li>
                </ul>

                <h3>Lastik Basıncı Nasıl Kontrol Edilir?</h3>
                <ol>
                    <li>Araç soğukken kontrol edin (en az 2 saat kullanılmamış)</li>
                    <li>Üretici önerilerini kontrol edin (genellikle kapı içinde veya kullanım kılavuzunda)</li>
                    <li>Basınç ölçer ile ölçüm yapın</li>
                    <li>Gerekirse hava ekleyin veya çıkarın</li>
                </ol>

                <h3>Genel Basınç Değerleri</h3>
                <p>Çoğu binek araç için önerilen basınç değerleri:</p>
                <ul>
                    <li>Ön lastikler: 2.2-2.4 bar (32-35 PSI)</li>
                    <li>Arka lastikler: 2.0-2.2 bar (29-32 PSI)</li>
                    <li>Yüklü araçlar: Üretici önerilerine göre artırılabilir</li>
                </ul>

                <p><strong>Önemli:</strong> Her araç için doğru basınç değerleri farklı olabilir. Mutlaka aracınızın kullanım kılavuzunu kontrol edin.</p>',
                'category' => 'Sürücü Rehberi',
                'meta_keywords' => ['lastik basıncı', 'lastik hava basıncı', 'lastik bakımı', 'araç güvenliği'],
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => 'Araç Sigortasında Tasarruf Etmek İçin İpuçları',
                'excerpt' => 'Araç sigortası maliyetlerini düşürmek için uygulayabileceğiniz pratik ipuçları ve tasarruf yöntemleri.',
                'content' => '<h2>Araç Sigortasında Tasarruf Etmek İçin İpuçları</h2>
                
                <p>Araç sigortası, hem yasal bir zorunluluk hem de güvenliğiniz için önemli bir korumadır. Ancak sigorta maliyetlerini düşürmek için uygulayabileceğiniz birçok yöntem bulunmaktadır.</p>

                <h3>1. Karşılaştırma Yapın</h3>
                <p>Farklı sigorta şirketlerinin tekliflerini karşılaştırın. Online karşılaştırma sitelerini kullanabilirsiniz.</p>

                <h3>2. Bonus-Malus Sistemini Koruyun</h3>
                <p>Kazasız geçen her yıl, sigorta priminizi düşürür. Kazasız sürüş bonusunuzu koruyun.</p>

                <h3>3. Ekstra Özellikleri Değerlendirin</h3>
                <p>Gereksiz ek teminatları kaldırarak priminizi düşürebilirsiniz. Ancak ihtiyacınız olan teminatları korumayı unutmayın.</p>

                <h3>4. Grup Sigortası</h3>
                <p>Bazı kuruluşlar veya dernekler grup sigortası avantajları sunar. Bu tür fırsatları değerlendirin.</p>

                <h3>5. Online İndirimler</h3>
                <p>Online sigorta alımında genellikle ek indirimler sunulur. Online teklifleri kontrol edin.</p>

                <p>GMSGARAGE, müşterilerimize sigorta konusunda danışmanlık hizmeti sunmaktadır.</p>',
                'category' => 'Sürücü Rehberi',
                'meta_keywords' => ['araç sigortası', 'kasko', 'sigorta tasarruf', 'sigorta ipuçları'],
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(15),
            ],

            // ========== OTOMOBİL DÜNYASI ==========
            [
                'title' => 'Dünyanın En Pahalı 10 Arabası (2026)',
                'excerpt' => 'Otomotiv endüstrisi, her geçen yıl lüks ve performansı yüksek otomobillerle sınırları zorlamaya devam ediyor. 2026 yılında dünyanın en pahalı arabaları.',
                'content' => '<h2>Dünyanın En Pahalı 10 Arabası (2026)</h2>
                
                <p>Otomotiv endüstrisi, her geçen yıl lüks ve performansı yüksek otomobillerle sınırları zorlamaya devam ediyor. 2026 yılında dünyanın en pahalı arabalarını sizler için derledik.</p>

                <h3>1. Bugatti La Voiture Noire - $18.7 Milyon</h3>
                <p>Bugatti\'nin özel üretim modeli, dünyanın en pahalı arabası unvanını taşıyor. Sadece bir adet üretildi.</p>

                <h3>2. Rolls-Royce Boat Tail - $28 Milyon</h3>
                <p>Rolls-Royce\'un özel tasarım modeli, lüksün sınırlarını zorluyor.</p>

                <h3>3. Pagani Zonda HP Barchetta - $17.5 Milyon</h3>
                <p>İtalyan üretici Pagani\'nin özel modeli, performans ve lüksü bir araya getiriyor.</p>

                <h3>4. Koenigsegg CCXR Trevita - $4.8 Milyon</h3>
                <p>İsveçli üretici Koenigsegg\'in özel modeli, nadir bulunan bir koleksiyon parçası.</p>

                <h3>5. Lamborghini Veneno - $4.5 Milyon</h3>
                <p>Lamborghini\'nin sınırlı üretim modeli, agresif tasarımıyla dikkat çekiyor.</p>

                <h3>6-10. Diğer Lüks Modeller</h3>
                <p>Listede ayrıca Ferrari, McLaren, Aston Martin gibi markaların özel modelleri de yer alıyor.</p>

                <blockquote>
                    <p>Bu araçlar, sadece ulaşım aracı değil, aynı zamanda sanat eseri ve yatırım aracı olarak görülüyor.</p>
                </blockquote>',
                'category' => 'Otomobil Dünyası',
                'meta_keywords' => ['en pahalı arabalar', 'lüks arabalar', 'süper arabalar', 'koleksiyon arabaları'],
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Dünyanın En Hızlı 10 Arabası Hangileri?',
                'excerpt' => 'Otomotiv dünyasında hız rekorları sürekli kırılıyor. 2026 yılında dünyanın en hızlı arabaları ve performans özellikleri.',
                'content' => '<h2>Dünyanın En Hızlı 10 Arabası Hangileri?</h2>
                
                <p>Otomotiv dünyasında hız rekorları sürekli kırılıyor. Teknoloji geliştikçe, arabaların maksimum hızları da artıyor. İşte 2026 yılında dünyanın en hızlı arabaları:</p>

                <h3>1. Koenigsegg Jesko Absolut - 531 km/s</h3>
                <p>İsveçli üretici Koenigsegg, hız rekorunu elinde tutuyor.</p>

                <h3>2. Bugatti Chiron Super Sport 300+ - 490 km/s</h3>
                <p>Bugatti, lüks ve hızı bir araya getiren modelleriyle öne çıkıyor.</p>

                <h3>3. Hennessey Venom F5 - 484 km/s</h3>
                <p>Amerikalı üretici Hennessey, süper arabalar kategorisinde güçlü bir rakip.</p>

                <h3>4. SSC Tuatara - 455 km/s</h3>
                <p>SSC, Amerikan süper araba üreticilerinden biri.</p>

                <h3>5. Rimac Nevera - 412 km/s</h3>
                <p>Hırvat üretici Rimac, elektrikli süper arabalar kategorisinde öncü.</p>

                <p><strong>Not:</strong> Bu hızlar, özel test pistlerinde ve güvenli koşullarda elde edilmiştir. Yollarda bu hızlara ulaşmak yasaktır ve tehlikelidir.</p>',
                'category' => 'Otomobil Dünyası',
                'meta_keywords' => ['en hızlı arabalar', 'süper arabalar', 'hız rekorları', 'performans arabaları'],
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Araba Segmentleri Nelerdir? Detaylı Rehber',
                'excerpt' => 'Arabaların tasarımlarından performanslarına, taşıma hacimlerinden sürüş konforuna kadar pek çok noktada belirleyici olan araba segmentleri hakkında bilgiler.',
                'content' => '<h2>Araba Segmentleri Nelerdir?</h2>
                
                <p>Arabaların tasarımlarından performanslarına, taşıma hacimlerinden sürüş konforuna kadar pek çok noktada belirleyici olan araba segmentleri hakkında ne kadar bilgiye sahipsiniz?</p>

                <h3>A Segmenti - Mini Arabalar</h3>
                <p>En küçük ve en ekonomik segment. Şehir içi kullanım için idealdir.</p>
                <ul>
                    <li>Örnekler: Fiat 500, Smart Fortwo</li>
                    <li>Fiyat aralığı: Düşük</li>
                    <li>Yakıt tüketimi: Çok düşük</li>
                </ul>

                <h3>B Segmenti - Küçük Arabalar</h3>
                <p>Kompakt ve pratik arabalar. Günlük kullanım için popüler.</p>
                <ul>
                    <li>Örnekler: Volkswagen Polo, Ford Fiesta</li>
                    <li>Fiyat aralığı: Orta</li>
                    <li>Yakıt tüketimi: Düşük</li>
                </ul>

                <h3>C Segmenti - Orta Sınıf</h3>
                <p>En popüler segment. Aile kullanımı için idealdir.</p>
                <ul>
                    <li>Örnekler: Volkswagen Golf, Ford Focus</li>
                    <li>Fiyat aralığı: Orta-yüksek</li>
                    <li>Yakıt tüketimi: Orta</li>
                </ul>

                <h3>D Segmenti - Üst Orta Sınıf</h3>
                <p>Konfor ve teknoloji odaklı arabalar.</p>
                <ul>
                    <li>Örnekler: BMW 3 Serisi, Mercedes C-Serisi</li>
                    <li>Fiyat aralığı: Yüksek</li>
                </ul>

                <h3>E Segmenti - Üst Sınıf</h3>
                <p>Lüks ve konfor odaklı arabalar.</p>
                <ul>
                    <li>Örnekler: BMW 5 Serisi, Mercedes E-Serisi</li>
                    <li>Fiyat aralığı: Çok yüksek</li>
                </ul>

                <h3>SUV Segmenti</h3>
                <p>Sportif ve geniş arabalar. Yüksek yerden görüş ve geniş iç mekan.</p>
                <ul>
                    <li>Örnekler: BMW X5, Mercedes GLE</li>
                    <li>Fiyat aralığı: Yüksek</li>
                </ul>

                <p>GMSGARAGE, tüm segmentlerde geniş bir araç portföyüne sahiptir.</p>',
                'category' => 'Otomobil Dünyası',
                'meta_keywords' => ['araç segmentleri', 'araç sınıfları', 'araç kategorileri', 'araç tipleri'],
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],

            // ========== OTOMOBİL SÖZLÜĞÜ ==========
            [
                'title' => 'Plakam Kayboldu, Ne Yapmalıyım? (2026)',
                'excerpt' => 'Plakaların araç kimlik belgesi gibi işlev gördüğünü ve aracın tüm resmi kayıtlarını içerdiğini düşünebilirsiniz. Plaka kaybı durumunda yapılması gerekenler.',
                'content' => '<h2>Plakam Kayboldu, Ne Yapmalıyım?</h2>
                
                <p>Plakaların araç kimlik belgesi gibi işlev gördüğünü ve aracın tüm resmi kayıtlarını içerdiğini düşünebilirsiniz. Plaka kaybı durumunda yapılması gerekenler:</p>

                <h3>1. İlk Adım: Polis Karakoluna Başvuru</h3>
                <p>Plakanızı kaybettiğinizde ilk yapmanız gereken, en yakın polis karakoluna başvurmaktır. Kayıp plaka tutanağı alın.</p>

                <h3>2. Trafik Tescil Bürosuna Başvuru</h3>
                <p>Polis tutanağı ile birlikte, aracınızın kayıtlı olduğu trafik tescil bürosuna başvurun.</p>

                <h3>3. Gerekli Belgeler</h3>
                <ul>
                    <li>Kimlik belgesi</li>
                    <li>Araç ruhsatı</li>
                    <li>Polis tutanağı (kayıp plaka)</li>
                    <li>Başvuru formu</li>
                </ul>

                <h3>4. Yeni Plaka İşlemleri</h3>
                <p>Yeni plaka çıkartma işlemleri genellikle şu adımlardan oluşur:</p>
                <ol>
                    <li>Başvuru formunun doldurulması</li>
                    <li>Gerekli ücretlerin ödenmesi</li>
                    <li>Yeni plakanın hazırlanması</li>
                    <li>Teslim alınması</li>
                </ol>

                <h3>5. Süre ve Ücretler</h3>
                <p>Plaka çıkartma işlemi genellikle 1-3 iş günü sürer. Ücretler, plaka tipine göre değişkenlik gösterir.</p>

                <p><strong>Önemli:</strong> Plakanızı kaybettiğinizde, derhal işlem başlatmanız önerilir. Kayıp plaka ile trafiğe çıkmak yasaktır.</p>',
                'category' => 'Otomobil Sözlüğü',
                'meta_keywords' => ['plaka kaybı', 'plaka çıkartma', 'plaka işlemleri', 'trafik tescil'],
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Ehliyetimi Kaybettim Ne Yapmalıyım? (2026)',
                'excerpt' => 'Ehliyetiniz olsa da trafik kontrolleri sırasında yanınızda olmaması nedeniyle ceza alabilirsiniz. Ehliyet kaybı durumunda yapılması gerekenler.',
                'content' => '<h2>Ehliyetimi Kaybettim Ne Yapmalıyım?</h2>
                
                <p>Ehliyetiniz olsa da trafik kontrolleri sırasında yanınızda olmaması nedeniyle ceza alabilirsiniz. Bu nedenle ehliyeti kaybettiğiniz zaman hızlı bir şekilde kayıp ehliyet çıkartma işlemlerini başlatmanız gerekir.</p>

                <h3>1. Polis Karakoluna Başvuru</h3>
                <p>Ehliyetinizi kaybettiğinizde, en yakın polis karakoluna başvurarak kayıp ehliyet tutanağı alın.</p>

                <h3>2. Nüfus Müdürlüğüne Başvuru</h3>
                <p>Polis tutanağı ile birlikte, ikamet ettiğiniz ilçenin nüfus müdürlüğüne başvurun.</p>

                <h3>3. Gerekli Belgeler</h3>
                <ul>
                    <li>Kimlik belgesi</li>
                    <li>Polis tutanağı (kayıp ehliyet)</li>
                    <li>2 adet biyometrik fotoğraf</li>
                    <li>Başvuru formu</li>
                </ul>

                <h3>4. İşlem Süreci</h3>
                <ol>
                    <li>Başvuru formunun doldurulması</li>
                    <li>Gerekli ücretlerin ödenmesi</li>
                    <li>Yeni ehliyetin hazırlanması (genellikle 1-2 hafta)</li>
                    <li>Teslim alınması</li>
                </ol>

                <h3>5. Geçici Ehliyet</h3>
                <p>Yeni ehliyet hazırlanana kadar, geçici ehliyet belgesi alabilirsiniz. Bu belge ile araç kullanabilirsiniz.</p>

                <p><strong>Önemli:</strong> Ehliyetiniz olmadan araç kullanmak yasaktır ve ağır cezaları vardır.</p>',
                'category' => 'Otomobil Sözlüğü',
                'meta_keywords' => ['ehliyet kaybı', 'ehliyet çıkartma', 'kayıp ehliyet', 'ehliyet işlemleri'],
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(6),
            ],
            [
                'title' => 'Plaka Renkleri ve Anlamları Nelerdir?',
                'excerpt' => 'Türkiye\'de farklı renklerde plakalar bulunmaktadır. Her plaka renginin farklı bir anlamı vardır. Plaka renkleri ve anlamları hakkında bilgiler.',
                'content' => '<h2>Plaka Renkleri ve Anlamları Nelerdir?</h2>
                
                <p>Türkiye\'de farklı renklerde plakalar bulunmaktadır. Her plaka renginin farklı bir anlamı vardır. İşte plaka renkleri ve anlamları:</p>

                <h3>Beyaz Plaka</h3>
                <p>En yaygın plaka tipidir. Özel araçlar için kullanılır.</p>
                <ul>
                    <li>Kullanım: Özel binek araçlar</li>
                    <li>Renk: Beyaz zemin, siyah yazı</li>
                </ul>

                <h3>Kırmızı Plaka</h3>
                <p>Ticari araçlar için kullanılır.</p>
                <ul>
                    <li>Kullanım: Ticari araçlar, taksiler</li>
                    <li>Renk: Kırmızı zemin, beyaz yazı</li>
                </ul>

                <h3>Yeşil Plaka</h3>
                <p>Resmi kurum araçları için kullanılır.</p>
                <ul>
                    <li>Kullanım: Devlet kurumları, belediyeler</li>
                    <li>Renk: Yeşil zemin, beyaz yazı</li>
                </ul>

                <h3>Mavi Plaka</h3>
                <p>Diplomatik araçlar için kullanılır.</p>
                <ul>
                    <li>Kullanım: Büyükelçilikler, konsolosluklar</li>
                    <li>Renk: Mavi zemin, beyaz yazı</li>
                </ul>

                <h3>Turuncu Plaka</h3>
                <p>Geçici plakalar için kullanılır.</p>
                <ul>
                    <li>Kullanım: Geçici kullanım, test araçları</li>
                    <li>Renk: Turuncu zemin, siyah yazı</li>
                </ul>

                <h3>Siyah Plaka</h3>
                <p>Özel izinli araçlar için kullanılır.</p>
                <ul>
                    <li>Kullanım: Özel izinli araçlar</li>
                    <li>Renk: Siyah zemin, beyaz yazı</li>
                </ul>

                <p>Plaka renkleri, araçların kullanım amacını ve statüsünü belirtir.</p>',
                'category' => 'Otomobil Sözlüğü',
                'meta_keywords' => ['plaka renkleri', 'plaka tipleri', 'araç plakaları', 'plaka anlamları'],
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(9),
            ],
            [
                'title' => 'Otomatik Vites Üzerindeki Harfler ve Anlamları',
                'excerpt' => 'Otomatik vitesli araçlarda bulunan harflerin anlamları ve kullanım şekilleri. P, R, N, D, S, L harfleri ne anlama gelir?',
                'content' => '<h2>Otomatik Vites Üzerindeki Harfler ve Anlamları</h2>
                
                <p>Otomatik vitesli araçlarda bulunan harflerin anlamlarını bilmek, güvenli sürüş için önemlidir. İşte otomatik vites harfleri ve anlamları:</p>

                <h3>P - Park (Park)</h3>
                <p>Aracı park etmek için kullanılır. Vites bu konumdayken araç hareket etmez.</p>
                <ul>
                    <li>Kullanım: Park etme, aracı durdurma</li>
                    <li>Dikkat: Araç tamamen durduktan sonra P\'ye alın</li>
                </ul>

                <h3>R - Reverse (Geri)</h3>
                <p>Aracı geri vitese almak için kullanılır.</p>
                <ul>
                    <li>Kullanım: Geri gitme</li>
                    <li>Dikkat: Araç tamamen durduktan sonra R\'ye alın</li>
                </ul>

                <h3>N - Neutral (Boş)</h3>
                <p>Vites boşta konumdadır. Motor çalışır ancak araç hareket etmez.</p>
                <ul>
                    <li>Kullanım: Kısa duruşlar, çekme durumları</li>
                    <li>Dikkat: Uzun süre N\'de bırakmayın</li>
                </ul>

                <h3>D - Drive (Sürüş)</h3>
                <p>Normal sürüş için kullanılır. Vites otomatik olarak değişir.</p>
                <ul>
                    <li>Kullanım: Normal sürüş, şehir içi, otoyol</li>
                    <li>En yaygın kullanılan konum</li>
                </ul>

                <h3>S - Sport (Spor)</h3>
                <p>Spor modu. Daha yüksek devirlerde vites değişimi yapar.</p>
                <ul>
                    <li>Kullanım: Performans sürüşü, yokuş çıkışı</li>
                    <li>Yakıt tüketimi artar</li>
                </ul>

                <h3>L - Low (Düşük)</h3>
                <p>Düşük vites modu. Güçlü çekiş için kullanılır.</p>
                <ul>
                    <li>Kullanım: Yokuş çıkışı, ağır yük çekme</li>
                    <li>Motor devri yüksek kalır</li>
                </ul>

                <p><strong>Önemli:</strong> Her araç modelinde bu harfler farklı olabilir. Mutlaka aracınızın kullanım kılavuzunu okuyun.</p>',
                'category' => 'Otomobil Sözlüğü',
                'meta_keywords' => ['otomatik vites', 'vites harfleri', 'otomatik şanzıman', 'araç kullanımı'],
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(11),
            ],

            // ========== ARAÇ BAKIMI VE ONARIMI ==========
            [
                'title' => 'Araç Bakımında Yapılan En Yaygın Hatalar',
                'excerpt' => 'Araç bakımında yapılan yaygın hatalar ve bu hataların araç performansına etkileri. Doğru bakım yöntemleri ve ipuçları.',
                'content' => '<h2>Araç Bakımında Yapılan En Yaygın Hatalar</h2>
                
                <p>Araç bakımı, aracınızın ömrünü uzatmak ve performansını korumak için kritik öneme sahiptir. Ancak birçok sürücü, bakım konusunda yaygın hatalar yapmaktadır.</p>

                <h3>1. Yağ Değişimini Geciktirmek</h3>
                <p>Motor yağı değişimini geciktirmek, motor ömrünü kısaltır ve performansı düşürür.</p>
                <ul>
                    <li>Önerilen: 10.000-15.000 km aralığında</li>
                    <li>Hata: 20.000 km\'den fazla kullanmak</li>
                </ul>

                <h3>2. Lastik Basıncını Kontrol Etmemek</h3>
                <p>Lastik basıncını düzenli kontrol etmemek:</p>
                <ul>
                    <li>Yakıt tüketimini artırır</li>
                    <li>Lastik ömrünü kısaltır</li>
                    <li>Güvenlik riski oluşturur</li>
                </ul>

                <h3>3. Fren Bakımını İhmal Etmek</h3>
                <p>Fren sistemi, güvenliğiniz için hayati öneme sahiptir. Fren bakımını ihmal etmek:</p>
                <ul>
                    <li>Fren mesafesini uzatır</li>
                    <li>Kaza riskini artırır</li>
                    <li>Maliyetli onarımlara yol açar</li>
                </ul>

                <h3>4. Filtre Değişimini Unutmak</h3>
                <p>Hava, yakıt ve yağ filtrelerinin düzenli değişimi önemlidir:</p>
                <ul>
                    <li>Motor performansını etkiler</li>
                    <li>Yakıt tüketimini artırır</li>
                    <li>Motor ömrünü kısaltır</li>
                </ul>

                <h3>5. Soğutma Sistemini İhmal Etmek</h3>
                <p>Soğutma sistemi bakımı:</p>
                <ul>
                    <li>Motor aşırı ısınmasını önler</li>
                    <li>Performansı korur</li>
                    <li>Maliyetli onarımları önler</li>
                </ul>

                <p>GMSGARAGE, tüm araçlarımızın düzenli bakımlarını yapmaktadır. Satın aldığınız araçlarımız, bakımlı ve hazır durumda teslim edilmektedir.</p>',
                'category' => 'Araç Bakımı ve Onarımı',
                'meta_keywords' => ['araç bakımı', 'bakım hataları', 'araç servisi', 'motor bakımı'],
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(13),
            ],
            [
                'title' => 'Araçlarda En Sık Yanan Arıza Lambaları Ne Anlama Geliyor?',
                'excerpt' => 'Araçlarda yanan arıza lambaları, sürücüleri uyaran önemli göstergelerdir. En sık yanan arıza lambaları ve anlamları.',
                'content' => '<h2>Araçlarda En Sık Yanan Arıza Lambaları Ne Anlama Geliyor?</h2>
                
                <p>Araçlarda yanan arıza lambaları, sürücüleri uyaran önemli göstergelerdir. Bu lambaların anlamlarını bilmek, güvenli sürüş için kritik öneme sahiptir.</p>

                <h3>1. Motor Arıza Lambası (Check Engine)</h3>
                <p>Turuncu/sarı renkli motor arıza lambası:</p>
                <ul>
                    <li>Anlamı: Motor sisteminde bir sorun var</li>
                    <li>Ne yapmalı: Derhal servise gidin</li>
                    <li>Acil durum: Kırmızı yanıyorsa aracı durdurun</li>
                </ul>

                <h3>2. Fren Sistemi Uyarı Lambası</h3>
                <p>Kırmızı fren uyarı lambası:</p>
                <ul>
                    <li>Anlamı: Fren sisteminde sorun var</li>
                    <li>Ne yapmalı: Derhal durun, servise gidin</li>
                    <li>Güvenlik: Kritik öneme sahip</li>
                </ul>

                <h3>3. Yağ Basıncı Uyarı Lambası</h3>
                <p>Kırmızı yağ lambası:</p>
                <ul>
                    <li>Anlamı: Motor yağı basıncı düşük</li>
                    <li>Ne yapmalı: Motoru durdurun, yağ kontrolü yapın</li>
                    <li>Risk: Motor hasarı riski</li>
                </ul>

                <h3>4. Soğutma Sistemi Uyarı Lambası</h3>
                <p>Kırmızı termometre lambası:</p>
                <ul>
                    <li>Anlamı: Motor aşırı ısınıyor</li>
                    <li>Ne yapmalı: Motoru durdurun, soğutun</li>
                    <li>Risk: Motor hasarı riski</li>
                </ul>

                <h3>5. Batarya Uyarı Lambası</h3>
                <p>Kırmızı batarya lambası:</p>
                <ul>
                    <li>Anlamı: Şarj sistemi çalışmıyor</li>
                    <li>Ne yapmalı: Alternatör kontrolü yapın</li>
                    <li>Risk: Batarya boşalması</li>
                </ul>

                <p><strong>Önemli:</strong> Kırmızı uyarı lambaları, acil durumları gösterir. Derhal harekete geçin.</p>',
                'category' => 'Araç Bakımı ve Onarımı',
                'meta_keywords' => ['arıza lambaları', 'araç uyarıları', 'motor arızası', 'araç göstergeleri'],
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(14),
            ],

            // ========== DÜNDEN BUGÜNE ==========
            [
                'title' => 'BMW X Serisinin Tarihi: Dünden Bugüne BMW X',
                'excerpt' => 'BMW X serisi SUV segmentinde X5 modelinin üretilmesiyle piyasada yerini aldı. BMW X serisinin tarihçesi ve gelişimi.',
                'content' => '<h2>BMW X Serisinin Tarihi: Dünden Bugüne BMW X</h2>
                
                <p>BMW X serisi SUV segmentinde X5 modelinin üretilmesiyle piyasada yerini aldı. İşte BMW X serisinin tarihçesi ve gelişimi:</p>

                <h3>BMW X5 (1999) - İlk Model</h3>
                <p>BMW\'nin ilk SUV modeli olan X5, 1999 yılında tanıtıldı. Lüks ve performansı bir araya getiren bu model, segmentinde öncü oldu.</p>

                <h3>BMW X3 (2003) - Kompakt Segment</h3>
                <p>X3, daha kompakt bir SUV modeli olarak 2003 yılında piyasaya çıktı. Şehir kullanımı için ideal bir seçenek sundu.</p>

                <h3>BMW X6 (2008) - Coupe SUV</h3>
                <p>X6, coupe SUV konseptiyle 2008 yılında tanıtıldı. Sportif tasarım ve yüksek performansı bir araya getirdi.</p>

                <h3>BMW X1 (2009) - Küçük Segment</h3>
                <p>X1, en küçük X serisi modeli olarak 2009 yılında piyasaya çıktı. Kompakt boyutlarıyla şehir kullanımı için ideal.</p>

                <h3>BMW X7 (2019) - Büyük Segment</h3>
                <p>X7, en büyük X serisi modeli olarak 2019 yılında tanıtıldı. Lüks ve konfor odaklı tasarımıyla öne çıktı.</p>

                <h3>Günümüz</h3>
                <p>BMW X serisi, günümüzde elektrikli modelleri de içeren geniş bir portföye sahiptir. GMSGARAGE, BMW X serisi modellerinde geniş bir seçenek sunmaktadır.</p>',
                'category' => 'Dünden Bugüne',
                'meta_keywords' => ['BMW X serisi', 'BMW X5', 'BMW tarihi', 'SUV tarihi'],
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(16),
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::create(array_merge($post, [
                'slug' => Str::slug($post['title']),
                'author' => 'GMSGARAGE',
                'meta_title' => $post['title'] . ' - GMSGARAGE Blog',
                'meta_description' => $post['excerpt'],
            ]));
        }
    }
}
