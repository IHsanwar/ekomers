<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ShopKu') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/e16c014aae.js" crossorigin="anonymous"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-slate-50 to-slate-100">
            <!-- Logo -->
            <div class="mb-6">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-slate-900 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-store text-white"></i>
                    </div>
                    <span class="text-2xl font-bold text-slate-900">ShopKu</span>
                </a>
            </div>

            <!-- Auth Card -->
            <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-elevated rounded-xl border border-slate-200">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <p class="mt-8 text-sm text-slate-500">
                &copy; {{ date('Y') }} ShopKu. All rights reserved.
            </p>
        </div>
    </body>
</html>
