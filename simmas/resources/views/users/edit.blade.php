<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Informasi pengguna saat ini -->
                    <div class="bg-gray-50 p-6 rounded-lg mb-6 border">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Pengguna yang Sedang Diedit</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Nama</p>
                                <p class="font-medium">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-medium">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Role</p>
                                <p class="font-medium">{{ ucfirst($user->role) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status Verifikasi Email</p>
                                <p class="font-medium text-green-600">
                                    <i class="fas fa-check-circle mr-1"></i> Verified
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-gray-600 text-sm">Form edit tersedia dalam modal di atas. Silakan perbarui data yang diperlukan.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pengguna (Langsung Terbuka) -->
    <div id="editUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 w-full max-w-2xl">
            <div class="bg-white rounded-lg shadow-xl modal-content fade-in">
                <!-- Header Modal -->
                <div class="px-6 py-4 border-b">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Edit User
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Perbarui informasi user</p>
                </div>
                
                <!-- Form Edit -->
                <form method="POST" action="{{ route('users.update', $user) }}" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input 
                                id="name" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                type="text" 
                                name="name" 
                                value="{{ old('name', $user->name) }}" 
                                required 
                                autofocus
                            />
                            @if ($errors->has('name'))
                            <p class="mt-1 text-sm text-red-600">{{ $errors->first('name') }}</p>
                            @endif
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input 
                                id="email" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                type="email" 
                                name="email" 
                                value="{{ old('email', $user->email) }}" 
                                required 
                            />
                            @if ($errors->has('email'))
                            <p class="mt-1 text-sm text-red-600">{{ $errors->first('email') }}</p>
                            @endif
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="role" 
                                name="role" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="guru" {{ old('role', $user->role) == 'guru' ? 'selected' : '' }}>Guru</option>
                                <option value="siswa" {{ old('role', $user->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            </select>
                            @if ($errors->has('role'))
                            <p class="mt-1 text-sm text-red-600">{{ $errors->first('role') }}</p>
                            @endif
                        </div>

                        <!-- Catatan Password -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        <strong>Catatan:</strong> Untuk mengubah password, silakan gunakan fitur reset password yang terpisah.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Email Verification Status -->
                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Email Verification</h4>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                                <div class="ml-2">
                                    <p class="text-sm font-medium text-green-600">Verified</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Footer Modal -->
                    <div class="flex items-center justify-end mt-6 pt-4 border-t">
                        <a 
                            href="{{ route('users.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 mr-3 transition duration-150 ease-in-out"
                        >
                            Batal
                        </a>
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition duration-150 ease-in-out"
                        >
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .modal-content {
            max-height: 85vh;
            overflow-y: auto;
        }
        
        .fade-in {
            animation: fadeIn 0.2s ease-out;
        }
        
        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: scale(0.95) translateY(-10px); 
            }
            to { 
                opacity: 1; 
                transform: scale(1) translateY(0); 
            }
        }
        
        /* Lock body scroll when modal is open */
        body {
            overflow: hidden;
        }
    </style>

    <script>
        // Modal langsung terbuka saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('editUserModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Focus ke input nama
            document.getElementById('name').focus();
        });
        
        function closeEditModal() {
            document.getElementById('editUserModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Tutup modal saat mengklik di luar konten modal
        window.onclick = function(event) {
            const modal = document.getElementById('editUserModal');
            if (event.target === modal) {
                closeEditModal();
                // Redirect kembali ke halaman users index
                window.location.href = "{{ route('users.index') }}";
            }
        }
        
        // Tutup modal dengan tombol ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeEditModal();
                // Redirect kembali ke halaman users index
                window.location.href = "{{ route('users.index') }}";
            }
        });
    </script>
</x-app-layout>