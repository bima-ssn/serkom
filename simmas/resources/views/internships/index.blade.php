<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Manajemen Siswa Magang') }}</h2>
                <x-breadcrumbs :items="[
                    ['label' => 'Dashboard', 'href' => route('dashboard')],
                    ['label' => 'Magang']
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

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!-- Total Siswa -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Total Siswa</h3>
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ $internships->count() }}</div>
                    <p class="text-xs text-gray-500 mt-1">Siswa magang terdaftar</p>
                </div>

                <!-- Aktif -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Aktif</h3>
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ $internships->where('status', 'Aktif')->count() }}</div>
                    <p class="text-xs text-gray-500 mt-1">Sedang magang</p>
                </div>

                <!-- Selesai -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Selesai</h3>
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ $internships->where('status', 'Selesai')->count() }}</div>
                    <p class="text-xs text-gray-500 mt-1">Magang selesai</p>
                </div>

                <!-- Pending -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Pending</h3>
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ $internships->where('status', 'Pending')->count() }}</div>
                    <p class="text-xs text-gray-500 mt-1">Menunggu penempatan</p>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header with Title and Add Button -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900">Daftar Siswa Magang</h3>
                        </div>
                        @if(Auth::user()->role == 'guru')
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('internships.export') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V3" />
                                </svg>
                                Unduh PDF
                            </a>
                            <a href="{{ route('internships.create') }}" class="inline-flex items-center px-4 py-2 bg-cyan-500 text-white text-sm font-medium rounded-lg hover:bg-cyan-600 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah
                            </a>
                        </div>
                        @endif
                    </div>

                    <!-- Search and Filter -->
                    <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <form method="GET" action="{{ route('internships.index') }}" class="flex-1">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                <div class="relative flex-1">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari siswa, guru, atau DUDI..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 text-sm">
                                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                                    <option value="">Semua Status</option>
                                    @foreach(['Pending','Aktif','Selesai','Ditolak'] as $st)
                                        <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
                                    @endforeach
                                </select>
                                <select name="per_page" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                                    @foreach([5,10,25,50] as $pp)
                                        <option value="{{ $pp }}" {{ (int)request('per_page', $perPage ?? 10) === $pp ? 'selected' : '' }}>{{ $pp }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="px-4 py-2 bg-cyan-600 text-white rounded-lg text-sm">Terapkan</button>
                                <a href="{{ route('internships.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700">Reset</a>
                            </div>
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Siswa</th>
                                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Guru Pembimbing</th>
                                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">DUDI</th>
                                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Periode</th>
                                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Nilai</th>
                                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($internships as $internship)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="py-4 px-4">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                                    {{ substr($internship->student->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-900">{{ $internship->student->name }}</div>
                                                    <div class="text-sm text-gray-500">NIS/NIP: {{ $internship->student->nis_nip ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="font-medium text-gray-900">{{ $internship->teacher->name }}</div>
                                            <div class="text-sm text-gray-500">NIP: {{ $internship->teacher->nis_nip ?? 'N/A' }}</div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-gray-200 rounded flex items-center justify-center mr-2">
                                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $internship->dudi->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $internship->dudi->location ?? 'Surabaya' }}</div>
                                                    <div class="text-xs text-gray-400">{{ $internship->dudi->supervisor ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="text-sm text-gray-900">{{ optional($internship->start_date)->format('d M Y') ?? '-' }}</div>
                                            <div class="text-sm text-gray-500">s/d {{ optional($internship->end_date)->format('d M Y') ?? '-' }}</div>
                                            <div class="text-xs text-gray-400">
                                                @if($internship->start_date && $internship->end_date)
                                                    {{ $internship->start_date->diffInDays($internship->end_date) }} hari
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            @if($internship->status == 'Pending')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($internship->status == 'Aktif')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                            @elseif($internship->status == 'Selesai')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Selesai</span>
                                            @elseif($internship->status == 'Ditolak')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4">
                                            @if(!is_null($internship->final_score))
                                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-lime-500 text-white font-bold">
                                                    {{ number_format($internship->final_score, 2) }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-sm">-</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('internships.show', $internship->id) }}" class="text-gray-600 hover:text-gray-900" title="Detail">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                                @if(Auth::user()->role == 'guru')
                                                <a href="{{ route('internships.edit', $internship->id) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('internships.destroy', $internship->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-8 px-4 text-center">
                                            @if(Auth::user()->role == 'guru')
                                            <x-empty-state title="Belum ada data magang" actionHref="{{ route('internships.create') }}" actionLabel="Tambah Magang" />
                                            @else
                                            <x-empty-state title="Belum ada data magang" />
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if(method_exists($internships, 'hasPages') && $internships->hasPages())
                    <div class="mt-4 flex items-center justify-between border-t border-gray-200 pt-4">
                        <div class="text-sm text-gray-600">
                            Menampilkan {{ $internships->firstItem() }} sampai {{ $internships->lastItem() }} dari {{ $internships->total() }} entri
                        </div>
                        <div>
                            {{ $internships->appends(request()->query())->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>