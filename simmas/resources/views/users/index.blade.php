<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Manajemen User') }}</h2>
                <x-breadcrumbs :items="[
                    ['label' => 'Dashboard', 'href' => route('dashboard')],
                    ['label' => 'Pengguna']
                ]" />
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Main Content Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6">
                    <!-- Header with Search and Add Button -->
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6 gap-4">
                        <div class="flex items-center gap-2">
                            <div class="p-2 bg-cyan-50 rounded-lg">
                                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold text-gray-900">Daftar User</h3>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                            <!-- Search Box -->
                            <form action="{{ route('users.index') }}" method="GET" class="flex-1 sm:w-auto">
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        value="{{ request('search') }}"
                                        placeholder="Cari nama, email, atau role..." 
                                        class="w-full sm:w-80 pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 placeholder-gray-400"
                                    >
                                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <input type="hidden" name="role" value="{{ request('role') }}">
                                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                </div>
                            </form>

                            <!-- Role Filter -->
                            <form action="{{ route('users.index') }}" method="GET" class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                <select 
                                    name="role" 
                                    onchange="this.form.submit()"
                                    class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 bg-white"
                                >
                                    <option value="">Semua Role</option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                                    <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                </select>
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                            </form>

                            <!-- Entries Filter -->
                            <form action="{{ route('users.index') }}" method="GET" class="flex items-center gap-2">
                                <label class="text-xs text-gray-500 whitespace-nowrap">Tampilkan:</label>
                                <select 
                                    name="per_page" 
                                    onchange="this.form.submit()"
                                    class="border border-gray-200 rounded-lg px-2 py-2 text-xs focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 bg-white"
                                >
                                    <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                </select>
                                <span class="text-xs text-gray-500">entri</span>
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="role" value="{{ request('role') }}">
                            </form>

                            <!-- Add Button -->
                            <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-cyan-500 to-cyan-600 text-white text-sm font-medium rounded-lg hover:from-cyan-600 hover:to-cyan-700 shadow-sm whitespace-nowrap transition-all">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah User
                            </a>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto -mx-6 px-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="py-3.5 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                                    <th class="py-3.5 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email & Verifikasi</th>
                                    <th class="py-3.5 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                                    <th class="py-3.5 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Terdaftar</th>
                                    <th class="py-3.5 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($users as $user)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-full flex items-center justify-center shadow-sm">
                                                    <span class="text-white font-semibold text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div class="font-semibold text-sm text-gray-900">{{ $user->name }}</div>
                                                    <div class="text-xs text-gray-500 mt-0.5">ID: {{ $user->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="space-y-1">
                                                <div class="flex items-center gap-1.5 text-xs text-gray-600">
                                                    <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span class="truncate">{{ $user->email }}</span>
                                                </div>
                                                @if($user->email_verified_at)
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="text-xs text-green-600 font-medium">Verified</span>
                                                </div>
                                                @else
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="text-xs text-gray-500">Not Verified</span>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            @if($user->role === 'admin')
                                                <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-medium rounded-full bg-purple-100 text-purple-700">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"></path>
                                                    </svg>
                                                    Admin
                                                </span>
                                            @elseif($user->role === 'guru')
                                                <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                                                    </svg>
                                                    Guru
                                                </span>
                                            @else
                                                <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-medium rounded-full bg-cyan-100 text-cyan-700">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                                    </svg>
                                                    Siswa
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="text-sm text-gray-600">{{ $user->created_at->format('d M Y') }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-1">
                                                <a href="{{ route('users.edit', $user) }}" class="p-1.5 text-gray-400 hover:text-cyan-600 hover:bg-cyan-50 rounded-md transition-colors" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-colors" title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-16 px-4 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                                    </svg>
                                                </div>
                                                <h3 class="text-base font-semibold text-gray-900 mb-1">Belum ada user</h3>
                                                <p class="text-sm text-gray-500 mb-4">Mulai tambahkan pengguna untuk sistem</p>
                                                <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-cyan-500 to-cyan-600 text-white text-sm font-medium rounded-lg hover:from-cyan-600 hover:to-cyan-700 shadow-sm transition-all">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Tambah User
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if(method_exists($users, 'hasPages') && $users->hasPages())
                        <div class="mt-6 pt-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                            <div class="text-xs text-gray-500">
                                Menampilkan {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari {{ $users->total() }} entri
                            </div>
                            <div>
                                {{ $users->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>