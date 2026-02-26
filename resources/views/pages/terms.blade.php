@extends('layouts.app')

@section('title', 'Kullanım Şartları - ' . ($settings['site_title'] ?? 'GMSGARAGE'))
@section('description', ($settings['site_title'] ?? 'GMSGARAGE') . ' web sitesi kullanım şartları.')

@section('content')
<section class="section-padding bg-white dark:bg-[#1e1e1e] transition-colors duration-200">
    <div class="container-custom max-w-4xl">
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900 dark:text-gray-100">Kullanım Şartları</h1>
            <p class="text-gray-600 dark:text-gray-400 text-lg">Web sitemizi kullanmadan önce lütfen bu şartları okuyunuz.</p>
        </div>

        <div class="prose prose-lg max-w-none dark:prose-invert">
            <div class="space-y-8">
                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Genel Hükümler</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        Bu web sitesini kullanarak, aşağıdaki kullanım şartlarını kabul etmiş sayılırsınız.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Hizmetler</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        GMSGARAGE, araç satış, alış ve değerleme hizmetleri sunmaktadır. Hizmetlerimiz 
                        hakkında detaylı bilgi için lütfen bizimle iletişime geçiniz.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Kullanıcı Yükümlülükleri</h2>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700 dark:text-gray-300">
                        <li>Doğru ve güncel bilgi sağlamak</li>
                        <li>Web sitesini yasalara aykırı amaçlarla kullanmamak</li>
                        <li>Başkalarının haklarına saygı göstermek</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Fikri Mülkiyet</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        Web sitesindeki tüm içerik, logo, tasarım ve markalar GMSGARAGE'ye aittir ve 
                        telif hakkı koruması altındadır.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Sorumluluk Reddi</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        Web sitesinde yer alan bilgiler genel bilgilendirme amaçlıdır. Hizmetlerimiz 
                        hakkında kesin bilgi için lütfen bizimle iletişime geçiniz.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Değişiklikler</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        Bu kullanım şartları, önceden haber vermeksizin değiştirilebilir. 
                        Güncel şartlar her zaman web sitemizde yayınlanmaktadır.
                    </p>
                </section>
            </div>
        </div>
    </div>
</section>
@endsection
