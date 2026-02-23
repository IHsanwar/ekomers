<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&amp;family=Syncopate:wght@400;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .anime-gradient-orange {
            background: linear-gradient(135deg, #FF5F1F 0%, #FF2E00 100%);
        }
        .anime-gradient-green {
            background: linear-gradient(135deg, #39FF14 0%, #1DB954 100%);
        }
        .text-glow-orange {
            text-shadow: 0 0 10px rgba(255, 95, 31, 0.5);
        }
        .text-glow-green {
            text-shadow: 0 0 10px rgba(57, 255, 20, 0.5);
        }
        .card-skew:hover {
            transform: translateY(-8px) skewX(-1deg);
        }
        .custom-dashed {
            background-image: linear-gradient(to right, currentColor 50%, rgba(255,255,255,0) 0%);
            background-position: bottom;
            background-size: 20px 2px;
            background-repeat: repeat-x;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 font-sans transition-colors duration-300">
    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}">
                        <img alt="Arkari Design Logo" class="h-12 dark:invert" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCPZQISrbJdNl63z1qgRg3fbLH4Y0zXUZ-WR4BwoKlSgAbLvjKgG4Y2xJc2ty2C_8ftEYshOuhMOHPHBuClQVdm4yiUkCOaeSfM91vnDwC_zANX7utspt1hu4dVBgP4K8-gUmFKRa3GckDOB5xKa3wc_qa5KM7urlOghBFXHecMEyH9zQUsXhliSgWQFBo5DJvv7OMoh76-HPYXup2fw-ni5InAbaEfMyzzCC058LBqM6qH6sUpLqwEn8ZziIGCFlv8frOhYiBVtZE"/>
                    </a>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a class="font-bold tracking-tighter hover:text-primary transition-colors" href="{{ route('product.index') }}">SHOP</a>
                    <a class="font-bold tracking-tighter hover:text-primary transition-colors" href="#">CATEGORIES</a>
                    <a class="font-bold tracking-tighter hover:text-primary transition-colors" href="#">LOOKBOOK</a>
                </div>
                <div class="flex items-center space-x-5">
                    <button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors" id="theme-toggle">
                        <span class="material-icons-sharp text-2xl">contrast</span>
                    </button>
                    
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-bold tracking-tighter hover:text-primary transition-colors">DASHBOARD</a>
                    @else
                        <a href="{{ route('login') }}" class="font-bold tracking-tighter hover:text-primary transition-colors">LOGIN</a>
                    @endauth

                    <button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full relative">
                        <span class="material-icons-sharp text-2xl">shopping_bag</span>
                        <span class="absolute top-1 right-1 bg-secondary text-black text-[10px] font-bold h-4 w-4 flex items-center justify-center rounded-full">3</span>
                    </button>
                    <button class="md:hidden p-2">
                        <span class="material-icons-sharp">menu</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <section class="max-w-7xl mx-auto px-4 pb-24 mt-12">
        <div class="bg-primary p-1 md:p-2">
            <div class="bg-black text-white p-8 md:p-16 flex flex-col md:flex-row items-center justify-between space-y-8 md:space-y-0 relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="font-display text-3xl md:text-4xl font-black mb-4 tracking-tighter">JOIN THE INNER CIRCLE</h2>
                    <p class="text-slate-400 max-w-sm">Get early access to drops and exclusive content. No spam, only tactical updates.</p>
                </div>
                <div class="w-full md:w-auto flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-2 relative z-10">
                    <input class="bg-slate-900 border-slate-700 text-white px-6 py-4 w-full md:w-80 focus:ring-secondary focus:border-secondary font-mono text-sm tracking-widest placeholder:text-slate-600" placeholder="ENCRYPTED@EMAIL.COM" type="email"/>
                    <button class="bg-primary hover:bg-orange-600 text-white font-bold px-8 py-4 transition-all tracking-widest text-sm uppercase">Initialize</button>
                </div>
                <div class="absolute right-[-5%] bottom-[-20%] opacity-20 pointer-events-none">
                    <img alt="Arkari Background element" class="w-96 grayscale invert" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCg_nSYTrbszkogGIS9iINJDemA6oPw6u775V1ubP98IB9FbRfqd8JtyPDrwp63Ew0prG7AGf_TiQ7snmO7qYCX0kbUAmLpZDQLxnUqqmP5MZAQEbjtdPkKJY6EojC0GxY7kQCgFuC2vA3vjx_LZHrKxEBXOdKzarM0N67tDxUxzev2uYsByIHpZBEvl7zcLt9qtiEkzJF4Y11y3j4YFuZCGFyMZDNCUWWEv6XT0YtQXaiHBRd4B6moF_A-TTl23CqCiKditm2o2ao"/>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white dark:bg-black border-t border-slate-200 dark:border-slate-800 py-12">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center space-y-8 md:space-y-0">
            <div class="flex flex-col items-center md:items-start space-y-4">
                <img alt="Arkari Design" class="h-8 dark:invert opacity-60" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBVKOgAP_91IlMOJYcfbE5ut4wyJ5T-1gpcox__GRIRFFwEt2q45gnwXXlrzrTmsPvdEQqTF0aE-sS-mDb74HEwTocqE8Ijesz4QaHwzBtYNwHG4AdjC3MpVcmZSsJ8TXHUH0KiatSGQ0QiwVylaPmxb-4tYTx5cnP8TzYsrm_dRg0i6N9eA0rPKQF_M90TMlJJGh4TA83TvX_yKhMCp7AZfvT7sry1say-5dp_XleXvxgpwQOFu-TnbX3KrmTNvqHAO9gnGUtHzio"/>
                <p class="text-xs text-slate-500 font-mono tracking-widest uppercase">© {{ date('Y') }} ARKARI DESIGN / ALL RIGHTS RESERVED</p>
            </div>
            <div class="flex space-x-12">
                <div class="flex flex-col space-y-2">
                    <span class="font-display text-[10px] text-primary tracking-[0.3em] font-bold uppercase mb-2">Social</span>
                    <a class="text-xs hover:text-secondary transition-colors uppercase font-bold" href="#">Instagram</a>
                    <a class="text-xs hover:text-secondary transition-colors uppercase font-bold" href="#">Twitter</a>
                    <a class="text-xs hover:text-secondary transition-colors uppercase font-bold" href="#">Discord</a>
                </div>
                <div class="flex flex-col space-y-2">
                    <span class="font-display text-[10px] text-primary tracking-[0.3em] font-bold uppercase mb-2">Legal</span>
                    <a class="text-xs hover:text-secondary transition-colors uppercase font-bold" href="#">Privacy</a>
                    <a class="text-xs hover:text-secondary transition-colors uppercase font-bold" href="#">Terms</a>
                    <a class="text-xs hover:text-secondary transition-colors uppercase font-bold" href="#">Shipping</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;
        
        // Check for saved theme preference, otherwise use system preference
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        themeToggle.addEventListener('click', () => {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                html.classList.add('light');
                localStorage.theme = 'light';
            } else {
                html.classList.remove('light');
                html.classList.add('dark');
                localStorage.theme = 'dark';
            }
        });
    </script>
</body>
</html>
