<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Magang Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($internship)
                        <div class="mb-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900">Data Magang</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Siswa</label>
                                        <p class="text-base text-gray-900">{{ $internship->student->name }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">NIS</label>
                                        <p class="text-base text-gray-900">{{ $internship->student->nis_nip ?? '-' }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Kelas</label>
                                        <p class="text-base text-gray-900">{{ $internship->student->kelas ?? '-' }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Jurusan</label>
                                        <p class="text-base text-gray-900">{{ $internship->student->jurusan ?? '-' }}</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Perusahaan</label>
                                        <p class="text-base text-gray-900">{{ $internship->dudi->name }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Alamat Perusahaan</label>
                                        <p class="text-base text-gray-900">{{ $internship->dudi->address }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Periode Magang</label>
                                        <p class="text-base text-gray-900">
                                            {{ optional($internship->start_date)->format('d M Y') ?? '-' }} s.d {{ optional($internship->end_date)->format('d M Y') ?? '-' }}
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                                        <div class="flex items-center gap-2">
                                            @php
                                                $statusLower = strtolower($internship->status ?? '');
                                                $badgeClass = 'bg-gray-100 text-gray-700';
                                                if (in_array($statusLower, ['active','aktif'])) $badgeClass = 'bg-emerald-100 text-emerald-700';
                                                elseif (in_array($statusLower, ['pending'])) $badgeClass = 'bg-amber-100 text-amber-700';
                                                elseif (in_array($statusLower, ['completed','selesai'])) $badgeClass = 'bg-blue-100 text-blue-700';
                                                elseif (in_array($statusLower, ['ditolak','cancelled'])) $badgeClass = 'bg-red-100 text-red-700';
                                            @endphp
                                            <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium {{ $badgeClass }}">
                                                {{ $internship->status }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Nilai Akhir</label>
                                        <p class="text-base text-gray-900">
                                            @if($internship->final_score)
                                                {{ $internship->final_score }}
                                            @else
                                                <span class="text-gray-500">Belum ada nilai</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Data Magang</h3>
                            <p class="text-gray-500 mb-6">Anda belum memiliki data magang. Silakan hubungi guru pembimbing untuk informasi lebih lanjut.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
