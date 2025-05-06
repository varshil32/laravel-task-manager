<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    <style>
        /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
        /* Tailwind styles here */
    </style>
    @endif
</head>

<body class="bg-[#000000] dark:bg-[#000000] text-[#1b1b18] min-h-screen flex items-center justify-center">
    <div class="container mx-auto">
        <div class="flex flex-col items-center">
            <div class="text-center mb-8">
                <h1 class="px-5 dark:text-[#EDEDEC] text-[#1b1b18] rounded-sm text-3xl leading-normal">WELCOME TO</h1>
                <h1 class="px-5 dark:text-[#EDEDEC] text-[#1b1b18] rounded-sm text-5xl leading-normal">TASK MANAGER</h1>
            </div>

            <!-- Navigation -->
            <div class="w-full max-w-md">
                <header class="text-sm mb-6 not-has-[nav]:hidden">
                    @if (Route::has('login'))
                    <nav class="flex items-center justify-center gap-4">
                        @auth
                        <a href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Dashboard
                        </a>
                        @else
                        <a href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                            Log in
                        </a>

                        @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Register
                        </a>
                        @endif
                        @endauth
                    </nav>
                    @endif
                </header>
            </div>
        </div>
    </div>

    @if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>

</html>