@extends('layouts.frontend')
@section('content')
!!!! UNUSED PAGE !!!!
{{-- ============================================================
     HERO SECTION
     ============================================================ --}}
<section class="bg-blue-700 text-white">
    <div class="container mx-auto px-6 py-20">
        <div class="flex flex-col lg:flex-row items-center gap-12">

            {{-- Text --}}
            <div class="flex-1 text-center lg:text-left">
                <span class="inline-block bg-blue-500 text-blue-100 text-sm font-semibold px-4 py-1 rounded-full mb-5 tracking-wide">
                    🛒 Toko Online Terpercaya #1
                </span>
                <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight mb-5">
                    Belanja Lebih Mudah,<br>Harga Lebih Hemat
                </h1>
                <p class="text-blue-100 text-lg mb-8 max-w-lg mx-auto lg:mx-0">
                    Temukan ribuan produk berkualitas dari berbagai kategori. Pengiriman cepat, pembayaran aman, dan layanan pelanggan siap membantu 24/7.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('register') }}"
                       class="px-8 py-3.5 bg-white text-blue-700 rounded-lg font-bold text-base hover:bg-blue-50 transition-colors duration-200 shadow-md">
                        Daftar Gratis
                    </a>
                    <a href="{{ route('products.index') }}"
                       class="px-8 py-3.5 border-2 border-white text-white rounded-lg font-bold text-base hover:bg-white hover:text-blue-700 transition-colors duration-200">
                        Jelajahi Produk
                    </a>
                </div>
                <p class="mt-5 text-blue-200 text-sm">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="underline text-white font-medium hover:text-blue-100">Masuk di sini</a>
                </p>
            </div>

            {{-- Image --}}
            <div class="flex-1 flex justify-center">
                <div class="bg-blue-600 rounded-2xl p-6 shadow-2xl max-w-sm w-full">
                    <img src="https://img.freepik.com/premium-vector/shopping-cart-logo-design-vector-modern-shopping-cart-logo-template_472998-93.jpg?w=2000"
                         alt="Ilustrasi Belanja Online"
                         class="w-full rounded-xl object-cover">
                    {{-- Stats bar below image --}}
                    <div class="mt-5 grid grid-cols-3 divide-x divide-blue-500 text-center">
                        <div class="px-2">
                            <div class="font-bold text-lg">10K+</div>
                            <div class="text-blue-200 text-xs">Produk</div>
                        </div>
                        <div class="px-2">
                            <div class="font-bold text-lg">50K+</div>
                            <div class="text-blue-200 text-xs">Pelanggan</div>
                        </div>
                        <div class="px-2">
                            <div class="font-bold text-lg">4.8★</div>
                            <div class="text-blue-200 text-xs">Rating</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ============================================================
     TRUST BADGES / KEUNGGULAN
     ============================================================ --}}
<section class="bg-white border-b border-gray-100 py-14">
    <div class="container mx-auto px-6">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Kenapa Belanja di TokoKu?</h2>
            <p class="text-gray-500">Kami berkomitmen memberikan pengalaman belanja terbaik untuk Anda</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="flex items-start gap-4 p-5 bg-gray-50 rounded-xl hover:shadow-md transition-shadow duration-200">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-truck-fast text-xl text-blue-600"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">Pengiriman Cepat</h3>
                    <p class="text-gray-500 text-sm">Estimasi tiba 1–3 hari kerja ke seluruh Indonesia</p>
                </div>
            </div>

            <div class="flex items-start gap-4 p-5 bg-gray-50 rounded-xl hover:shadow-md transition-shadow duration-200">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-shield-halved text-xl text-green-600"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">Produk Original</h3>
                    <p class="text-gray-500 text-sm">100% produk asli bersertifikat dari penjual terverifikasi</p>
                </div>
            </div>

            <div class="flex items-start gap-4 p-5 bg-gray-50 rounded-xl hover:shadow-md transition-shadow duration-200">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-rotate-left text-xl text-yellow-600"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">Garansi Pengembalian</h3>
                    <p class="text-gray-500 text-sm">Tidak puas? Kembalikan produk dalam 7 hari tanpa syarat</p>
                </div>
            </div>

            <div class="flex items-start gap-4 p-5 bg-gray-50 rounded-xl hover:shadow-md transition-shadow duration-200">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-headset text-xl text-blue-600"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">Layanan 24/7</h3>
                    <p class="text-gray-500 text-sm">Tim dukungan kami siap membantu kapan pun Anda butuhkan</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     KATEGORI PRODUK
     ============================================================ --}}
