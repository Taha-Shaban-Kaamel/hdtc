<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ session('direction', 'ltr') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Vite assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- HS Select -->
    <link href="https://unpkg.com/hs-select@latest/dist/hs-select.css" rel="stylesheet">

    <!-- RTL Support -->
    @if (session('direction') === 'rtl')
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss-rtl@0.8.4/tailwind.rtl.min.css" rel="stylesheet">
    @endif

    <style>
        [x-cloak] { display: none !important; }

        html, body {
            height: 100%;
            overflow: scroll;
        }

        .min-h-screen { min-height: 100vh; }

        .h-screen-nav {
            height: calc(100vh - 4rem);
        }

        @media (min-width: 768px) {
            .md\:h-screen-nav {
                height: calc(100vh - 4rem);
            }
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100 h-full"
      :class="{ 'sidebar-expanded': sidebarExpanded }"
      x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }"
      x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">

<script>
    if (localStorage.getItem('sidebar-expanded') == 'true') {
        document.body.classList.add('sidebar-expanded');
    } else {
        document.body.classList.remove('sidebar-expanded');
    }
</script>

<div class="min-h-full flex flex-col md:flex-row">
    @include('layouts.sidebar')
    <div class="flex-1 flex flex-col overflow-hidden">
        @include('layouts.navigation')
        <main class="flex-1 bg-gray-50 p-4 md:p-6 overflow-y-auto">
            <div class="w-full max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>

<!-- Stack for extra scripts -->
@stack('scripts')

<!-- HS Select -->
<script src="https://unpkg.com/hs-select@latest/dist/hs-select.min.js" defer></script>

<!-- Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof HSSelect !== 'undefined') {
            window.HSSelect = HSSelect;
        }
    });
</script>
</body>
</html>
