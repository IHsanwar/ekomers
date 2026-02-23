@extends('layouts.stitch')

@section('content')
<header class="py-16 px-4 border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-black overflow-hidden relative">
    <div class="max-w-7xl mx-auto relative">
        <div class="absolute -top-24 -right-10 opacity-10 dark:opacity-20 select-none pointer-events-none">
            <span class="font-display text-[180px] leading-none">ARKARI</span>
        </div>
        <div class="relative z-10">
            <div class="flex items-center space-x-4 mb-4">
                <span class="h-[2px] w-12 bg-primary"></span>
                <span class="uppercase tracking-widest font-bold text-sm text-primary">Select Sector</span>
            </div>
            <h1 class="font-display text-5xl md:text-7xl font-bold tracking-tighter mb-6">
                PRODUCT<br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">CATEGORIES</span>
            </h1>
            <p class="max-w-xl text-slate-500 dark:text-slate-400 text-lg">
                Browse our curated selection of high-performance apparel and tactical gear designed for the modern urban wanderer.
            </p>
        </div>
    </div>
</header>
<main class="max-w-7xl mx-auto px-4 py-12 md:py-24">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Static Template Item 1 -->
        <div class="group relative aspect-[4/5] overflow-hidden bg-slate-100 dark:bg-card-dark card-skew transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent z-10 opacity-60 group-hover:opacity-80 transition-opacity"></div>
            <img alt="New Arrivals" class="absolute inset-0 w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 scale-105 group-hover:scale-100" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBMoOvzh0DXB0cDWC2aQEYr1U5KpVdZDLFU9Wq151WMLsIxVrGNdzpG0lwv00Nbzigjj0baeABZG6RWoSRL_yGk7F8KfI5XZiIqwThm7TV0eo4PVe9Bd-KO0ts8ECYMyZKz2vGTMsw9gjgrssHyIJn01oyshURp5PoB3zdxvJNZNtQdVp1dKaSRuJceEyIe4ckU2cB9TEaMiJShpH50Ob26DJZqBCk20nSyQ7s8kMclYjayEgvRtOFw1aHleITQwEm8YEBaPusYCoQ"/>
            <div class="absolute top-6 right-6 z-20">
                <span class="bg-primary text-white font-bold px-4 py-1 text-xs tracking-widest uppercase">Drop 04</span>
            </div>
            <div class="absolute bottom-10 left-10 z-20">
                <p class="text-secondary font-display text-xs mb-2 tracking-widest">CHAPTER 01</p>
                <h3 class="font-display text-4xl font-bold text-white mb-4 leading-none">NEW<br/>ARRIVALS</h3>
                <div class="flex items-center space-x-4 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">
                    <span class="text-white font-bold tracking-widest text-sm">EXPLORE GEAR</span>
                    <span class="material-icons-sharp text-primary">arrow_right_alt</span>
                </div>
            </div>
            <div class="absolute inset-0 border-[1px] border-white/10 group-hover:border-primary/50 transition-colors pointer-events-none z-30"></div>
        </div>

        <!-- Static Template Item 2 -->
        <div class="group relative aspect-[4/5] overflow-hidden bg-slate-100 dark:bg-card-dark card-skew transition-all duration-500 cursor-pointer md:col-span-2 lg:col-span-1">
            <div class="absolute inset-0 bg-gradient-to-br from-secondary/40 via-transparent to-black/80 z-10 opacity-70"></div>
            <img alt="Best Sellers" class="absolute inset-0 w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDV8q_iVbg8nwQFGf5cNFJ4HJsGLuVOZbeMfkOk4JVdhYAYAxDXmS35in8-IjsGvXZ_Jyio5UeluADfenmk9NlGZtfPeH_8ZXsqVJLwvTITyBHh7gkl122AsrXCc4S9-9Y27_vNexLeJyF3A4iHKM9tBhk13Y0bMQCT2Y0ilzwMWcvQkAxE5xcnPvpGsHoGmLTIQdaT4Hd3Wwn_J6xfMULphLAni99hsPsLgegVi1dXWAJRhdynMw27pftIZszd1lMC1xOjA8f5bPA"/>
            <div class="absolute inset-0 flex items-center justify-center z-20">
                <div class="text-center">
                    <h3 class="font-display text-6xl font-black text-white mix-blend-overlay group-hover:mix-blend-normal transition-all duration-500 mb-2">BEST SELLERS</h3>
                    <p class="text-secondary tracking-[0.5em] font-bold text-sm uppercase">Legacy Series</p>
                </div>
            </div>
            <div class="absolute bottom-8 right-8 z-20 bg-black/50 backdrop-blur-sm p-4 border border-secondary/30">
                <span class="material-icons-sharp text-secondary text-3xl">trending_up</span>
            </div>
        </div>

        <!-- Static Template Item 3 -->
        <div class="group relative aspect-[4/5] overflow-hidden bg-slate-100 dark:bg-card-dark card-skew transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-primary/20 z-10 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent z-10"></div>
            <img alt="Limited Edition" class="absolute inset-0 w-full h-full object-cover grayscale group-hover:sepia transition-all duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBSDDUCluWkQF3tZES0p0HhJhjK8q9ByVVRZYCsjYw4kP34bqsyuuif8hvVhhA7ipkwBQEUjFMVT1kBO4rS4G8YImUs4XCRX6bcXIwdKp0V5C8Edol2GLtNldrlWUEaBExUzMgB4vKYqbLEyd-2taHxPRVJrJeXamCYkyRhi21ygrTvSeb_SdYUw6D69tRYNS_uAfnDShY40MgbcHxLOR4s-9aRVXoQOlxlSpmxhctEmVCOq7ARaJDPbRRHnpu2bMC7dXxxVVY2Cn0"/>
            <div class="absolute top-10 left-10 z-20">
                <div class="h-1 w-12 bg-secondary mb-4"></div>
                <h3 class="font-display text-4xl font-bold text-white mb-1">LIMITED</h3>
                <h3 class="font-display text-4xl font-bold text-primary italic">EDITION</h3>
            </div>
            <div class="absolute bottom-10 left-10 right-10 z-20">
                <p class="text-slate-300 text-xs font-mono uppercase tracking-tighter mb-4 border-l-2 border-primary pl-4">ONLY 100 UNITS PRODUCED PER DESIGN. NO RESTOCKS.</p>
            </div>
        </div>

        <!-- Static Template Item 4 (Span 2) -->
        <div class="group relative aspect-[4/5] overflow-hidden bg-slate-100 dark:bg-card-dark card-skew transition-all duration-500 cursor-pointer lg:col-span-2">
            <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/40 to-transparent z-10"></div>
            <img alt="Tactical Gear" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAl6ytTKhwI1JlgYh7soNQ1GXSDtAZfqgSw_BOP0ssFtFMDHMHCk5kkKJPReZZoS1pglVeBaylDsZkmWQzW4eYraQVGMBzYOQr0bVAeFV0dJHEg8eKdYq0IBPdu2W1kMC_mzJc7McbUfzfJsssBeTxfx3P_T_RojQyFSlUfxxPUir7GK1rlLL0xI4t5YNpk2fpFVjq-GCyLir4bqLLktQIpJB8l9BurMuMiZYwnJ0K848IbW7TEstFcpOrZJ-U25GD8qcPubZ4Sy1A"/>
            <div class="absolute inset-0 flex items-center p-12 z-20">
                <div class="max-w-md">
                    <span class="inline-block px-3 py-1 bg-secondary text-black font-bold text-[10px] tracking-widest uppercase mb-6">Spec-Ops Series</span>
                    <h3 class="font-display text-5xl md:text-6xl font-bold text-white mb-6 leading-[0.9]">TACTICAL<br/><span class="text-secondary">FOOTWEAR</span></h3>
                    <p class="text-slate-300 mb-8 hidden md:block">Engineered for endurance. Our latest tech-wear inspired footwear combines urban aesthetics with rugged functionality.</p>
                    <button class="border border-white/30 px-8 py-3 text-white font-bold tracking-widest text-xs hover:bg-white hover:text-black transition-all">VIEW COLLECTION</button>
                </div>
            </div>
        </div>

        <!-- Static Template Item 5 -->
        <div class="group relative aspect-[4/5] overflow-hidden bg-slate-100 dark:bg-card-dark card-skew transition-all duration-500 cursor-pointer">
            <div class="absolute inset-0 bg-black/40 z-10"></div>
            <img alt="Accessories" class="absolute inset-0 w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB2N3keSFs_JZCMM6SrNlOkewkDlmunRJHrIgb_H706uwcA68dqQeOoxWW7HipEpL4i2SLQV393ndKSC4LbLTUd3A9q1GpvhuUS2wouhxwIFIFFjoyr1ATuNbyS7bcb53TBYTPNoZdcoVgh30bQfMtnbZxdZs92wzUaMVPDVA40bzcUgsQxol3r6XokQl5KGbRQNbvpBF2bSXxKkRZk-xwhGz_twQlNsWiRqchxA-5m7JVj7u1SLwOdwafK17HjBd__shxLihf6V1k"/>
            <div class="absolute inset-0 flex flex-col justify-end p-10 z-20">
                <div class="border-t-2 border-secondary pt-4">
                    <h3 class="font-display text-3xl font-bold text-white">ACCESSORIES</h3>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-slate-400 text-xs tracking-widest">HATS / BAGS / TECH</span>
                        <span class="material-icons-sharp text-secondary">add_circle_outline</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic Products Section (Hidden or merged if needed, for now keeping static as requested) -->
    @if(isset($products) && $products->count() > 0)
        <div class="mt-24">
            <div class="flex items-center space-x-4 mb-8">
                <span class="h-[2px] w-12 bg-secondary"></span>
                <h2 class="font-display text-3xl font-bold">LATEST PRODUCTS</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="group relative bg-slate-100 dark:bg-card-dark card-skew transition-all duration-500 cursor-pointer overflow-hidden">
                        <div class="aspect-square relative overflow-hidden">
                            <img src="{{ $product->image_url ?? 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                             <div class="absolute top-2 right-2 bg-black/70 text-white text-xs px-2 py-1 font-mono">
                                {{ number_format($product->price, 0, ',', '.') }} IDR
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-display text-lg font-bold mb-1 group-hover:text-primary transition-colors">{{ $product->name }}</h3>
                            <p class="text-slate-500 text-xs truncate">{{ $product->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</main>
@endsection