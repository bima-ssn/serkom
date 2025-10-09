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

    <!-- Modal Overlay -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="max-w-4xl w-full">
            <!-- Modal Content -->
            <div class="bg-white overflow-hidden shadow-2xl rounded-2xl transform transition-all animate-modal-slide-up">
                <div class="p-8 max-h-[90vh] overflow-y-auto">
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

                        <!-- Penilaian dipindahkan ke halaman Konfirmasi Selesai -->

                        <!-- Hidden fields for data that shouldn't change -->
                        <input type="hidden" name="student_id" value="{{ $internship->student_id }}">
                        <input type="hidden" name="teacher_id" value="{{ $internship->teacher_id }}">
                        <input type="hidden" name="dudi_id" value="{{ $internship->dudi_id }}">

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

    <!-- Custom Styles for Modal Animation -->
    <style>
        @keyframes modalSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-modal-slide-up {
            animation: modalSlideUp 0.3s ease-out;
        }

        /* Custom scrollbar for modal */
        .max-h-\[90vh\]::-webkit-scrollbar {
            width: 8px;
        }

        .max-h-\[90vh\]::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .max-h-\[90vh\]::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .max-h-\[90vh\]::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>

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