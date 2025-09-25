<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail DUDI') }}
            </h2>
            <div>
                <a href="{{ route('dudis.edit', $dudi) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Edit
                </a>
                <a href="{{ route('dudis.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi DUDI</h3>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Nama DUDI</p>
                                <p class="text-base">{{ $dudi->name }}</p>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Alamat</p>
                                <p class="text-base">{{ $dudi->address }}</p>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Telepon</p>
                                <p class="text-base">{{ $dudi->phone }}</p>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="text-base">{{ $dudi->email }}</p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi PIC</h3>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Nama PIC</p>
                                <p class="text-base">{{ $dudi->pic_name }}</p>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Kontak PIC</p>
                                <p class="text-base">{{ $dudi->pic_contact }}</p>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Status</p>
                                <p class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $dudi->status === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dudi->status }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Magang di DUDI Ini</h3>
                        @if($dudi->internships->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Siswa</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Guru Pembimbing</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Mulai</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Selesai</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dudi->internships as $internship)
                                            <tr>
                                                <td class="py-2 px-4 border-b border-gray-200">{{ $internship->student->name }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200">{{ $internship->teacher->name }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200">{{ $internship->start_date->format('d/m/Y') }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200">{{ $internship->end_date->format('d/m/Y') }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        @if($internship->status == 'Aktif') bg-green-100 text-green-800 
                                                        @elseif($internship->status == 'Selesai') bg-blue-100 text-blue-800 
                                                        @else bg-yellow-100 text-yellow-800 @endif">
                                                        {{ $internship->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500">Belum ada magang di DUDI ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>