@extends('layouts.app')

@section('title', 'Hakkımızda - GMSGARAGE')
@section('description', 'GMSGARAGE hakkında bilgiler. Premium ikinci el araç sektöründe güvenilir hizmet.')

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-12">
        <div class="container-custom">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Hakkımızda</h1>
            <p class="text-primary-200">GMSGARAGE olarak hikayemiz</p>
        </div>
    </section>

    <!-- About Content -->
    <section class="py-16">
        <div class="container-custom">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg p-8 md:p-12 mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Güvenilir Oto Galeri Hizmeti</h2>
                    <div class="prose prose-lg max-w-none text-gray-700">
                        <p class="mb-4">
                            GMSGARAGE olarak, ikinci el araç sektöründe yıllardır müşterilerimize güvenilir, şeffaf ve kaliteli hizmet sunmaktayız. Misyonumuz, müşterilerimize en iyi araç seçeneklerini en uygun fiyatlarla sunmak ve satış sonrası desteğimizle yanlarında olmaktır.
                        </p>
                        <p class="mb-4">
                            Tüm araçlarımız detaylı bir kontrol ve ekspertiz sürecinden geçmektedir. Bu sayede müşterilerimize garantili, bakımlı ve güvenilir araçlar sunuyoruz. Sektördeki deneyimimiz ve müşteri memnuniyeti odaklı yaklaşımımız ile binlerce mutlu müşteriye hizmet verdik.
                        </p>
                        <p class="mb-4">
                            Geniş araç yelpazemiz, esnek ödeme seçeneklerimiz ve profesyonel ekibimiz ile araç alım-satım sürecinizi kolaylaştırıyoruz. Müşterilerimizin ihtiyaçlarına en uygun çözümleri sunmak için sürekli kendimizi geliştiriyoruz.
                        </p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                        <div class="text-4xl font-bold text-primary-600 mb-2">15+</div>
                        <div class="text-gray-600">Yıllık Deneyim</div>
                    </div>
                    <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                        <div class="text-4xl font-bold text-primary-600 mb-2">1000+</div>
                        <div class="text-gray-600">Mutlu Müşteri</div>
                    </div>
                    <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                        <div class="text-4xl font-bold text-primary-600 mb-2">500+</div>
                        <div class="text-gray-600">Satılan Araç</div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-8 md:p-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Değerlerimiz</h2>
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Güvenilirlik</h3>
                            <p class="text-gray-700">
                                Tüm işlemlerimizde şeffaflık ve dürüstlük ilkelerimizle hareket ediyoruz. Müşterilerimizin güvenini kazanmak en öncelikli hedefimizdir.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Kalite</h3>
                            <p class="text-gray-700">
                                Sunduğumuz tüm araçlar detaylı kontrol ve ekspertiz sürecinden geçmektedir. Kalite standartlarımızdan ödün vermiyoruz.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Müşteri Memnuniyeti</h3>
                            <p class="text-gray-700">
                                Müşterilerimizin memnuniyeti bizim için her şeyden önemlidir. Satış öncesi ve sonrası tüm süreçlerde yanlarında oluyoruz.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
