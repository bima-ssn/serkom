<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Detail Magang') }}</h2>
            <div>
                <a href="{{ route('internships.edit', $internship->id) }}" class="inline-flex items-center px-3 py-2 bg-yellow-500 text-white text-sm font-medium rounded-md hover:bg-yellow-600 mr-2">Edit</a>
                <a href="{{ route('internships.index') }}" class="inline-flex items-center px-3 py-2 bg-gray-500 text-white text-sm font-medium rounded-md hover:bg-gray-600">Kembali</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(auth()->user()->role === 'guru')
                    <div class="mb-6 flex items-center justify-end gap-2">
                        @if($internship->status !== 'Selesai')
                        <a href="{{ route('internships.confirm.finish.form', $internship->id) }}" class="inline-flex items-center px-4 py-2 bg-cyan-600 text-white rounded-md hover:bg-cyan-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Konfirmasi Selesai & Sertifikat
                        </a>
                        @else
                        <a href="{{ route('internships.certificate.download', $internship->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V3"/></svg>
                            Unduh Sertifikat (PDF)
                        </a>
                        @endif
                    </div>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">DUDI</p>
                                <p class="text-base">{{ $internship->dudi->name }}</p>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Siswa</p>
                                <p class="text-base">{{ $internship->student->name }} ({{ $internship->student->nis_nip }})</p>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Guru Pembimbing</p>
                                <p class="text-base">{{ $internship->teacher->name }} ({{ $internship->teacher->nis_nip }})</p>
                            </div>
                        </div>
                        <div>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Tanggal Mulai</p>
                                <p class="text-base">{{ optional($internship->start_date)->format('d/m/Y') ?? '-' }}</p>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Tanggal Selesai</p>
                                <p class="text-base">{{ optional($internship->end_date)->format('d/m/Y') ?? '-' }}</p>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Status</p>
                                <div>
                                    @if($internship->status == 'Pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                    @elseif($internship->status == 'Aktif')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                    @elseif($internship->status == 'Selesai')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Selesai</span>
                                    @elseif($internship->status == 'Ditolak')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Dibatalkan</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Jurnal Harian</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kegiatan</th>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($internship->journals as $index => $journal)
                                        <tr class="odd:bg-white even:bg-gray-50">
                                            <td class="py-2.5 px-4 border-b border-gray-200">{{ $index + 1 }}</td>
                                            <td class="py-2.5 px-4 border-b border-gray-200">{{ optional($journal->date)->format('d/m/Y') ?? '-' }}</td>
                                            <td class="py-2.5 px-4 border-b border-gray-200">{{ \Illuminate\Support\Str::limit($journal->description, 100) }}</td>
                                            <td class="py-2.5 px-4 border-b border-gray-200">
                                                @if($journal->status == 'Menunggu Verifikasi')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                @elseif($journal->status == 'Disetujui')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                                @elseif($journal->status == 'Ditolak')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="py-2.5 px-4 border-b border-gray-200">
                                                <a href="{{ route('journals.show', $journal->id) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-4 px-4 border-b border-gray-200 text-center text-gray-500">Tidak ada data jurnal</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>