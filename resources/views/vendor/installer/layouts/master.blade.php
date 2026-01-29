<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Installation') - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('installer/img/favicon/favicon-16x16.png') }}" sizes="16x16"/>
    <link rel="icon" type="image/png" href="{{ asset('installer/img/favicon/favicon-32x32.png') }}" sizes="32x32"/>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:300,400,500,600,700,800" rel="stylesheet" />
    
    <!-- Tailwind CSS via CDN for installer -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f1f9',
                            100: '#e1e3f4',
                            200: '#c3c7e9',
                            300: '#a5abde',
                            400: '#878fd3',
                            500: '#6771cf',
                            600: '#525ba8',
                            700: '#3e447e',
                            800: '#292d54',
                            900: '#15172a',
                        },
                    },
                    fontFamily: {
                        sans: ['Nunito', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <style>
        .step-item {
            @apply flex items-center justify-center w-10 h-10 rounded-full text-sm font-semibold transition-all duration-300;
        }
        .step-item.active {
            @apply bg-primary-500 text-white;
        }
        .step-item.completed {
            @apply bg-green-500 text-white;
        }
        .step-item.pending {
            @apply bg-gray-200 text-gray-500;
        }
        .step-line {
            @apply flex-1 h-1 mx-2 rounded;
        }
        .step-line.completed {
            @apply bg-green-500;
        }
        .step-line.pending {
            @apply bg-gray-200;
        }
    </style>
    @yield('styles')
</head>
<body class="font-sans antialiased bg-gradient-to-br from-primary-500 to-primary-700 min-h-screen">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-primary-500 text-white p-6 text-center">
                <h1 class="text-2xl font-bold">{{ config('app.name', 'Laravel') }}</h1>
                <p class="text-primary-100 mt-1">Installation Wizard</p>
            </div>
            
            <!-- Progress Steps -->
            <div class="px-8 py-4 bg-gray-50 border-b">
                <div class="flex items-center justify-between">
                    @php
                        $steps = [
                            ['route' => 'LaravelInstaller::welcome', 'label' => 'Welcome', 'icon' => '1'],
                            ['route' => 'LaravelInstaller::requirements', 'label' => 'Requirements', 'icon' => '2'],
                            ['route' => 'LaravelInstaller::permissions', 'label' => 'Permissions', 'icon' => '3'],
                            ['route' => 'LaravelInstaller::environment', 'label' => 'Database', 'icon' => '4'],
                            ['route' => 'LaravelInstaller::database', 'label' => 'Setup', 'icon' => '5'],
                            ['route' => 'LaravelInstaller::final', 'label' => 'Finish', 'icon' => '6'],
                        ];
                        $currentRoute = request()->route()?->getName() ?? '';
                        $currentIndex = collect($steps)->search(fn($s) => $s['route'] === $currentRoute);
                        if ($currentIndex === false) $currentIndex = 0;
                    @endphp
                    
                    @foreach($steps as $index => $step)
                        @if($index > 0)
                            <div class="step-line {{ $index <= $currentIndex ? 'completed' : 'pending' }}"></div>
                        @endif
                        <div class="flex flex-col items-center">
                            <div class="step-item {{ $index < $currentIndex ? 'completed' : ($index === $currentIndex ? 'active' : 'pending') }}">
                                @if($index < $currentIndex)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @else
                                    {{ $step['icon'] }}
                                @endif
                            </div>
                            <span class="text-xs mt-1 text-gray-500 hidden sm:block">{{ $step['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Content -->
            <div class="p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">@yield('title')</h2>
                @yield('container')
            </div>
        </div>
    </div>
    
    @yield('scripts')
</body>
</html>
