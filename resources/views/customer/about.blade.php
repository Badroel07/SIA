@extends('customer.layouts.app')

@section('content')

<!-- 1. HERO SECTION (Compact) -->
<section class="relative py-20 md:py-32 backdrop-blur-sm backdrop-brightness-50 overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 -z-20">
        <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=1920&auto=format&fit=crop"
            alt="Medical Team"
            class="w-full h-full object-cover object-center opacity-30">
    </div>
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 -z-10"></div>

    <div class="container mx-auto px-4 text-center relative z-10">
        <span class="text-blue-500 font-bold tracking-wider uppercase text-sm mb-2 block">
            Who We Are
        </span>
        <h1 class="text-4xl md:text-5xl font-heading font-bold text-white mb-6">
            Tentang Pharma ITG
        </h1>
        <p class="text-blue-100 text-lg max-w-2xl mx-auto leading-relaxed">
            Dedikasi kami untuk memberikan layanan kesehatan terbaik dan obat-obatan berkualitas bagi masyarakat Garut dan sekitarnya.
        </p>
    </div>
</section>

<!-- 2. OUR STORY SECTION -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <!-- Image Side -->
            <div class="md:w-1/2 relative">
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-brand-teal rounded-tl-3xl -z-10"></div>
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-brand-blue rounded-br-3xl -z-10"></div>
                <img src="https://images.unsplash.com/photo-1585435557343-3b092031a831?q=80&w=1000&auto=format&fit=crop"
                    alt="Pharmacy Interior"
                    class="rounded-xl shadow-xl w-full object-cover h-[400px]">
            </div>

            <!-- Text Side -->
            <div class="md:w-1/2">
                <h2 class="text-3xl font-heading font-bold text-gray-900 mb-6">
                    Melayani Kesehatan Keluarga Sejak <span class="text-brand-blue">2015</span>
                </h2>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Pharma ITG bermula dari sebuah apotek kecil di pusat kota Garut. Dengan visi untuk mempermudah akses obat-obatan berkualitas, kami kini telah berkembang menjadi sistem informasi apotek digital yang terintegrasi.
                </p>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Kami percaya bahwa kesehatan adalah aset paling berharga. Oleh karena itu, seluruh produk yang kami sediakan dijamin 100% asli, tersertifikasi BPOM, dan ditangani langsung oleh Apoteker profesional lulusan terbaik.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-brand-blue">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">100% Asli</h4>
                            <p class="text-sm text-gray-500">Produk Terjamin</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-teal-50 rounded-full flex items-center justify-center text-brand-teal">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">24/7 Support</h4>
                            <p class="text-sm text-gray-500">Layanan Cepat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. STATS COUNTER -->
<section class="bg-blue-500 py-16 text-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-heading font-bold mb-2 text-brand-teal">10+</div>
                <p class="text-blue-200 text-sm uppercase tracking-wide">Tahun Pengalaman</p>
            </div>
            <div>
                <div class="text-4xl font-heading font-bold mb-2 text-brand-teal">5k+</div>
                <p class="text-blue-200 text-sm uppercase tracking-wide">Pelanggan Puas</p>
            </div>
            <div>
                <div class="text-4xl font-heading font-bold mb-2 text-brand-teal">500+</div>
                <p class="text-blue-200 text-sm uppercase tracking-wide">Jenis Obat</p>
            </div>
            <div>
                <div class="text-4xl font-heading font-bold mb-2 text-brand-teal">20+</div>
                <p class="text-blue-200 text-sm uppercase tracking-wide">Ahli Medis</p>
            </div>
        </div>
    </div>
</section>

<!-- 4. TEAM SECTION -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="text-brand-teal font-bold uppercase text-sm">Our Team</span>
            <h2 class="text-3xl font-heading font-bold text-gray-900 mt-2">Meet Our Expert Pharmacists</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            <!-- Team 1 -->
            <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden group">
                <div class="h-64 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?q=80&w=800&auto=format&fit=crop" alt="Doctor" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-brand-blue/80 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center gap-4">
                        <a href="#" class="text-white hover:text-brand-teal"><i class="font-bold">in</i></a>
                        <a href="#" class="text-white hover:text-brand-teal"><i class="font-bold">tw</i></a>
                    </div>
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-gray-900 text-lg">Dr. Sarah Wijaya</h3>
                    <p class="text-brand-teal text-sm font-medium">Kepala Apoteker</p>
                </div>
            </div>

            <!-- Team 2 -->
            <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden group">
                <div class="h-64 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?q=80&w=800&auto=format&fit=crop" alt="Doctor" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-gray-900 text-lg">Apt. Budi Santoso</h3>
                    <p class="text-brand-teal text-sm font-medium">Spesialis Obat Klinis</p>
                </div>
            </div>

            <!-- Team 3 -->
            <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden group">
                <div class="h-64 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1594824476967-48c8b964273f?q=80&w=800&auto=format&fit=crop" alt="Doctor" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-gray-900 text-lg">Dr. Jessica Lee</h3>
                    <p class="text-brand-teal text-sm font-medium">Konsultan Kesehatan</p>
                </div>
            </div>

            <!-- Team 4 -->
            <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden group">
                <div class="h-64 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?q=80&w=800&auto=format&fit=crop" alt="Doctor" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-gray-900 text-lg">Apt. Rian Hidayat</h3>
                    <p class="text-brand-teal text-sm font-medium">Manajer Operasional</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection