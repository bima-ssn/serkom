<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Jurnal Harian') }}</h2>
            </div>
            <div class="flex items-center gap-2">
                @if(auth()->user()->role === 'siswa')
                <a href="{{ route('journals.create') }}" class="inline-flex items-center px-4 py-2 bg-cyan-600 text-white text-sm font-medium rounded-lg hover:bg-cyan-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Jurnal
                </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Peringatan Jurnal Hari Ini -->
            @if(auth()->user()->role === 'siswa' && ($showReminder ?? false))
            <div class="mb-6 bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-xl p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-yellow-800">Jangan Lupa Jurnal Hari ini!</h3>
                        <p class="text-sm text-yellow-700 mt-1">Anda belum membuat jurnal untuk hari ini. Dokumentasikan kegiatan magang Anda sekarang.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Statistik Dashboard -->
            @if(in_array(auth()->user()->role, ['guru','siswa']))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Jurnal</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalCount ?? 0 }}</p>
                            <p class="mt-1 text-xs text-gray-500">Jurnal yang telah dibuat</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-xl">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Disetujui</p>
                            <p class="mt-2 text-3xl font-bold text-green-600">{{ $approvedCount ?? 0 }}</p>
                            <p class="mt-1 text-xs text-gray-500">Jurnal disetujui guru</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-xl">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Menunggu</p>
                            <p class="mt-2 text-3xl font-bold text-amber-600">{{ $pendingCount ?? 0 }}</p>
                            <p class="mt-1 text-xs text-gray-500">Belum diverifikasi</p>
                        </div>
                        <div class="p-3 bg-amber-50 rounded-xl">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Ditolak</p>
                            <p class="mt-2 text-3xl font-bold text-red-600">{{ $rejectedCount ?? 0 }}</p>
                            <p class="mt-1 text-xs text-gray-500">Perlu diperbaiki</p>
                        </div>
                        <div class="p-3 bg-red-50 rounded-xl">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                        </div>
                    @endif

            <!-- Tabel Riwayat Jurnal -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Header Tabel -->
                <div class="px-6 py-5 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Riwayat Jurnal</h3>
                            <p class="mt-1 text-sm text-gray-500">Kelola dan pantau jurnal harian magang</p>
                        </div>
                        <div class="flex items-center gap-2">
                            @if(auth()->user()->role === 'siswa')
                            <a href="{{ route('journals.create') }}" class="inline-flex items-center px-4 py-2 bg-cyan-600 text-white text-sm font-medium rounded-lg hover:bg-cyan-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Jurnal
                            </a>
                            @endif
                            <button class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                                </svg>
                                Sembunyikan Filter
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="px-6 py-5 bg-gray-50 border-b border-gray-200">
                    <form method="GET" action="{{ route('journals.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">
                            <!-- Search Input -->
                            <div class="lg:col-span-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cari kegiatan atau kendala</label>
                                <div class="relative">
                                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" 
                                           placeholder="Cari kegiatan atau kendala..." 
                                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors">
                                    <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Status Filter -->
                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 py-2.5 transition-colors">
                                    <option value="">Semua Status</option>
                                    <option value="Menunggu Verifikasi" {{ ($filters['status'] ?? '') === 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                    <option value="Disetujui" {{ ($filters['status'] ?? '') === 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="Ditolak" {{ ($filters['status'] ?? '') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            <!-- Month Filter -->
                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                                <select name="month" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 py-2.5 transition-colors">
                                    <option value="">Semua Bulan</option>
                                    @for($m=1;$m<=12;$m++)
                                        <option value="{{ $m }}" {{ (int)($filters['month'] ?? 0) === $m ? 'selected' : '' }}>
                                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Year Filter -->
                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                                <select name="year" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 py-2.5 transition-colors">
                                    <option value="">Semua Tahun</option>
                                    @for($y=date('Y')-3;$y<=date('Y')+1;$y++)
                                        <option value="{{ $y }}" {{ (int)($filters['year'] ?? 0) === $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="lg:col-span-2 flex items-end space-x-3">
                                <button type="button" class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 font-medium transition-colors">
                                    Reset Filter
                                </button>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tampilkan</label>
                                    <select name="per_page" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 py-2.5 transition-colors">
                                        @foreach([5,10,25,50] as $pp)
                                            <option value="{{ $pp }}" {{ ($perPage ?? 10) == $pp ? 'selected' : '' }}>{{ $pp }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tabel Content -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                            <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                                @if(auth()->user()->role === 'guru')
                                <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Siswa</th>
                                <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">DUDI</th>
                                @endif
                                <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Kegiatan & Kendala</th>
                                <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Feedback Guru</th>
                                <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($journals as $journal)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="text-sm font-medium text-gray-900 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($journal->date)->translatedFormat('D, j M Y') }}
                                        </div>
                                    </td>
                                    @if(auth()->user()->role === 'guru')
                                    <td class="py-4 px-6">
                                        <div class="text-sm text-gray-900">{{ $journal->internship->student->name }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="text-sm text-gray-600">{{ $journal->internship->dudi->name }}</div>
                                    </td>
                                    @endif
                                    <td class="py-4 px-6">
                                        <div class="max-w-md">
                                            <div class="text-sm font-medium text-gray-900 mb-1">Kegiatan:</div>
                                            <div class="text-sm text-gray-600 line-clamp-2">{{ $journal->description }}</div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($journal->status === 'Menunggu Verifikasi')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                                Menunggu
                                            </span>
                                        @elseif($journal->status === 'Disetujui')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                Disetujui
                                            </span>
                                        @elseif($journal->status === 'Ditolak')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                                Perlu Diperbaiki
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($journal->teacher_notes)
                                            <div class="text-sm text-gray-700 max-w-xs">
                                                <div class="font-medium text-gray-900 mb-1">Catatan Guru:</div>
                                                {{ Str::limit($journal->teacher_notes, 100) }}
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-400 italic">Belum ada feedback</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('journals.show', $journal->id) }}" 
                                               class="p-2 text-gray-400 hover:text-cyan-600 hover:bg-cyan-50 rounded-lg transition-colors"
                                               title="Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            
                                            @if(auth()->user()->role === 'guru' && $journal->status === 'Menunggu Verifikasi')
                                            <form method="POST" action="{{ route('journals.verify', $journal->id) }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="status" value="Disetujui">
                                                <button type="submit" 
                                                        class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                                        title="Setujui">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('journals.verify', $journal->id) }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="status" value="Ditolak">
                                                <button type="submit" 
                                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                        title="Tolak">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            @endif

                                            @if(auth()->user()->role === 'siswa')
                                            <a href="{{ route('journals.edit', $journal->id) }}" 
                                               class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                               title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('journals.destroy', $journal->id) }}" method="POST" onsubmit="return confirm('Hapus jurnal ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                        title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                    <td colspan="{{ auth()->user()->role === 'guru' ? 7 : 5 }}" class="py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <p class="text-lg font-medium text-gray-500">Tidak ada data jurnal</p>
                                            <p class="text-sm text-gray-400 mt-1">Mulai dengan membuat jurnal harian pertama Anda</p>
                                        </div>
                                    </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                <!-- Footer Tabel -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-sm text-gray-600 mb-3 sm:mb-0">
                            Menampilkan <span class="font-medium">{{ $journals->firstItem() ?? 0 }}</span> sampai <span class="font-medium">{{ $journals->lastItem() ?? 0 }}</span> dari <span class="font-medium">{{ $journals->total() }}</span> entri
                        </div>
                        <div class="flex items-center space-x-2">
                        {{ $journals->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-app-layout>