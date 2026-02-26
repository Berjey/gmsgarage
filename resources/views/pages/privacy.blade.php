@extends('layouts.app')

@section('title', 'Gizlilik Politikası - ' . ($settings['site_title'] ?? 'GMSGARAGE'))
@section('description', ($settings['site_title'] ?? 'GMSGARAGE') . ' gizlilik politikası ve kişisel verilerin korunması.')

@section('content')
<section class="section-padding bg-white dark:bg-[#1e1e1e] transition-colors duration-200">
    <div class="container-custom max-w-4xl">
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900 dark:text-gray-100">Gizlilik Politikası</h1>
            <p class="text-gray-600 dark:text-gray-400 text-lg">Kişisel verilerinizin korunması bizim için önemlidir.</p>
        </div>

        <div class="prose prose-lg max-w-none dark:prose-invert">
            <div class="space-y-8">
                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Gizlilik Taahhüdümüz</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        GMSGARAGE olarak, kişisel verilerinizin gizliliğini korumak ve güvenli bir şekilde işlemek 
                        için gerekli tüm teknik ve idari önlemleri almaktayız.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Toplanan Bilgiler</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                        Hizmetlerimiz kapsamında topladığımız bilgiler:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                        <li>İletişim bilgileriniz (ad, soyad, telefon, e-posta)</li>
                        <li>Araç bilgileri (marka, model, yıl, kilometre vb.)</li>
                        <li>Teknik bilgiler (IP adresi, çerez bilgileri)</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Bilgilerin Kullanımı</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        Toplanan bilgiler, hizmetlerimizin sunulması, müşteri taleplerinin karşılanması ve 
                        yasal yükümlülüklerimizin yerine getirilmesi amacıyla kullanılmaktadır.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Güvenlik</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        Kişisel verilerinizin güvenliği için SSL şifreleme, güvenli sunucular ve erişim 
                        kontrolü gibi teknik önlemler uygulanmaktadır.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">İletişim</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        Gizlilik politikamız hakkında sorularınız için: <a href="mailto:info@gmsgarage.com" class="text-primary-600 dark:text-primary-400 hover:underline">info@gmsgarage.com</a>
                    </p>
                </section>
            </div>
        </div>
    </div>
</section>
@endsection
