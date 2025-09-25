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
                    <form method="POST" action="{{ route('dudis.update', $dudi) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama DUDI')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $dudi->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="address" :value="__('Alamat')" />
                            <textarea id="address" name="address" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="3" required>{{ old('address', $dudi->address) }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="phone" :value="__('Telepon')" />
                            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $dudi->phone)" required />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $dudi->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="pic_name" :value="__('Nama PIC')" />
                            <x-text-input id="pic_name" class="block mt-1 w-full" type="text" name="pic_name" :value="old('pic_name', $dudi->pic_name)" required />
                            <x-input-error :messages="$errors->get('pic_name')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="pic_contact" :value="__('Kontak PIC')" />
                            <x-text-input id="pic_contact" class="block mt-1 w-full" type="text" name="pic_contact" :value="old('pic_contact', $dudi->pic_contact)" required />
                            <x-input-error :messages="$errors->get('pic_contact')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="Aktif" {{ old('status', $dudi->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ old('status', $dudi->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('dudis.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>