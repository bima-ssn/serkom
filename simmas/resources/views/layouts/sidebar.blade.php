<aside class="hidden sm:flex sm:flex-col w-64 bg-white shadow-lg">
    <!-- SIMMAS Header -->
    <div class="px-6 py-8">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">SIMMAS</h1>
                <p class="text-sm text-gray-600">Panel Admin</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="flex-1 px-4">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-500' }}" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                    <div class="flex-1">
                        <div class="font-semibold">Dashboard</div>
                        <div class="text-xs {{ request()->routeIs('dashboard') ? 'text-teal-100' : 'text-gray-500' }}">Ringkasan sistem</div>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('dudis.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('dudis.*') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="h-5 w-5 {{ request()->routeIs('dudis.*') ? 'text-white' : 'text-gray-500' }}" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 6a2 2 0 012-2h3l1-2h4l1 2h3a2 2 0 012 2v3H2V6z"/>
                        <path d="M2 10h16v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                    </svg>
                    <div class="flex-1">
                        <div class="font-semibold">DUDI</div>
                        <div class="text-xs {{ request()->routeIs('dudis.*') ? 'text-teal-100' : 'text-gray-500' }}">Manajemen DUDI</div>
                    </div>
                </a>
            </li>
            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'guru')
            <li>
                <a href="{{ route('internships.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('internships.*') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="h-5 w-5 {{ request()->routeIs('internships.*') ? 'text-white' : 'text-gray-500' }}" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                    <div class="flex-1">
                        <div class="font-semibold">Magang</div>
                        <div class="text-xs {{ request()->routeIs('internships.*') ? 'text-teal-100' : 'text-gray-500' }}">Manajemen Magang</div>
                    </div>
                </a>
            </li>
            @endif
            @if(Auth::user()->role == 'admin')
            <li>
                <a href="{{ route('users.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('users.*') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="h-5 w-5 {{ request()->routeIs('users.*') ? 'text-white' : 'text-gray-500' }}" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                    </svg>
                    <div class="flex-1">
                        <div class="font-semibold">Pengguna</div>
                        <div class="text-xs {{ request()->routeIs('users.*') ? 'text-teal-100' : 'text-gray-500' }}">Manajemen user</div>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('school-settings.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('school-settings.*') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="h-5 w-5 {{ request()->routeIs('school-settings.*') ? 'text-white' : 'text-gray-500' }}" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <div class="font-semibold">Pengaturan</div>
                        <div class="text-xs {{ request()->routeIs('school-settings.*') ? 'text-teal-100' : 'text-gray-500' }}">Konfigurasi sistem</div>
                    </div>
                </a>
            </li>
            @endif
            @if(Auth::user()->role == 'siswa')
            <li>
                <a href="{{ route('journals.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('journals.*') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="h-5 w-5 {{ request()->routeIs('journals.*') ? 'text-white' : 'text-gray-500' }}" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <div class="font-semibold">Jurnal Harian</div>
                        <div class="text-xs {{ request()->routeIs('journals.*') ? 'text-teal-100' : 'text-gray-500' }}">Laporan harian</div>
                    </div>
                </a>
            </li>
            @endif
        </ul>
    </nav>
    
    <!-- Bottom Section -->
    <div class="px-6 py-4">
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <span class="text-sm font-medium text-gray-900">SMK Negeri 1 Surabaya</span>
            </div>
            <p class="text-xs text-gray-500">Sistem Pelaporan v1.0</p>
        </div>
    </div>
</aside>

<!-- Mobile top bar + drawer -->
<div x-data="{ open: false }" class="sm:hidden">
    <div class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-4">
        <button @click="open = true" class="p-2 rounded-md text-gray-500 hover:bg-gray-100">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-900">SMK Negeri 1 Surabaya</h1>
                <p class="text-xs text-gray-600">Sistem Manajemen Magang Siswa</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 bg-teal-600 rounded flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>
    </div>
    <div x-show="open" x-transition class="fixed inset-0 z-40 flex">
        <div @click="open = false" class="fixed inset-0 bg-black/30"></div>
        <aside class="relative z-50 w-64 bg-white h-full shadow-xl">
            <div class="px-6 py-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">SIMMAS</h1>
                        <p class="text-sm text-gray-600">Panel Admin</p>
                    </div>
                </div>
            </div>
            <nav class="flex-1 overflow-y-auto py-4 px-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-500' }}" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                            <div class="flex-1">
                                <div class="font-semibold">Dashboard</div>
                                <div class="text-xs {{ request()->routeIs('dashboard') ? 'text-teal-100' : 'text-gray-500' }}">Ringkasan sistem</div>
                            </div>
                        </a>
                    </li>
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'guru')
                    <li>
                        <a href="{{ route('dudis.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('dudis.*') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('dudis.*') ? 'text-white' : 'text-gray-500' }}" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 6a2 2 0 012-2h3l1-2h4l1 2h3a2 2 0 012 2v3H2V6z"/>
                                <path d="M2 10h16v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                            </svg>
                            <span>DUDI</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('internships.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('internships.*') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('internships.*') ? 'text-white' : 'text-gray-500' }}" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                            <span>Magang</span>
                        </a>
                    </li>
                    @endif
                    @if(Auth::user()->role == 'admin')
                    <li>
                        <a href="{{ route('users.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('users.*') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('users.*') ? 'text-white' : 'text-gray-500' }}" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                            </svg>
                            <span>Pengguna</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('school-settings.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('school-settings.*') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('school-settings.*') ? 'text-white' : 'text-gray-500' }}" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                            </svg>
                            <span>Pengaturan</span>
                        </a>
                    </li>
                    @endif
                    @if(Auth::user()->role == 'siswa')
                    <li>
                        <a href="{{ route('journals.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('journals.*') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('journals.*') ? 'text-white' : 'text-gray-500' }}" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                            </svg>
                            <span>Jurnal Harian</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
            <div class="px-6 py-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span class="text-sm font-medium text-gray-900">SMK Negeri 1 Surabaya</span>
                    </div>
                    <p class="text-xs text-gray-500">Sistem Pelaporan v1.0</p>
                </div>
            </div>
        </aside>
    </div>
</div>
