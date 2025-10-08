<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail DUDI') }}
            </h2>
            <div>
                @if(Auth::user()->role == 'admin')
                <a href="{{ route('dudis.edit', $dudi) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Edit
                </a>
                @endif
                <a href="{{ route('dudis.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @php
                        $existing = $dudi->internships
                            ->where('student_id', Auth::id())
                            ->sortByDesc('created_at')
                            ->first();
                        $hasApplied = $existing && in_array($existing->status, ['Pending','Aktif','proses','process']);
                        $isPending = $existing && $existing->status === 'Pending';
                        $quota = $dudi->student_quota ?? 0;
                        $current = $dudi->internships->whereIn('status', ['Aktif','active'])->count();
                        $slotsLeft = max($quota - $current, 0);
                    @endphp

                    <!-- Header section -->
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-lg bg-cyan-500 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">{{ $dudi->name }}</div>
                                <div class="text-sm text-cyan-700">{{ $dudi->field ?? 'Teknologi informasi' }}</div>
                            </div>
                        </div>
                        @if($isPending)
                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu Verifikasi</span>
                        @endif
                    </div>

                    <!-- About Company -->
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-700 mb-2">Tentang Perusahaan</h3>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-700">
                            {{ $dudi->description ?? 'Perusahaan teknologi yang bergerak dalam pengembangan aplikasi web dan mobile. Memberikan kesempatan magang untuk siswa SMK.' }}
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Informasi Kontak</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-6">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 text-sm text-gray-700 flex items-start gap-2">
                            <svg class="w-4 h-4 text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ $dudi->address }}</span>
                        </div>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 text-sm text-gray-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ $dudi->phone }}</span>
                        </div>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 text-sm text-gray-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ $dudi->email }}</span>
                        </div>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 text-sm text-gray-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>{{ $dudi->pic_name }}</span>
                        </div>
                    </div>

                    <!-- Internship Info -->
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Informasi Magang</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-6">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 text-sm text-gray-700">
                            <div class="text-gray-500 text-xs mb-1">Bidang Usaha</div>
                            <div class="font-medium">{{ $dudi->field ?? 'Teknologi Informasi' }}</div>
                        </div>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 text-sm text-gray-700">
                            <div class="text-gray-500 text-xs mb-1">Kuota Magang</div>
                            <div class="font-medium">{{ $current }}/{{ $quota }}</div>
                        </div>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 text-sm text-gray-700">
                            <div class="text-gray-500 text-xs mb-1">Slot Tersisa</div>
                            <div class="font-medium">{{ $slotsLeft }} slot</div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('dudis.index') }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">Tutup</a>
                        @if(Auth::user()->role == 'siswa' && $dudi->status === 'Aktif')
                            @if($hasApplied)
                                <button disabled class="px-4 py-2 bg-gray-200 text-gray-600 text-sm font-medium rounded-lg cursor-not-allowed">Sudah Mendaftar</button>
                            @else
                                <form action="{{ route('dudis.apply', $dudi) }}" method="POST" onsubmit="return confirm('Ajukan pendaftaran magang ke {{ $dudi->name }}?');">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-cyan-600 text-white text-sm font-medium rounded-lg hover:bg-cyan-700">Daftar Magang</button>
                                </form>
                            @endif
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi DUDI</h3>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Nama DUDI</p>
                                <p class="text-base">{{ $dudi->name }}</p>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Alamat</p>
                                <p class="text-base">{{ $dudi->address }}</p>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Telepon</p>
                                <p class="text-base">{{ $dudi->phone }}</p>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="text-base">{{ $dudi->email }}</p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi PIC</h3>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Nama PIC</p>
                                <p class="text-base">{{ $dudi->pic_name }}</p>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Kontak PIC</p>
                                <p class="text-base">{{ $dudi->pic_contact }}</p>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Status</p>
                                <p class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $dudi->status === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dudi->status }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Magang di DUDI Ini</h3>
                        @if($dudi->internships->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Siswa</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Guru Pembimbing</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Mulai</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Selesai</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dudi->internships as $internship)
                                            <tr>
                                                <td class="py-2 px-4 border-b border-gray-200">{{ $internship->student->name }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200">{{ $internship->teacher->name }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200">{{ optional($internship->start_date)->format('d/m/Y') ?? '-' }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200">{{ optional($internship->end_date)->format('d/m/Y') ?? '-' }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        @if($internship->status == 'Aktif') bg-green-100 text-green-800 
                                                        @elseif($internship->status == 'Selesai') bg-blue-100 text-blue-800 
                                                        @else bg-yellow-100 text-yellow-800 @endif">
                                                        {{ $internship->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500">Belum ada magang di DUDI ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>