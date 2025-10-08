<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $schoolSetting->name ?? config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50">
            <div class="flex min-h-screen">
                @include('layouts.sidebar')
                <div class="flex-1 flex flex-col">
                    <!-- Top Bar -->
                    <header class="bg-white shadow-sm border-b border-gray-200">
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    @if(($schoolSetting->logo ?? null))
                                        <img src="{{ Storage::disk('public')->url($schoolSetting->logo) . '?v=' . optional($schoolSetting->updated_at)->timestamp }}" alt="Logo" class="h-10 w-10 object-contain rounded-md border border-gray-200 p-1">
                                    @endif
                                    <div>
                                        <h1 class="text-2xl font-bold text-gray-900">{{ $schoolSetting->name ?? 'Sekolah' }}</h1>
                                        <p class="text-sm text-gray-600">Sistem Manajemen Magang Siswa</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-600">{{ ucfirst(Auth::user()->role) }}</p>
                                    </div>
                                    
                                    <!-- User Profile Dropdown -->
                                    <div class="relative" x-data="{ open: false }">
                                        <button 
                                            @click="open = !open"
                                            @click.away="open = false"
                                            class="w-10 h-10 bg-teal-600 rounded-lg flex items-center justify-center hover:bg-teal-700 transition-colors focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                                        >
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>

                                        <!-- Dropdown Menu -->
                                        <div 
                                            x-show="open"
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50"
                                            style="display: none;"
                                        >
                                            <!-- User Info -->
                                            <div class="px-4 py-3 border-b border-gray-100">
                                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                                <p class="text-xs text-gray-500 mt-0.5">{{ Auth::user()->email }}</p>
                                            </div>

                                            <!-- Menu Items -->
                                            <div class="py-1">
                                                @if(Route::has('profile.edit'))
                                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                    Profil Saya
                                                </a>
                                                @endif
                                                
                                                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                                    </svg>
                                                    Dashboard
                                                </a>
                                            </div>

                                            <!-- Logout -->
                                            <div class="border-t border-gray-100 py-1">
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                                        </svg>
                                                        Keluar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>

                    <!-- Page Content -->
                    <main class="flex-1 bg-gray-50 p-6">
                        @isset($slot)
                            {{ $slot }}
                        @else
                            @yield('content')
                        @endisset
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>