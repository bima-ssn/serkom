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
                        <button type="button" onclick="window.location.href='{{ route('internships.index') }}'" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
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
                                            value="{{ old('start_date', $internship->start_date) }}" 
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
                                            value="{{ old('end_date', $internship->end_date) }}" 
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
                                        <option value="pending" {{ (old('status', $internship->status) == 'pending') ? 'selected' : '' }}>Pending</option>
                                        <option value="active" {{ (old('status', $internship->status) == 'active') ? 'selected' : '' }}>Aktif</option>
                                        <option value="completed" {{ (old('status', $internship->status) == 'completed') ? 'selected' : '' }}>Selesai</option>
                                        <option value="cancelled" {{ (old('status', $internship->status) == 'cancelled') ? 'selected' : '' }}>Dibatalkan</option>
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
                                    id="grade" 
                                    type="number" 
                                    min="0" 
                                    max="100" 
                                    step="0.01"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-3 @error('grade') border-red-300 @enderror" 
                                    name="grade" 
                                    value="{{ old('grade', $internship->grade) }}"
                                    placeholder="Hanya bisa diisi jika status selesai"
                                    {{ $internship->status != 'completed' ? 'disabled' : '' }}
                                >
                                <p class="mt-2 text-sm text-gray-500">Nilai hanya dapat diisi setelah status magang selesai</p>
                                @error('grade')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Hidden fields for data that shouldn't change -->
                        <input type="hidden" name="student_id" value="{{ $internship->student_id }}">
                        <input type="hidden" name="teacher_id" value="{{ $internship->teacher_id }}">
                        <input type="hidden" name="dudi_id" value="{{ $internship->dudi_id }}">

                        <!-- Informasi Tambahan (Read-only) -->
                        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Informasi Data Magang</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500">Siswa</p>
                                    <p class="font-medium text-gray-900">{{ $internship->student->name }}</p>
                                    <p class="text-xs text-gray-400">NIS: {{ $internship->student->nis_nip ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Guru Pembimbing</p>
                                    <p class="font-medium text-gray-900">{{ $internship->teacher->name }}</p>
                                    <p class="text-xs text-gray-400">NIP: {{ $internship->teacher->nis_nip ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">DUDI</p>
                                    <p class="font-medium text-gray-900">{{ $internship->dudi->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $internship->dudi->location ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Section (Optional) -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                            <textarea 
                                id="notes" 
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-3 @error('notes') border-red-300 @enderror" 
                                name="notes" 
                                rows="4"
                                placeholder="Tambahkan catatan jika diperlukan"
                            >{{ old('notes', $internship->notes) }}</textarea>
                            @error('notes')
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
        document.getElementById('status').addEventListener('change', function() {
            const gradeInput = document.getElementById('grade');
            if (this.value === 'completed') {
                gradeInput.disabled = false;
            } else {
                gradeInput.disabled = true;
                gradeInput.value = '';
            }
        });
    </script>
</x-app-layout>