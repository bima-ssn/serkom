<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Manajemen Siswa Magang') }}</h2>
                <x-breadcrumbs :items="[
                    ['label' => 'Dashboard', 'href' => route('dashboard')],
                    ['label' => 'Magang', 'href' => route('internships.index')],
                    ['label' => 'Edit']
                ]" />
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Modal Style Form -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-4xl mx-auto">
                <div class="p-8">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Edit Data Siswa Magang</h3>
                            <p class="text-sm text-gray-500 mt-1">Perbarui informasi data magang siswa</p>
                        </div>
                        <a href="{{ route('internships.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>

                    <form method="POST" action="{{ route('internships.update', $internship->id) }}" class="mt-8">
                        @csrf
                        @method('PUT')

                        <!-- Periode & Status Section -->
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Periode & Status</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                                    <div class="relative">
                                        <input 
                                            id="start_date" 
                                            type="date" 
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-4 pr-10 py-3 @error('start_date') border-red-300 @enderror" 
                                            name="start_date" 
                                            value="{{ old('start_date', optional($internship->start_date)->format('Y-m-d')) }}" 
                                            required
                                        >
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('start_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                                    <div class="relative">
                                        <input 
                                            id="end_date" 
                                            type="date" 
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-4 pr-10 py-3 @error('end_date') border-red-300 @enderror" 
                                            name="end_date" 
                                            value="{{ old('end_date', optional($internship->end_date)->format('Y-m-d')) }}" 
                                            required
                                        >
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('end_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select 
                                        id="status" 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-3 @error('status') border-red-300 @enderror" 
                                        name="status" 
                                        required
                                    >
                                        <option value="Pending" {{ (old('status', $internship->status) == 'Pending') ? 'selected' : '' }}>Pending</option>
                                        <option value="Aktif" {{ (old('status', $internship->status) == 'Aktif') ? 'selected' : '' }}>Aktif</option>
                                        <option value="Selesai" {{ (old('status', $internship->status) == 'Selesai') ? 'selected' : '' }}>Selesai</option>
                                        <option value="Ditolak" {{ (old('status', $internship->status) == 'Ditolak') ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Penilaian Section -->
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Penilaian</h4>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Akhir</label>
                                <input 
                                    id="final_score" 
                                    type="number" 
                                    min="0" 
                                    max="100" 
                                    step="0.01"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-3 @error('final_score') border-red-300 @enderror" 
                                    name="final_score" 
                                    value="{{ old('final_score', $internship->final_score) }}"
                                    placeholder="Hanya bisa diisi jika status selesai"
                                >
                                <p class="mt-2 text-sm text-gray-500">Nilai hanya dapat diisi setelah status magang selesai</p>
                                @error('final_score')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Informasi Siswa, Guru & DUDI -->
                        <div class="mb-8 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Siswa</label>
                                <select 
                                    id="student_id" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-3 @error('student_id') border-red-300 @enderror" 
                                    name="student_id" 
                                    required
                                >
                                    <option value="">Pilih Siswa</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ (old('student_id', $internship->student_id) == $student->id) ? 'selected' : '' }}>
                                            {{ $student->name }} ({{ $student->nis_nip }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Guru Pembimbing</label>
                                <select 
                                    id="teacher_id" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-3 @error('teacher_id') border-red-300 @enderror" 
                                    name="teacher_id" 
                                    required
                                >
                                    <option value="">Pilih Guru</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ (old('teacher_id', $internship->teacher_id) == $teacher->id) ? 'selected' : '' }}>
                                            {{ $teacher->name }} ({{ $teacher->nis_nip }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('teacher_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">DUDI</label>
                                <select 
                                    id="dudi_id" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-3 @error('dudi_id') border-red-300 @enderror" 
                                    name="dudi_id" 
                                    required
                                >
                                    <option value="">Pilih DUDI</option>
                                    @foreach($dudis as $dudi)
                                        <option value="{{ $dudi->id }}" {{ (old('dudi_id', $internship->dudi_id) == $dudi->id) ? 'selected' : '' }}>
                                            {{ $dudi->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('dudi_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi Section -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea 
                                id="description" 
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-3 @error('description') border-red-300 @enderror" 
                                name="description" 
                                rows="4"
                                placeholder="Tambahkan deskripsi magang"
                            >{{ old('description', $internship->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                            <button 
                                type="button" 
                                onclick="window.location.href='{{ route('internships.index') }}'"
                                class="px-6 py-3 bg-white border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors"
                            >
                                Batal
                            </button>
                            <button 
                                type="submit" 
                                class="px-6 py-3 bg-blue-600 border border-transparent rounded-lg text-white font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                            >
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for status-based grade input -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status');
            const gradeInput = document.getElementById('final_score');
            
            function toggleGradeInput() {
                if (statusSelect.value === 'Selesai') {
                    gradeInput.disabled = false;
                    gradeInput.classList.remove('bg-gray-100');
                } else {
                    gradeInput.disabled = true;
                    gradeInput.classList.add('bg-gray-100');
                    gradeInput.value = '';
                }
            }
            
            // Check initial state
            toggleGradeInput();
            
            // Listen for changes
            statusSelect.addEventListener('change', toggleGradeInput);
        });
    </script>
</x-app-layout>