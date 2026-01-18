@extends('layouts.app')

@section('title', 'KVKK Aydınlatma Metni - GMSGARAGE')
@section('description', 'GMSGARAGE Kişisel Verilerin Korunması Kanunu (KVKK) aydınlatma metni.')

@section('content')
<section class="section-padding bg-white dark:bg-[#1e1e1e] transition-colors duration-200">
    <div class="container-custom max-w-4xl">
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900 dark:text-gray-100">KVKK Aydınlatma Metni</h1>
            <p class="text-gray-600 dark:text-gray-400 text-lg">6698 Sayılı Kişisel Verilerin Korunması Kanunu Uyarınca</p>
        </div>

        <div class="prose prose-lg max-w-none dark:prose-invert">
            <div class="bg-gray-50 dark:bg-[#252525] border-l-4 border-primary-600 dark:border-primary-500 p-6 mb-8 transition-colors duration-200">
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                    <strong>GMSGARAGE</strong> olarak, 6698 sayılı Kişisel Verilerin Korunması Kanunu ("KVKK") uyarınca, 
                    kişisel verilerinizin işlenmesi ve korunması konusunda sizleri bilgilendirmek isteriz.
                </p>
            </div>

            <div class="space-y-8">
                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">1. Veri Sorumlusu</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                        Kişisel verileriniz, <strong>GMSGARAGE</strong> tarafından veri sorumlusu sıfatıyla işlenmektedir.
                    </p>
                    <div class="bg-gray-50 dark:bg-[#252525] p-4 rounded-lg transition-colors duration-200">
                        <p class="text-gray-700 dark:text-gray-300"><strong>İletişim Bilgileri:</strong></p>
                        <p class="text-gray-600 dark:text-gray-400">E-posta: info@gmsgarage.com</p>
                        <p class="text-gray-600 dark:text-gray-400">Telefon: 0555 123 45 67</p>
                        <p class="text-gray-600 dark:text-gray-400">Adres: Görsel Mah. Kağıthane Cad. No: 26 /1A KAĞITHANE/İSTANBUL</p>
                    </div>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">2. İşlenen Kişisel Veriler</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                        Hizmetlerimiz kapsamında aşağıdaki kişisel verileriniz işlenmektedir:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                        <li><strong>Kimlik Bilgileri:</strong> Ad, soyad</li>
                        <li><strong>İletişim Bilgileri:</strong> Telefon numarası, e-posta adresi, adres bilgisi</li>
                        <li><strong>Araç Bilgileri:</strong> Araç tipi, marka, model, yıl, kilometre, yakıt tipi, vites tipi</li>
                        <li><strong>İşlem Bilgileri:</strong> Talep geçmişi, değerleme bilgileri</li>
                        <li><strong>Teknik Bilgiler:</strong> IP adresi, çerez bilgileri, tarayıcı bilgileri</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">3. Kişisel Verilerin İşlenme Amaçları</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                        Kişisel verileriniz aşağıdaki amaçlarla işlenmektedir:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                        <li>Araç değerleme ve satış hizmetlerinin sunulması</li>
                        <li>Müşteri taleplerinin karşılanması ve iletişim kurulması</li>
                        <li>Hukuki yükümlülüklerin yerine getirilmesi</li>
                        <li>Hizmet kalitesinin artırılması ve geliştirilmesi</li>
                        <li>Kampanya ve promosyon bilgilendirmeleri (izin verilmesi halinde)</li>
                        <li>Güvenlik ve hukuki uyumluluk gerekliliklerinin sağlanması</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">4. Kişisel Verilerin İşlenme Hukuki Sebepleri</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                        Kişisel verileriniz aşağıdaki hukuki sebeplere dayanarak işlenmektedir:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                        <li>KVKK Madde 5/2(c): Açık rızanız</li>
                        <li>KVKK Madde 5/2(f): Hukuki yükümlülüğün yerine getirilmesi</li>
                        <li>KVKK Madde 5/2(e): Veri sorumlusunun hukuki yükümlülüğünü yerine getirebilmesi için zorunlu olması</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">5. Kişisel Verilerin Aktarılması</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                        Kişisel verileriniz, yukarıda belirtilen amaçların gerçekleştirilmesi için, 
                        yasal yükümlülüklerimiz kapsamında ve sadece gerekli ölçüde aşağıdaki taraflarla paylaşılabilir:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                        <li>Yasal merciler (mahkemeler, savcılıklar vb.)</li>
                        <li>Hizmet sağlayıcılarımız (hosting, e-posta servisleri vb.)</li>
                        <li>İş ortaklarımız (sadece hizmet sunumu için gerekli olduğunda)</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">6. Kişisel Verilerin Saklanma Süresi</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        Kişisel verileriniz, işleme amacının gerektirdiği süre boyunca ve yasal saklama süreleri 
                        kapsamında saklanmaktadır. Bu süre sona erdiğinde, verileriniz yasalara uygun şekilde silinir, 
                        yok edilir veya anonim hale getirilir.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">7. KVKK Kapsamındaki Haklarınız</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                        KVKK'nın 11. maddesi uyarınca aşağıdaki haklara sahipsiniz:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                        <li>Kişisel verilerinizin işlenip işlenmediğini öğrenme</li>
                        <li>İşlenmişse buna ilişkin bilgi talep etme</li>
                        <li>İşlenme amacını ve amacına uygun kullanılıp kullanılmadığını öğrenme</li>
                        <li>Yurt içinde veya yurt dışında aktarıldığı üçüncü kişileri bilme</li>
                        <li>Eksik veya yanlış işlenmişse düzeltilmesini isteme</li>
                        <li>KVKK'da öngörülen şartlar çerçevesinde silinmesini veya yok edilmesini isteme</li>
                        <li>Düzeltme, silme, yok etme işlemlerinin aktarıldığı üçüncü kişilere bildirilmesini isteme</li>
                        <li>İşlenen verilerin münhasıran otomatik sistemler ile analiz edilmesi suretiyle aleyhinize bir sonucun ortaya çıkmasına itiraz etme</li>
                        <li>Kanuna aykırı olarak işlenmesi sebebiyle zarara uğramanız halinde zararın giderilmesini talep etme</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">8. Başvuru Hakkı</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                        KVKK kapsamındaki haklarınızı kullanmak için, kimliğinizi tespit edici belgelerle birlikte 
                        yazılı olarak başvuruda bulunabilirsiniz. Başvurularınız en geç 30 gün içinde sonuçlandırılacaktır.
                    </p>
                    <div class="bg-gray-50 dark:bg-[#252525] p-4 rounded-lg transition-colors duration-200">
                        <p class="text-gray-700 dark:text-gray-300"><strong>Başvuru Adresi:</strong></p>
                        <p class="text-gray-600 dark:text-gray-400">E-posta: info@gmsgarage.com</p>
                        <p class="text-gray-600 dark:text-gray-400">Konu: KVKK Başvurusu</p>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed mt-4">
                        Ayrıca, Kişisel Verileri Koruma Kurulu'na şikayette bulunma hakkınız da bulunmaktadır.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">9. Değişiklikler</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        Bu aydınlatma metni, yasal düzenlemelerdeki değişiklikler ve hizmetlerimizdeki güncellemeler 
                        doğrultusunda güncellenebilir. Güncel metin her zaman web sitemizde yayınlanmaktadır.
                    </p>
                </section>

                <div class="bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800 rounded-lg p-6 mt-8 transition-colors duration-200">
                    <p class="text-primary-800 dark:text-primary-300 font-semibold mb-2">Son Güncelleme: {{ date('d.m.Y') }}</p>
                    <p class="text-primary-700 dark:text-primary-400 text-sm">
                        Bu aydınlatma metni, 6698 sayılı Kişisel Verilerin Korunması Kanunu uyarınca hazırlanmıştır.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
