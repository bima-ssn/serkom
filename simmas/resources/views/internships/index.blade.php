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
                    <div class="text-3xl font-bold text-gray-900">{{ $internships->where('status', 'active')->count() }}</div>
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
                    <div class="text-3xl font-bold text-gray-900">{{ $internships->where('status', 'completed')->count() }}</div>
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
                    <div class="text-3xl font-bold text-gray-900">{{ $internships->where('status', 'pending')->count() }}</div>
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
                        <a href="{{ route('internships.create') }}" class="inline-flex items-center px-4 py-2 bg-cyan-500 text-white text-sm font-medium rounded-lg hover:bg-cyan-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah
                        </a>
                        @endif
                    </div>

                    <!-- Search and Filter -->
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <button class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Tampilkan Filter
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Tampilkan:</span>
                            <select class="border border-gray-300 rounded-md text-sm px-3 py-2">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                            </select>
                            <span class="text-sm text-gray-600">per halaman</span>
                        </div>
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
                                                    <div class="text-sm text-gray-500">NIS: {{ $internship->student->nis ?? 'N/A' }}</div>
                                                    <div class="text-xs text-gray-400">{{ $internship->student->class ?? 'N/A' }}</div>
                                                    <div class="text-xs text-gray-400">{{ $internship->student->major ?? 'Rekayasa Perangkat Lunak' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="font-medium text-gray-900">{{ $internship->teacher->name }}</div>
                                            <div class="text-sm text-gray-500">NIP: {{ $internship->teacher->nip ?? 'N/A' }}</div>
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
                                            <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($internship->start_date)->format('d M Y') }}</div>
                                            <div class="text-sm text-gray-500">s/d {{ \Carbon\Carbon::parse($internship->end_date)->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-400">
                                                {{ \Carbon\Carbon::parse($internship->start_date)->diffInDays(\Carbon\Carbon::parse($internship->end_date)) }} hari
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            @if($internship->status == 'pending')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($internship->status == 'active')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                            @elseif($internship->status == 'completed')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Selesai</span>
                                            @elseif($internship->status == 'cancelled')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4">
                                            @if($internship->grade)
                                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-lime-500 text-white font-bold">
                                                    {{ $internship->grade }}
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
                    @if($internships->count() > 0)
                    <div class="mt-4 flex items-center justify-between border-t border-gray-200 pt-4">
                        <div class="text-sm text-gray-600">
                            Menampilkan 1 sampai {{ $internships->count() }} dari {{ $internships->count() }} entri
                        </div>
                        <div class="flex space-x-1">
                            <button class="px-3 py-2 text-sm border border-gray-300 rounded-md bg-cyan-500 text-white">1</button>
                            <button class="px-3 py-2 text-sm border border-gray-300 rounded-md hover:bg-gray-50">2</button>
                            <button class="px-3 py-2 text-sm border border-gray-300 rounded-md hover:bg-gray-50">›</button>
                            <button class="px-3 py-2 text-sm border border-gray-300 rounded-md hover:bg-gray-50">»</button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>