<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen DUDI') }}
            </h2>
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('dudis.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M12 3.75a.75.75 0 0 1 .75.75v6.75H19.5a.75.75 0 0 1 0 1.5h-6.75V19.5a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z"/></svg>
                Tambah DUDI
            </a>
            @endif
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
                    @if(isset($stats))
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="p-4 rounded-lg border border-gray-100 bg-blue-50">
                            <p class="text-sm text-gray-600">Total DUDI</p>
                            <p class="text-2xl font-semibold">{{ $stats['total'] }}</p>
                        </div>
                        <div class="p-4 rounded-lg border border-gray-100 bg-emerald-50">
                            <p class="text-sm text-gray-600">DUDI Aktif</p>
                            <p class="text-2xl font-semibold">{{ $stats['active'] }}</p>
                        </div>
                        <div class="p-4 rounded-lg border border-gray-100 bg-rose-50">
                            <p class="text-sm text-gray-600">DUDI Tidak Aktif</p>
                            <p class="text-2xl font-semibold">{{ $stats['inactive'] }}</p>
                        </div>
                        <div class="p-4 rounded-lg border border-gray-100 bg-indigo-50">
                            <p class="text-sm text-gray-600">Total Siswa Magang Aktif</p>
                            <p class="text-2xl font-semibold">{{ $stats['totalStudents'] }}</p>
                        </div>
                    </div>
                    @endif

                    <form method="GET" class="mb-4 flex flex-col md:flex-row gap-3 items-start md:items-center">
                        <div class="w-full md:w-auto">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, alamat, PIC, email, telepon" class="w-full md:w-80 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <select name="perPage" class="rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach([5,10,25,50] as $size)
                                    <option value="{{ $size }}" {{ (int)request('perPage', $perPage ?? 10) === $size ? 'selected' : '' }}>Tampilkan {{ $size }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select name="status" class="rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua Status</option>
                                <option value="Aktif" {{ request('status')==='Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ request('status')==='Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                        <div>
                            <button class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 4.271 12.02l3.727 3.728a.75.75 0 1 0 1.06-1.06l-3.728-3.727A6.75 6.75 0 0 0 10.5 3.75Zm-5.25 6.75a5.25 5.25 0 1 1 10.5 0 5.25 5.25 0 0 1-10.5 0Z" clip-rule="evenodd"/></svg>
                                Cari
                            </button>
                        </div>
                        @if(Auth::user()->role === 'admin')
                        <div class="ml-auto">
                            <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                                <input type="checkbox" name="with_trashed" value="1" {{ request('with_trashed') ? 'checked' : '' }}>
                                Tampilkan terhapus
                            </label>
                        </div>
                        @endif
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Perusahaan</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kontak</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Penanggung Jawab</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dudis as $dudi)
                                    <tr class="{{ $dudi->deleted_at ? 'opacity-60' : '' }}">
                                        <td class="py-2 px-4 border-b border-gray-200">
                                            <div class="font-medium text-gray-900">{{ $dudi->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $dudi->address }}</div>
                                        </td>
                                        <td class="py-2 px-4 border-b border-gray-200">
                                            <div class="text-sm text-gray-900">{{ $dudi->email }}</div>
                                            <div class="text-sm text-gray-500">{{ $dudi->phone }}</div>
                                        </td>
                                        <td class="py-2 px-4 border-b border-gray-200">{{ $dudi->pic_name }}</td>
                                        <td class="py-2 px-4 border-b border-gray-200">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $dudi->status === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $dudi->status }}
                                            </span>
                                        </td>
                                        <td class="py-2 px-4 border-b border-gray-200">
                                            <div class="flex items-center gap-3">
                                                <a href="{{ route('dudis.show', $dudi) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M1.5 12s3.75-7.5 10.5-7.5S22.5 12 22.5 12 18.75 19.5 12 19.5 1.5 12 1.5 12Z"/><path d="M12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z"/></svg>
                                                </a>
                                                @if(Auth::user()->role === 'admin' && !$dudi->deleted_at)
                                                <a href="{{ route('dudis.edit', $dudi) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0L8.943 11.345a4.5 4.5 0 0 0-1.116 1.86l-.8 2.801a.75.75 0 0 0 .933.933l2.8-.8a4.5 4.5 0 0 0 1.861-1.116l9.076-9.076a2.625 2.625 0 0 0 0-3.712Z"/><path d="M5.25 5.25a3 3 0 0 0-3 3v10.5A3 3 0 0 0 5.25 21h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0V18a1.5 1.5 0 0 1-1.5 1.5H5.25A1.5 1.5 0 0 1 3.75 18V8.25A1.5 1.5 0 0 1 5.25 6.75h4.5a.75.75 0 0 0 0-1.5h-4.5Z"/></svg>
                                                </a>
                                                <form action="{{ route('dudis.destroy', $dudi) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus DUDI ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M16.5 4.478V6h3.75a.75.75 0 0 1 0 1.5h-.727l-.676 10.819A3.75 3.75 0 0 1 15.105 22.5H8.895a3.75 3.75 0 0 1-3.742-4.181L4.477 7.5H3.75A.75.75 0 0 1 3 6h3.75V4.478a2.25 2.25 0 0 1 2.25-2.228h5.25a2.25 2.25 0 0 1 2.25 2.228ZM9 6h6V4.478a.75.75 0 0 0-.75-.728h-4.5a.75.75 0 0 0-.75.728V6Z" clip-rule="evenodd"/><path d="M9.75 9.75a.75.75 0 0 1 .75.75v6a.75.75 0 0 1-1.5 0v-6a.75.75 0 0 1 .75-.75ZM14.25 9.75a.75.75 0 0 1 .75.75v6a.75.75 0 0 1-1.5 0v-6a.75.75 0 0 1 .75-.75Z"/></svg>
                                                    </button>
                                                </form>
                                                @endif

                                                @if(Auth::user()->role === 'admin' && $dudi->deleted_at)
                                                <form action="{{ route('dudis.restore', $dudi->id) }}" method="POST" class="inline" onsubmit="return confirm('Pulihkan DUDI ini?');">
                                                    @csrf
                                                    <button type="submit" class="text-emerald-700 hover:text-emerald-900" title="Pulihkan">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M12 6v6l4 2"/><path fill-rule="evenodd" d="M3 12a9 9 0 1 1 18 0 9 9 0 0 1-18 0Zm9-7.5a7.5 7.5 0 1 0 7.5 7.5A7.5 7.5 0 0 0 12 4.5Z" clip-rule="evenodd"/></svg>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 px-4 border-b border-gray-200 text-center">Tidak ada data DUDI</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $dudis->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>