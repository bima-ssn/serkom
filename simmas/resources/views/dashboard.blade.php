<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Dashboard') }}</h2>
                <p class="text-sm text-gray-500">Tanggal: {{ $todayDateFormatted ?? now()->format('d F Y') }}</p>
            </div>
            <div class="text-sm text-gray-600">Welcome {{ Auth::user()->name }} — Role: {{ ucfirst(Auth::user()->role) }}</div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(($role ?? Auth::user()->role) === 'admin')
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <div class="flex items-center gap-4 p-4 rounded-lg border border-gray-100 bg-blue-50">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6"><path d="M7.5 6a4.5 4.5 0 1 1 9 0v.75a.75.75 0 0 0 .75.75h.75a3 3 0 0 1 3 3v.75a.75.75 0 0 1-.75.75h-2.784a6.745 6.745 0 0 0-1.391-2.613l-.018-.021a.75.75 0 0 1 .031-1.036 3.001 3.001 0 0 0 .619-3.413 3.002 3.002 0 0 0-5.599 1.3.75.75 0 0 1-1.107.599A3.004 3.004 0 0 0 6 9a3 3 0 0 0 .604 1.806.75.75 0 0 1 .031 1.036l-.018.021A6.745 6.745 0 0 0 5.226 12H2.75A.75.75 0 0 1 2 11.25V10.5a3 3 0 0 1 3-3h.75A.75.75 0 0 0 6.5 6.75V6Z"/><path d="M3.75 13.5a3 3 0 0 1 3-3h.878a5.25 5.25 0 0 0-1.19 3.375v4.125c0 .621.504 1.125 1.125 1.125h1.875V21a.75.75 0 0 0 1.31.493l1.757-2.196a.75.75 0 0 1 .584-.278h2.681c.621 0 1.125-.504 1.125-1.125V13.875A5.25 5.25 0 0 0 13.372 10.5H14.25a3 3 0 0 1 3 3v4.125c0 .621.504 1.125 1.125 1.125h.75a.75.75 0 0 0 .75-.75v-5.25a.75.75 0 0 1 .75-.75H21A3 3 0 0 1 24 13.5v6.75A3.75 3.75 0 0 1 20.25 24H3.75A3.75 3.75 0 0 1 0 20.25V13.5a3 3 0 0 1 3-3h.75a.75.75 0 0 1 .75.75v.75a3 3 0 0 0-3 3Z"/></svg>
                            </span>
                            <div>
                                <p class="text-sm text-gray-600">Total Siswa</p>
                                <p class="text-2xl font-semibold">{{ $adminStats['totalStudents'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-4 rounded-lg border border-gray-100 bg-indigo-50">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6"><path d="M3.75 4.5a.75.75 0 0 0-.75.75v13.5c0 .414.336.75.75.75H9v-4.125A2.625 2.625 0 0 1 11.625 12h.75A2.625 2.625 0 0 1 15 14.625V19.5h5.25a.75.75 0 0 0 .75-.75V5.25a.75.75 0 0 0-.75-.75H3.75Z"/></svg>
                            </span>
                            <div>
                                <p class="text-sm text-gray-600">DUDI Partner</p>
                                <p class="text-2xl font-semibold">{{ $adminStats['totalDudis'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-4 rounded-lg border border-gray-100 bg-emerald-50">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6"><path d="M6.75 3A2.25 2.25 0 0 0 4.5 5.25v13.5A2.25 2.25 0 0 0 6.75 21h10.5A2.25 2.25 0 0 0 19.5 18.75V5.25A2.25 2.25 0 0 0 17.25 3H6.75Zm1.5 3.75h7.5a.75.75 0 0 1 0 1.5h-7.5a.75.75 0 0 1 0-1.5ZM8.25 12h7.5a.75.75 0 0 1 0 1.5h-7.5a.75.75 0 0 1 0-1.5Zm0 4.5h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1 0-1.5Z"/></svg>
                            </span>
                            <div>
                                <p class="text-sm text-gray-600">Siswa Magang Aktif</p>
                                <p class="text-2xl font-semibold">{{ $adminStats['activeInternships'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-4 rounded-lg border border-gray-100 bg-amber-50">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6"><path d="M10.5 3.75a.75.75 0 0 0-1.5 0V6H7.5A2.25 2.25 0 0 0 5.25 8.25v9A2.25 2.25 0 0 0 7.5 19.5h9a2.25 2.25 0 0 0 2.25-2.25v-9A2.25 2.25 0 0 0 16.5 6h-1.5V3.75a.75.75 0 0 0-1.5 0V6h-3V3.75Z"/></svg>
                            </span>
                            <div>
                                <p class="text-sm text-gray-600">Logbook Hari Ini</p>
                                <p class="text-2xl font-semibold">{{ $adminStats['journalsToday'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="rounded-lg border border-gray-100">
                            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                <h3 class="font-semibold">Magang Terbaru</h3>
                                <a href="{{ route('internships.index') }}" class="text-sm text-indigo-600 hover:underline">Lihat semua</a>
                            </div>
                            <div class="p-4 overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead class="text-gray-500">
                                        <tr>
                                            <th class="py-2 text-left">Siswa</th>
                                            <th class="py-2 text-left">DUDI</th>
                                            <th class="py-2 text-left">Mulai</th>
                                            <th class="py-2 text-left">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse(($latestInternships ?? []) as $intern)
                                        <tr>
                                            <td class="py-2"><a href="{{ route('internships.show', $intern->id) }}" class="text-indigo-600 hover:underline">{{ $intern->student?->name ?? '' }}</a></td>
                                            <td class="py-2">{{ $intern->dudi?->name ?? '' }}</td>
                                            <td class="py-2">{{ optional($intern->start_date)->format('d M Y') ?? '' }}</td>
                                            <td class="py-2">
                                                @php
                                                    $statusLower = strtolower($intern->status ?? '');
                                                    $badgeClass = 'bg-gray-100 text-gray-700';
                                                    if (in_array($statusLower, ['active','aktif'])) $badgeClass = 'bg-emerald-100 text-emerald-700';
                                                    elseif (in_array($statusLower, ['pending'])) $badgeClass = 'bg-amber-100 text-amber-700';
                                                    elseif (in_array($statusLower, ['completed','selesai'])) $badgeClass = 'bg-blue-100 text-blue-700';
                                                    elseif (in_array($statusLower, ['ditolak','cancelled'])) $badgeClass = 'bg-red-100 text-red-700';
                                                @endphp
                                                @if(!empty($intern->status))
                                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs {{ $badgeClass }}">{{ $intern->status }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td class="py-4 text-gray-500" colspan="4">Belum ada data.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="rounded-lg border border-gray-100">
                            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                <h3 class="font-semibold">DUDI Aktif</h3>
                                <a href="{{ route('dudis.index') }}" class="text-sm text-indigo-600 hover:underline">Kelola</a>
                            </div>
                            <div class="p-4">
                                <ul class="divide-y divide-gray-100">
                                    @forelse(($activeDudisWithCounts ?? []) as $dudi)
                                    <li class="py-3 flex items-center justify-between">
                                        <a href="{{ route('dudis.show', $dudi->id) }}" class="font-medium text-gray-800 hover:text-indigo-600">{{ $dudi->name }}</a>
                                        <span class="text-sm text-gray-600">Siswa aktif: <span class="font-semibold">{{ $dudi->active_internships_count }}</span></span>
                                    </li>
                                    @empty
                                    <li class="py-4 text-gray-500">Tidak ada DUDI aktif.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(($role ?? Auth::user()->role) === 'guru')
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <div class="flex items-center gap-4 p-4 rounded-lg border border-gray-100 bg-blue-50">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6"><path d="M19.5 14.25v.75a5.25 5.25 0 0 1-5.25 5.25h-3a5.25 5.25 0 0 1-5.25-5.25v-.75A3.75 3.75 0 0 1 9.75 10.5h4.5a3.75 3.75 0 0 1 3.75 3.75Z"/><path d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/></svg>
                            </span>
                            <div>
                                <p class="text-sm text-gray-600">Total Siswa Bimbingan</p>
                                <p class="text-2xl font-semibold">{{ $mentorStats['totalMentees'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-4 rounded-lg border border-gray-100 bg-indigo-50">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6"><path d="M3.75 4.5a.75.75 0 0 0-.75.75v13.5c0 .414.336.75.75.75H9v-4.125A2.625 2.625 0 0 1 11.625 12h.75A2.625 2.625 0 0 1 15 14.625V19.5h5.25a.75.75 0 0 0 .75-.75V5.25a.75.75 0 0 0-.75-.75H3.75Z"/></svg>
                            </span>
                            <div>
                                <p class="text-sm text-gray-600">DUDI Partner Terkait</p>
                                <p class="text-2xl font-semibold">{{ $mentorStats['relatedDudiCount'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-4 rounded-lg border border-gray-100 bg-emerald-50">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6"><path d="M6.75 3A2.25 2.25 0 0 0 4.5 5.25v13.5A2.25 2.25 0 0 0 6.75 21h10.5A2.25 2.25 0 0 0 19.5 18.75V5.25A2.25 2.25 0 0 0 17.25 3H6.75Zm1.5 3.75h7.5a.75.75 0 0 1 0 1.5h-7.5a.75.75 0 0 1 0-1.5ZM8.25 12h7.5a.75.75 0 0 1 0 1.5h-7.5a.75.75 0 0 1 0-1.5Zm0 4.5h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1 0-1.5Z"/></svg>
                            </span>
                            <div>
                                <p class="text-sm text-gray-600">Magang Aktif (Bimbingan)</p>
                                <p class="text-2xl font-semibold">{{ $mentorStats['activeMentorInternships'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-4 rounded-lg border border-gray-100 bg-amber-50">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6"><path d="M10.5 3.75a.75.75 0 0 0-1.5 0V6H7.5A2.25 2.25 0 0 0 5.25 8.25v9A2.25 2.25 0 0 0 7.5 19.5h9a2.25 2.25 0 0 0 2.25-2.25v-9A2.25 2.25 0 0 0 16.5 6h-1.5V3.75a.75.75 0 0 0-1.5 0V6h-3V3.75Z"/></svg>
                            </span>
                            <div>
                                <p class="text-sm text-gray-600">Logbook Hari Ini (Bimbingan)</p>
                                <p class="text-2xl font-semibold">{{ $mentorStats['journalsTodayMentor'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="rounded-lg border border-gray-100">
                            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                <h3 class="font-semibold">Magang Terbaru (Bimbingan)</h3>
                                <a href="{{ route('internships.index') }}" class="text-sm text-indigo-600 hover:underline">Lihat semua</a>
                            </div>
                            <div class="p-4 overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead class="text-gray-500">
                                        <tr>
                                            <th class="py-2 text-left">Siswa</th>
                                            <th class="py-2 text-left">DUDI</th>
                                            <th class="py-2 text-left">Mulai</th>
                                            <th class="py-2 text-left">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse(($latestMentorInternships ?? []) as $intern)
                                        <tr>
                                            <td class="py-2"><a href="{{ route('internships.show', $intern->id) }}" class="text-indigo-600 hover:underline">{{ $intern->student?->name ?? '' }}</a></td>
                                            <td class="py-2">{{ $intern->dudi?->name ?? '' }}</td>
                                            <td class="py-2">{{ optional($intern->start_date)->format('d M Y') ?? '' }}</td>
                                            <td class="py-2">
                                                @php
                                                    $statusLower = strtolower($intern->status ?? '');
                                                    $badgeClass = 'bg-gray-100 text-gray-700';
                                                    if (in_array($statusLower, ['active','aktif'])) $badgeClass = 'bg-emerald-100 text-emerald-700';
                                                    elseif (in_array($statusLower, ['pending'])) $badgeClass = 'bg-amber-100 text-amber-700';
                                                    elseif (in_array($statusLower, ['completed','selesai'])) $badgeClass = 'bg-blue-100 text-blue-700';
                                                    elseif (in_array($statusLower, ['ditolak','cancelled'])) $badgeClass = 'bg-red-100 text-red-700';
                                                @endphp
                                                @if(!empty($intern->status))
                                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs {{ $badgeClass }}">{{ $intern->status }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td class="py-4 text-gray-500" colspan="4">Belum ada data.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="rounded-lg border border-gray-100">
                            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                <h3 class="font-semibold">DUDI Aktif (Bimbingan)</h3>
                            </div>
                            <div class="p-4">
                                <ul class="divide-y divide-gray-100">
                                    @forelse(($mentorActiveDudisWithCounts ?? []) as $dudi)
                                    <li class="py-3 flex items-center justify-between">
                                        <span class="font-medium text-gray-800">{{ $dudi->name }}</span>
                                        <span class="text-sm text-gray-600">Siswa aktif: <span class="font-semibold">{{ $dudi->active_internships_count }}</span></span>
                                    </li>
                                    @empty
                                    <li class="py-4 text-gray-500">Tidak ada DUDI aktif.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(($role ?? Auth::user()->role) === 'siswa')
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold">Selamat datang, {{ Auth::user()->name }}</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="p-4 rounded-lg border border-gray-100 bg-blue-50">
                            <p class="text-sm text-gray-600">Status Magang</p>
                            <p class="text-2xl font-semibold mt-1">{{ $studentInternship?->status ?? '' }}</p>
                            @if($studentInternship?->dudi?->name)
                            <p class="text-sm text-gray-600 mt-1">{{ $studentInternship->dudi?->name }}</p>
                            @endif
                        </div>
                        <div class="p-4 rounded-lg border border-gray-100 bg-indigo-50">
                            <p class="text-sm text-gray-600">Progress Magang</p>
                            <div class="mt-2 h-3 w-full rounded-full bg-indigo-100">
                                <div class="h-3 rounded-full bg-indigo-600" style="width: {{ (int) ($studentProgressPercent ?? 0) }}%"></div>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ (int) ($studentProgressPercent ?? 0) }}%</p>
                        </div>
                        <div class="p-4 rounded-lg border border-gray-100 bg-amber-50">
                            <p class="text-sm text-gray-600">Notifikasi Logbook</p>
                            @if(($hasJournalToday ?? false) === true)
                            <p class="mt-1 text-emerald-700">Anda sudah mengisi jurnal hari ini. Bagus!</p>
                            @else
                            <p class="mt-1 text-amber-700">Belum mengisi jurnal hari ini.</p>
                            <a href="{{ route('journals.create') }}" class="inline-block mt-2 text-sm text-amber-700 underline">Tambah Jurnal</a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
