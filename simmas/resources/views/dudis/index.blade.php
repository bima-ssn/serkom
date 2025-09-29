<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen DUDI') }}
            </h2>
            <a href="{{ route('dudis.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah DUDI
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alamat</th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Telepon</th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">PIC</th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dudis as $dudi)
                                    <tr class="odd:bg-white even:bg-gray-50">
                                        <td class="py-2.5 px-4 border-b border-gray-200">{{ $dudi->name }}</td>
                                        <td class="py-2.5 px-4 border-b border-gray-200">{{ $dudi->address }}</td>
                                        <td class="py-2.5 px-4 border-b border-gray-200">{{ $dudi->phone }}</td>
                                        <td class="py-2.5 px-4 border-b border-gray-200">{{ $dudi->email }}</td>
                                        <td class="py-2.5 px-4 border-b border-gray-200">{{ $dudi->pic_name }}</td>
                                        <td class="py-2.5 px-4 border-b border-gray-200">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $dudi->status === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $dudi->status }}
                                            </span>
                                        </td>
                                        <td class="py-2.5 px-4 border-b border-gray-200">
                                            <div class="flex items-center gap-3">
                                                <a href="{{ route('dudis.show', $dudi) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                                <a href="{{ route('dudis.edit', $dudi) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form action="{{ route('dudis.destroy', $dudi) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus DUDI ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-4 px-4 border-b border-gray-200 text-center text-gray-500">Tidak ada data DUDI</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>