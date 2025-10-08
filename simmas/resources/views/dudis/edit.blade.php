<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit DUDI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">Edit DUDI</h3>
                        <p class="text-gray-600 mt-1">Perbarui informasi DUDI di bawah ini</p>
                    </div>
                    
                    <form method="POST" action="{{ route('dudis.update', $dudi) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Kolom Kiri -->
                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Perusahaan <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        id="name" 
                                        name="name" 
                                        type="text" 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                        value="{{ old('name', $dudi->name) }}" 
                                        placeholder="PT. Contoh Perusahaan"
                                        required 
                                        autofocus
                                    />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                        Alamat <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        id="address" 
                                        name="address" 
                                        type="text" 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                        value="{{ old('address', $dudi->address) }}" 
                                        placeholder="Jl. Contoh No. 123, Jakarta"
                                        required
                                    />
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>
                                
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Telepon <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        id="phone" 
                                        name="phone" 
                                        type="text" 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                        value="{{ old('phone', $dudi->phone) }}" 
                                        placeholder="021-12345678"
                                        required
                                    />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>
                                
                                <div>
                                    <label for="student_quota" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kuota Siswa <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        id="student_quota" 
                                        name="student_quota" 
                                        type="number" 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                        value="{{ old('student_quota', $dudi->student_quota) }}" 
                                        min="1"
                                        required
                                    />
                                    <x-input-error :messages="$errors->get('student_quota')" class="mt-2" />
                                </div>
                                
                                <div>
                                    <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Guru Pembimbing
                                    </label>
                                    <select 
                                        id="teacher_id" 
                                        name="teacher_id" 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    >
                                        <option value="">Pilih Guru Pembimbing</option>
                                        @foreach(\App\Models\User::where('role', 'guru')->get() as $teacher)
                                            <option value="{{ $teacher->id }}" {{ old('teacher_id', $dudi->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                                {{ $teacher->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">Opsional - Bisa diisi nanti</p>
                                    <x-input-error :messages="$errors->get('teacher_id')" class="mt-2" />
                                </div>
                            </div>
                            
                            <!-- Kolom Kanan -->
                            <div class="space-y-6">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        id="email" 
                                        name="email" 
                                        type="email" 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                        value="{{ old('email', $dudi->email) }}" 
                                        placeholder="info@perusahaan.com"
                                        required
                                    />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                
                                <div>
                                    <label for="pic_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Penanggung Jawab <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        id="pic_name" 
                                        name="pic_name" 
                                        type="text" 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                        value="{{ old('pic_name', $dudi->pic_name) }}" 
                                        placeholder="Nama PIC"
                                        required
                                    />
                                    <x-input-error :messages="$errors->get('pic_name')" class="mt-2" />
                                </div>
                                
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kategori <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        id="category" 
                                        name="category" 
                                        type="text" 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                        value="{{ old('category', $dudi->category) }}" 
                                        placeholder="IT, Manufaktur, Perhotelan, dll"
                                        required
                                    />
                                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                </div>
                                
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        id="status" 
                                        name="status" 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        required
                                    >
                                        <option value="Pending" {{ old('status', $dudi->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Aktif" {{ old('status', $dudi->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak Aktif" {{ old('status', $dudi->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end mt-8 pt-6 border-t">
                            <a href="{{ route('dudis.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 mr-3 transition duration-150 ease-in-out">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-teal-600 text-white text-sm font-medium rounded-md hover:bg-teal-700 transition duration-150 ease-in-out">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>