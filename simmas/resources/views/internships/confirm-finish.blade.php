<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Konfirmasi Selesai Magang') }}</h2>
                <x-breadcrumbs :items="[
                    ['label' => 'Dashboard', 'href' => route('dashboard')],
                    ['label' => 'Magang', 'href' => route('internships.index')],
                    ['label' => 'Konfirmasi Selesai']
                ]" />
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Data Magang</h3>
                        <p class="text-sm text-gray-600 mt-1">Sertakan tanda tangan Guru dan DUDI untuk mengesahkan sertifikat.</p>
                    </div>

                    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Siswa</p>
                            <p class="font-medium">{{ $internship->student->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">DUDI</p>
                            <p class="font-medium">{{ $internship->dudi->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Guru Pembimbing</p>
                            <p class="font-medium">{{ $internship->teacher->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Periode</p>
                            <p class="font-medium">{{ optional($internship->start_date)->format('d M Y') ?? '-' }} - {{ optional($internship->end_date)->format('d M Y') ?? '-' }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('internships.confirm.finish.store', $internship->id) }}" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanda Tangan Guru (PNG/JPG)</label>
                            <input type="file" name="teacher_signature" accept="image/png,image/jpeg" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            @error('teacher_signature')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanda Tangan DUDI (PNG/JPG)</label>
                            <input type="file" name="dudi_signature" accept="image/png,image/jpeg" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            @error('dudi_signature')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                            <input type="date" name="finished_at" value="{{ old('finished_at', optional($internship->end_date)->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                            @error('finished_at')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Catatan Sertifikat (opsional)</label>
                            <textarea name="certificate_notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md" placeholder="Misal: Telah menyelesaikan 6 bulan program magang dengan baik.">{{ old('certificate_notes') }}</textarea>
                            @error('certificate_notes')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('internships.show', $internship->id) }}" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-md">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-cyan-600 text-white rounded-md hover:bg-cyan-700">Konfirmasi & Buat Sertifikat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


