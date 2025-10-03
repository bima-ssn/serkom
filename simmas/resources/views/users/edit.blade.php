<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama</label>
                                <input id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus />
                                @if ($errors->has('name'))
                                <p class="mt-1 text-sm text-red-600">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" value="{{ old('email', $user->email) }}" required />
                                @if ($errors->has('email'))
                                <p class="mt-1 text-sm text-red-600">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Password (opsional)</label>
                                    <input id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" />
                                    @if ($errors->has('password'))
                                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('password') }}</p>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                    <input id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password_confirmation" />
                                    @if ($errors->has('password_confirmation'))
                                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('password_confirmation') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Role</label>
                                    <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="guru" {{ old('role', $user->role) == 'guru' ? 'selected' : '' }}>Guru</option>
                                        <option value="siswa" {{ old('role', $user->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                    </select>
                                    @if ($errors->has('role'))
                                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('role') }}</p>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NIS/NIP</label>
                                    <input id="nis_nip" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="nis_nip" value="{{ old('nis_nip', $user->nis_nip) }}" />
                                    @if ($errors->has('nis_nip'))
                                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('nis_nip') }}</p>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Telepon</label>
                                    <input id="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="phone" value="{{ old('phone', $user->phone) }}" />
                                    @if ($errors->has('phone'))
                                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('phone') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('users.index') }}" class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 mr-2">Batal</a>
                            <button type="submit" class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>