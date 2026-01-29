<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ \App\Models\Setting::get('app_name', config('app.name', 'Laraku')) }}</title>

        <!-- Favicon -->
        @php
            $favicon = \App\Models\Setting::get('favicon');
            $faviconUrl = $favicon ? (str_starts_with($favicon, '/') || str_starts_with($favicon, 'http') ? $favicon : '/storage/' . $favicon) : null;
        @endphp
        @if($faviconUrl)
            <link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon">
        @else
            <link rel="icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/png">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=nunito:300,400,500,600,700,800" rel="stylesheet" />

        <!-- Dynamic Theme CSS Variables -->
        <x-theme-styles />

        <!-- Theme initialization script - runs before page renders to prevent flash -->
        <script>
            (function() {
                const savedTheme = localStorage.getItem('theme');
                if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
