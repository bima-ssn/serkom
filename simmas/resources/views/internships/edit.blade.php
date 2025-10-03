<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Data Magang') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('internships.update', $internship->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">DUDI</label>
                                <select id="dudi_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('dudi_id') border-red-300 @enderror" name="dudi_id" required>
                                    <option value="">Pilih DUDI</option>
                                    @foreach($dudis as $dudi)
                                        <option value="{{ $dudi->id }}" {{ (old('dudi_id', $internship->dudi_id) == $dudi->id) ? 'selected' : '' }}>{{ $dudi->name }}</option>
                                    @endforeach
                                </select>
                                @error('dudi_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Siswa</label>
                                <select id="student_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('student_id') border-red-300 @enderror" name="student_id" required>
                                    <option value="">Pilih Siswa</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ (old('student_id', $internship->student_id) == $student->id) ? 'selected' : '' }}>{{ $student->name }} ({{ $student->nis_nip }})</option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Guru Pembimbing</label>
                                <select id="teacher_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('teacher_id') border-red-300 @enderror" name="teacher_id" required>
                                    <option value="">Pilih Guru</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ (old('teacher_id', $internship->teacher_id) == $teacher->id) ? 'selected' : '' }}>{{ $teacher->name }} ({{ $teacher->nis_nip }})</option>
                                    @endforeach
                                </select>
                                @error('teacher_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                <input id="start_date" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('start_date') border-red-300 @enderror" name="start_date" value="{{ old('start_date', optional($internship->start_date)->format('Y-m-d')) }}" required>
                                    @error('start_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                                    <input id="end_date" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('end_date') border-red-300 @enderror" name="end_date" value="{{ old('end_date', optional($internship->end_date)->format('Y-m-d')) }}" required>
                                    @error('end_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-300 @enderror" name="description">{{ old('description', $internship->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('status') border-red-300 @enderror" name="status" required>
                                    <option value="Pending" {{ (old('status', $internship->status) == 'Pending') ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Aktif" {{ (old('status', $internship->status) == 'Aktif') ? 'selected' : '' }}>Aktif</option>
                                    <option value="Selesai" {{ (old('status', $internship->status) == 'Selesai') ? 'selected' : '' }}>Selesai</option>
                                    <option value="Ditolak" {{ (old('status', $internship->status) == 'Ditolak') ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end">
                            <x-secondary-button type="button" onclick="window.history.back()">Batal</x-secondary-button>
                            <x-primary-button class="ms-3">Simpan Perubahan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>