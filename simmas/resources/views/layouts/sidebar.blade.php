<aside class="hidden sm:flex sm:flex-col w-64 bg-white border-r border-gray-200">
    <div class="h-16 flex items-center px-4 border-b border-gray-100">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <x-application-logo class="block h-8 w-auto fill-current text-gray-800" />
            <span class="text-lg font-semibold text-gray-800">{{ config('app.name', 'Laravel') }}</span>
        </a>
    </div>
    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="px-2 space-y-1">
            <li>
                <a href="{{ route('dashboard') }}" class="group flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span>Dashboard</span>
                </a>
            </li>
            @if(Auth::user()->role == 'admin')
            <li>
                <a href="{{ route('users.index') }}" class="group flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('users.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span>Manajemen Pengguna</span>
                </a>
            </li>
            <li>
                <a href="{{ route('school-settings.index') }}" class="group flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('school-settings.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span>Pengaturan Sekolah</span>
                </a>
            </li>
            @endif
            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'guru')
            <li>
                <a href="{{ route('dudis.index') }}" class="group flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dudis.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span>Manajemen DUDI</span>
                </a>
            </li>
            <li>
                <a href="{{ route('internships.index') }}" class="group flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('internships.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span>Manajemen Magang</span>
                </a>
            </li>
            @endif
            @if(Auth::user()->role == 'siswa')
            <li>
                <a href="{{ route('journals.index') }}" class="group flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('journals.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span>Jurnal Harian</span>
                </a>
            </li>
            @endif
        </ul>
    </nav>
    <div class="border-t border-gray-100 p-3">
        <div class="px-2 py-2 rounded-md bg-gray-50">
            <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
            <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 bg-red-500 text-white text-sm font-medium rounded-md hover:bg-red-600">Log Out</button>
        </form>
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
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <x-application-logo class="block h-8 w-auto fill-current text-gray-800" />
            <span class="text-base font-semibold text-gray-800">{{ config('app.name', 'Laravel') }}</span>
        </a>
        <div></div>
    </div>
    <div x-show="open" x-transition class="fixed inset-0 z-40 flex">
        <div @click="open = false" class="fixed inset-0 bg-black/30"></div>
        <aside class="relative z-50 w-64 bg-white h-full shadow-xl">
            <div class="h-16 flex items-center px-4 border-b border-gray-100">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <x-application-logo class="block h-8 w-auto fill-current text-gray-800" />
                    <span class="text-lg font-semibold text-gray-800">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <button @click="open = false" class="ml-auto p-2 rounded-md text-gray-500 hover:bg-gray-100">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                </button>
            </div>
            <nav class="flex-1 overflow-y-auto py-4">
                <ul class="px-2 space-y-1">
                    <li>
                        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">Dashboard</a>
                    </li>
                    @if(Auth::user()->role == 'admin')
                    <li>
                        <a href="{{ route('users.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('users.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">Manajemen Pengguna</a>
                    </li>
                    <li>
                        <a href="{{ route('school-settings.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('school-settings.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">Pengaturan Sekolah</a>
                    </li>
                    @endif
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'guru')
                    <li>
                        <a href="{{ route('dudis.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dudis.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">Manajemen DUDI</a>
                    </li>
                    <li>
                        <a href="{{ route('internships.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('internships.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">Manajemen Magang</a>
                    </li>
                    @endif
                    @if(Auth::user()->role == 'siswa')
                    <li>
                        <a href="{{ route('journals.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('journals.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">Jurnal Harian</a>
                    </li>
                    @endif
                </ul>
            </nav>
            <div class="border-t border-gray-100 p-3">
                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 bg-red-500 text-white text-sm font-medium rounded-md hover:bg-red-600">Log Out</button>
                </form>
            </div>
        </aside>
    </div>
</div>
