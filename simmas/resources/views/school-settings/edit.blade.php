<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pengaturan Sekolah') }}</h2>
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'href' => route('dashboard')],
                ['label' => 'Pengaturan Sekolah']
            ]" />
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column - Form -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <h3 class="text-base font-semibold text-gray-900">Informasi Sekolah</h3>
                            </div>
                            <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-cyan-700 bg-cyan-50 rounded-lg hover:bg-cyan-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </button>
                        </div>

                        <form method="POST" action="{{ route('school-settings.update', $setting) }}" enctype="multipart/form-data" id="schoolForm">
                            @csrf
                            @method('PUT')

                            <div class="space-y-5">
                                <!-- Logo Sekolah -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Logo Sekolah
                                    </label>
                                    @if($setting->logo)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $setting->logo) . '?v=' . optional($setting->updated_at)->timestamp }}" alt="Logo" class="h-20 w-20 object-contain border border-gray-200 rounded-lg p-2">
                                        </div>
                                    @endif
                                    <input 
                                        type="file" 
                                        name="logo" 
                                        accept="image/*"
                                        class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 cursor-pointer"
                                    >
                                    @error('logo')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nama Sekolah/Instansi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        Nama Sekolah/Instansi
                                    </label>
                                    <input 
                                        type="text" 
                                        name="name" 
                                        value="{{ old('name', $setting->name) }}" 
                                        placeholder="Masukkan nama sekolah"
                                        class="block w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('name') border-red-500 @enderror"
                                        required
                                    >
                                    @error('name')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Alamat Lengkap -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Alamat Lengkap
                                    </label>
                                    <textarea 
                                        name="address" 
                                        rows="3"
                                        placeholder="Masukkan alamat lengkap sekolah"
                                        class="block w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('address') border-red-500 @enderror"
                                        required
                                    >{{ old('address', $setting->address) }}</textarea>
                                    @error('address')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Telepon & Email -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            Telepon
                                        </label>
                                        <input 
                                            type="text" 
                                            name="phone" 
                                            value="{{ old('phone', $setting->phone) }}" 
                                            placeholder="031-1234567"
                                            class="block w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500"
                                            required
                                        >
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            Email
                                        </label>
                                        <input 
                                            type="email" 
                                            name="email" 
                                            value="{{ old('email', $setting->email) }}" 
                                            placeholder="info@sekolah.sch.id"
                                            class="block w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500"
                                            required
                                        >
                                    </div>
                                </div>

                                <!-- Website -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                        </svg>
                                        Website
                                    </label>
                                    <input 
                                        type="url" 
                                        name="website" 
                                        value="{{ old('website', $setting->website ?? '') }}" 
                                        placeholder="www.sekolah.sch.id"
                                        class="block w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500"
                                    >
                                </div>

                                <!-- Kepala Sekolah -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Kepala Sekolah
                                    </label>
                                    <input 
                                        type="text" 
                                        name="principal_name" 
                                        value="{{ old('principal_name', $setting->principal_name ?? '') }}" 
                                        placeholder="Nama Kepala Sekolah"
                                        class="block w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500"
                                    >
                                </div>

                                <!-- NPSN -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                        </svg>
                                        NPSN (Nomor Pokok Sekolah Nasional)
                                    </label>
                                    <input 
                                        type="text" 
                                        name="npsn" 
                                        value="{{ old('npsn', $setting->npsn ?? '') }}" 
                                        placeholder="20567890"
                                        class="block w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500"
                                    >
                                </div>
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-200 flex items-center justify-end gap-3">
                                <button 
                                    type="button" 
                                    onclick="window.history.back()"
                                    class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
                                >
                                    Batal
                                </button>
                                <button 
                                    type="submit"
                                    class="px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-cyan-600 rounded-lg hover:from-cyan-600 hover:to-cyan-700"
                                >
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>

                        <!-- Informasi Terakhir Update -->
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-xs text-gray-500">
                                Terakhir diperbarui: {{ $setting->updated_at ? $setting->updated_at->format('d F Y H:i') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Preview -->
                <div class="space-y-6">
                    <!-- Preview Tampilan -->
                    <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-xl shadow-sm border border-cyan-100 p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <h3 class="text-sm font-semibold text-cyan-900">Preview Tampilan</h3>
                        </div>
                        <p class="text-xs text-cyan-700">Pratinjau bagaimana informasi sekolah akan ditampilkan di header navigasi</p>
                    </div>

                    <!-- Dashboard Header Preview -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <p class="text-xs font-medium text-gray-500 mb-3">Dashboard Header</p>
                        <div class="bg-gray-50 rounded-lg p-4 flex items-center gap-4">
                            @if($setting->logo)
                                <img src="{{ asset('storage/' . $setting->logo) . '?v=' . optional($setting->updated_at)->timestamp }}" alt="Logo" class="h-12 w-12 object-contain">
                            @else
                                <div class="h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $setting->name }}</h4>
                                <p class="text-xs text-gray-600">Sistem Informasi Magang</p>
                            </div>
                        </div>
                    </div>

                    <!-- Header Raport/Sertifikat Preview -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <p class="text-xs font-medium text-gray-500 mb-3">Header Raport/Sertifikat</p>
                        <div class="bg-white border-2 border-gray-300 rounded-lg p-6">
                            <div class="flex items-start gap-4">
                                @if($setting->logo)
                                    <img src="{{ asset('storage/' . $setting->logo) . '?v=' . optional($setting->updated_at)->timestamp }}" alt="Logo" class="h-16 w-16 object-contain flex-shrink-0">
                                @else
                                    <div class="h-16 w-16 bg-gray-100 rounded flex items-center justify-center flex-shrink-0">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 text-center">
                                    <h4 class="font-bold text-base text-gray-900">{{ $setting->name }}</h4>
                                    <p class="text-xs text-gray-600 mt-1">{{ $setting->address }}</p>
                                    <div class="flex items-center justify-center gap-4 mt-2 text-xs text-gray-600">
                                        <span>Telp: {{ $setting->phone }}</span>
                                        <span>Email: {{ $setting->email }}</span>
                                    </div>
                                    @if($setting->website ?? false)
                                        <p class="text-xs text-gray-600 mt-1">Web: {{ $setting->website }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t-2 border-gray-900 text-center">
                                <p class="font-bold text-sm">SERTIFIKAT MAGANG</p>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen Cetak Preview -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <p class="text-xs font-medium text-gray-500 mb-3">Dokumen Cetak</p>
                        <div class="bg-white border border-gray-300 rounded-lg p-4">
                            <div class="flex items-center gap-3 mb-3 pb-3 border-b border-gray-200">
                                @if($setting->logo)
                                    <img src="{{ asset('storage/' . $setting->logo) . '?v=' . optional($setting->updated_at)->timestamp }}" alt="Logo" class="h-12 w-12 object-contain">
                                @else
                                    <div class="h-12 w-12 bg-gray-100 rounded flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="text-xs">
                                    <p class="font-bold text-gray-900">{{ $setting->name }}</p>
                                    <p class="text-gray-600">NPSN: {{ $setting->npsn ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="text-xs space-y-1 text-gray-700">
                                <p><strong>📍</strong> {{ $setting->address }}</p>
                                <p><strong>📞</strong> {{ $setting->phone }}</p>
                                <p><strong>✉️</strong> {{ $setting->email }}</p>
                            </div>
                            <div class="mt-3 pt-3 border-t border-gray-200 text-xs text-gray-600">
                                <p><strong>Kepala Sekolah:</strong> {{ $setting->principal_name ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Penggunaan -->
                    <div class="bg-blue-50 rounded-xl border border-blue-100 p-4">
                        <h4 class="text-sm font-semibold text-blue-900 mb-3">Informasi Penggunaan:</h4>
                        <ul class="space-y-2 text-xs text-blue-800">
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span><strong>Dashboard:</strong> Logo dan nama sekolah akan ditampilkan di header navigasi</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span><strong>Raport/Sertifikat:</strong> Informasi lengkap sebagai header pada laporan yang dicetak</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span><strong>Dokumen Cetak:</strong> Footer atau header pada laporan yang dicetak</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>