<section class="bg-gray-50 py-14">
    <div class="container mx-auto px-6">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-1">Kategori Produk</h2>
                <p class="text-gray-500 text-sm">Jelajahi produk berdasarkan kategori favorit Anda</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-blue-600 text-sm font-semibold hover:underline">
                Lihat Semua →
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
            @if(isset($categories))
                @foreach($categories->take(6) as $category)
                    <a href="#"
                       class="flex flex-col items-center gap-2 p-4 bg-white rounded-xl border border-gray-200 hover:border-blue-400 hover:shadow-md transition-all duration-200 text-center group">
                        <div class="w-12 h-12 bg-blue-50 group-hover:bg-blue-100 rounded-full flex items-center justify-center transition-colors">
                            <i class="fa-solid fa-tag text-blue-500 text-lg"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600">{{ $category->name }}</span>
                    </a>
                @endforeach
            @else
                @php
                    $defaultCategories = [
                        ['name' => 'Elektronik',  'icon' => 'fa-laptop'],
                        ['name' => 'Fashion',     'icon' => 'fa-shirt'],
                        ['name' => 'Makanan',     'icon' => 'fa-utensils'],
                        ['name' => 'Kecantikan',  'icon' => 'fa-spa'],
                        ['name' => 'Olahraga',    'icon' => 'fa-dumbbell'],
                        ['name' => 'Perabotan',   'icon' => 'fa-couch'],
                    ];
                @endphp
                @foreach($defaultCategories as $cat)
                    <a href="#"
                       class="flex flex-col items-center gap-2 p-4 bg-white rounded-xl border border-gray-200 hover:border-blue-400 hover:shadow-md transition-all duration-200 text-center group">
                        <div class="w-12 h-12 bg-blue-50 group-hover:bg-blue-100 rounded-full flex items-center justify-center transition-colors">
                            <i class="fa-solid {{ $cat['icon'] }} text-blue-500 text-lg"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600">{{ $cat['name'] }}</span>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
</section>

{{-- ============================================================
     PRODUK PILIHAN
     ============================================================ --}}
<section class="bg-white py-14">
    <div class="container mx-auto px-6">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-1">Produk Pilihan</h2>
                <p class="text-gray-500 text-sm">Produk terlaris dan paling disukai pelanggan kami</p>
            </div>
            <a href="{{ route('products.index') }}"
               class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold text-sm transition-colors duration-200">
                Lihat Semua
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
            @if(isset($products))
                @foreach($products->take(10) as $product)
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden flex flex-col">
                        <div class="relative aspect-square overflow-hidden bg-gray-50">
                            <img src="{{ $product->image_url ?: 'https://via.placeholder.com/400x400?text=Produk' }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-2 left-2 text-white text-xs font-bold px-2 py-0.5 rounded {{ $product->quantity <= 0 ? 'bg-red-500' : 'bg-green-500' }}">
                                {{ $product->quantity <= 0 ? 'HABIS' : 'READY' }}
                            </span>
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="text-sm font-semibold text-gray-800 mb-1 line-clamp-2 leading-snug flex-1">
                                {{ $product->name }}
                            </h3>
                            @if($product->category)
                                <p class="text-xs text-gray-400 mb-2">{{ $product->category->name }}</p>
                            @endif
                            <p class="text-base font-bold text-blue-700 mb-3">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            <a href="{{ route('login') }}"
                               class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-semibold transition-colors duration-200">
                                Beli Sekarang
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                @for($i = 1; $i <= 5; $i++)
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden flex flex-col">
                        <div class="relative aspect-square overflow-hidden bg-gray-50">
                            <img src="https://via.placeholder.com/400x400?text=Produk+{{ $i }}"
                                 alt="Produk {{ $i }}"
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-2 left-2 bg-green-500 text-white text-xs font-bold px-2 py-0.5 rounded">READY</span>
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="text-sm font-semibold text-gray-800 mb-1 line-clamp-2 leading-snug flex-1">
                                Produk Berkualitas {{ $i }}
                            </h3>
                            <p class="text-xs text-gray-400 mb-2">Elektronik</p>
                            <p class="text-base font-bold text-blue-700 mb-3">
                                Rp {{ number_format(100000 * $i, 0, ',', '.') }}
                            </p>
                            <a href="{{ route('login') }}"
                               class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-semibold transition-colors duration-200">
                                Beli Sekarang
                            </a>
                        </div>
                    </div>
                @endfor
            @endif
        </div>
    </div>
</section>

{{-- ============================================================
     STATISTIK
     ============================================================ --}}
<section class="bg-blue-700 text-white py-14">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-extrabold mb-1">10.000+</div>
                <div class="text-blue-200 text-sm">Produk Tersedia</div>
            </div>
            <div>
                <div class="text-4xl font-extrabold mb-1">50.000+</div>
                <div class="text-blue-200 text-sm">Pelanggan Puas</div>
            </div>
            <div>
                <div class="text-4xl font-extrabold mb-1">100+</div>
                <div class="text-blue-200 text-sm">Kategori Produk</div>
            </div>
            <div>
                <div class="text-4xl font-extrabold mb-1">4,8 / 5</div>
                <div class="text-blue-200 text-sm">Rating Toko</div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     CALL TO ACTION
     ============================================================ --}}
<section class="bg-white py-16">
    <div class="container mx-auto px-6">
        <div class="bg-blue-50 border border-blue-100 rounded-2xl px-8 py-12 text-center max-w-2xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-800 mb-3">Siap Mulai Belanja?</h2>
            <p class="text-gray-500 mb-7">Daftar sekarang secara gratis dan nikmati penawaran eksklusif untuk member baru. Ribuan produk menanti Anda!</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                   class="px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold transition-colors duration-200 shadow-md">
                    Daftar Gratis Sekarang
                </a>
                <a href="{{ route('products.index') }}"
                   class="px-8 py-3.5 border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg font-bold transition-colors duration-200">
                    Lihat Produk Dulu
                </a>
            </div>
        </div>
    </div>
</section>

@endsection