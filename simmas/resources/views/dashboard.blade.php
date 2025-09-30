<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">SMK Negeri 1 Surabaya</h1>
                <p class="text-sm text-gray-500">Sistem Manajemen Magang Siswa</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium">
                    {{ Str::of(Auth::user()->name ?? 'A')->substr(0,1)->upper() }}
                </div>
                <div class="text-right">
                    <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'Admin Sistem' }}</div>
                    <div class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role ?? 'Admin') }}</div>
                </div>
            </div>
        </div>
    </x-slot>

    @php
        $totalSiswa = \App\Models\User::where('role', 'siswa')->count();
        $dudiPartner = \App\Models\Dudi::count();
        $siswaMagang = \App\Models\Internship::where('status', 'active')->count();
        $logbookHariIni = \App\Models\Journal::whereDate('date', \Carbon\Carbon::today())->count();

        $magangTerbaru = \App\Models\Internship::with(['student','dudi'])
            ->orderByDesc('created_at')->take(5)->get();
        $dudiAktif = \App\Models\Dudi::where('status', 'Aktif')->orderBy('name')->take(6)->get();
        $logbookTerbaru = \App\Models\Journal::with(['internship.student'])
            ->orderByDesc('date')->take(6)->get();
    @endphp

    <div class="py-8 sm:py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
                <p class="text-sm text-gray-500">Selamat datang di sistem pelaporan magang siswa SMK Negeri 1 Surabaya</p>
            </div>

            <!-- Statistik Cepat -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="relative bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <div class="text-sm text-gray-500">Total Siswa</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $totalSiswa }}</div>
                    <div class="absolute top-3 right-3 text-cyan-500">
                        <svg class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor"><path d="M13 7a3 3 0 11-6 0 3 3 0 016 0z"/><path fill-rule="evenodd" d="M3 14s1-1 5-1 5 1 5 1-1 4-5 4-5-4-5-4z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
                <div class="relative bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <div class="text-sm text-gray-500">DUDI Partner</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $dudiPartner }}</div>
                    <div class="absolute top-3 right-3 text-cyan-500">
                        <svg class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor"><path d="M2 6a2 2 0 012-2h3l1-2h4l1 2h3a2 2 0 012 2v3H2V6z"/><path d="M2 10h16v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/></svg>
                    </div>
                </div>
                <div class="relative bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <div class="text-sm text-gray-500">Siswa Magang</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $siswaMagang }}</div>
                    <div class="absolute top-3 right-3 text-cyan-500">
                        <svg class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2a2 2 0 00-2 2v3H6a2 2 0 00-2 2v2h12V9a2 2 0 00-2-2h-2V4a2 2 0 00-2-2z"/><path d="M4 13h12v3a2 2 0 01-2 2H6a2 2 0 01-2-2v-3z"/></svg>
                    </div>
                </div>
                <div class="relative bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <div class="text-sm text-gray-500">Logbook Hari Ini</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $logbookHariIni }}</div>
                    <div class="absolute top-3 right-3 text-cyan-500">
                        <svg class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor"><path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v9a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1z"/><path d="M6 9h8v2H6V9z"/></svg>
                    </div>
                </div>
            </div>

            <!-- Konten Utama: Magang Terbaru, DUDI Aktif, Logbook Terbaru -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Magang Terbaru (Card biru) -->
                <div class="lg:col-span-1 rounded-xl border border-cyan-100 bg-cyan-50 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-cyan-100 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-cyan-900">Magang Terbaru</h3>
                        <svg class="h-5 w-5 text-cyan-500" viewBox="0 0 20 20" fill="currentColor"><path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v2H2V5z"/><path d="M2 9h16v6a2 2 0 01-2 2H4a2 2 0 01-2-2V9z"/></svg>
                    </div>
                    <ul class="divide-y divide-cyan-100">
                        @forelse($magangTerbaru as $intern)
                            <li class="px-5 py-3 flex items-start justify-between">
                                <div>
                                    <div class="text-sm font-medium text-cyan-900">{{ $intern->student->name ?? '-' }} – {{ $intern->dudi->name ?? '-' }}</div>
                                    <div class="text-xs text-cyan-700">{{ \Carbon\Carbon::parse($intern->start_date)->format('d/m/Y') }}</div>
                                </div>
                                <div>
                                    @php $s = $intern->status; @endphp
                                    @if($s === 'active')
                                        <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700">Aktif</span>
                                    @elseif($s === 'pending')
                                        <span class="px-2 py-0.5 text-xs rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                    @elseif($s === 'completed')
                                        <span class="px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-700">Selesai</span>
                                    @else
                                        <span class="px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-700">Dibatalkan</span>
                                    @endif
                                </div>
                            </li>
                        @empty
                            <li class="px-5 py-6 text-center text-sm text-cyan-800">Belum ada data magang</li>
                        @endforelse
                    </ul>
                </div>

                <!-- DUDI Aktif -->
                <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-900">DUDI Aktif</h3>
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/></svg>
                    </div>
                    <ul class="divide-y divide-gray-100">
                        @forelse($dudiAktif as $dudi)
                            <li class="px-5 py-3">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $dudi->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $dudi->address }} • {{ $dudi->phone }}</div>
                                    </div>
                                    <div>
                                        @php $jumlah = $dudi->internships()->where('status','active')->count(); @endphp
                                        <span class="px-2 py-0.5 text-xs rounded-full {{ $jumlah > 10 ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $jumlah }} siswa</span>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="px-5 py-6 text-center text-sm text-gray-500">Belum ada perusahaan mitra</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Logbook Terbaru -->
                <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-900">Logbook Terbaru</h3>
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path d="M4 3a2 2 0 00-2 2v11a1 1 0 001.447.894L6 15.618l2.553 1.276A1 1 0 0010 16V5a2 2 0 00-2-2H4z"/><path d="M14 3h2a2 2 0 012 2v11a1 1 0 01-1.447.894L14 15.618l-2.553 1.276A1 1 0 0110 16V5a2 2 0 012-2h2z"/></svg>
                    </div>
                    <ul class="divide-y divide-gray-100">
                        @forelse($logbookTerbaru as $log)
                            <li class="px-5 py-3">
                                <div class="flex items-start justify-between">
                                    <div class="pr-4">
                                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($log->activity ?? 'Logbook', 60) }}</div>
                                        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($log->date)->format('d/m/Y') }} • {{ $log->internship->student->name ?? '-' }}</div>
                                        @if(!empty($log->note))
                                            <div class="text-xs mt-1 text-red-600">{{ Str::limit($log->note, 80) }}</div>
                                        @endif
                                    </div>
                                    <div class="shrink-0">
                                        @php $st = $log->status; @endphp
                                        @if($st === 'approved')
                                            <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700">Disetujui</span>
                                        @elseif($st === 'pending')
                                            <span class="px-2 py-0.5 text-xs rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                        @elseif($st === 'rejected')
                                            <span class="px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-700">Ditolak</span>
                                        @else
                                            <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-700">-</span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="px-5 py-6 text-center text-sm text-gray-500">Belum ada logbook</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
