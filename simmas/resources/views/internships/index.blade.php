<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Manajemen Magang') }}</h2>
                <x-breadcrumbs :items="[
                    ['label' => 'Dashboard', 'href' => route('dashboard')],
                    ['label' => 'Magang']
                ]" />
            </div>
            @if(Auth::user()->role == 'guru')
            <a href="{{ route('internships.create') }}" class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Tambah Magang</a>
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
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Siswa</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">DUDI</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Guru Pembimbing</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Mulai</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Selesai</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($internships as $index => $internship)
                                    <tr class="odd:bg-white even:bg-gray-50">
                                        <td class="py-2 px-4 border-b border-gray-200">{{ $index + 1 }}</td>
                                        <td class="py-2 px-4 border-b border-gray-200">{{ $internship->student->name }}</td>
                                        <td class="py-2 px-4 border-b border-gray-200">{{ $internship->dudi->name }}</td>
                                        <td class="py-2 px-4 border-b border-gray-200">{{ $internship->teacher->name }}</td>
                                        <td class="py-2 px-4 border-b border-gray-200">{{ \Carbon\Carbon::parse($internship->start_date)->format('d/m/Y') }}</td>
                                        <td class="py-2 px-4 border-b border-gray-200">{{ \Carbon\Carbon::parse($internship->end_date)->format('d/m/Y') }}</td>
                                        <td class="py-2 px-4 border-b border-gray-200">
                                            @php
                                                $statusRaw = $internship->status ?? '';
                                                $statusLower = strtolower($statusRaw);
                                                $badgeClass = 'bg-gray-100 text-gray-800';
                                                $label = $statusRaw;

                                                if (in_array($statusLower, ['pending', 'menunggu'])) {
                                                    $badgeClass = 'bg-yellow-100 text-yellow-800';
                                                    $label = 'Menunggu';
                                                } elseif (in_array($statusLower, ['aktif', 'active'])) {
                                                    $badgeClass = 'bg-green-100 text-green-800';
                                                    $label = 'Aktif';
                                                } elseif (in_array($statusLower, ['selesai', 'completed'])) {
                                                    $badgeClass = 'bg-blue-100 text-blue-800';
                                                    $label = 'Selesai';
                                                } elseif (in_array($statusLower, ['ditolak', 'cancelled', 'dibatalkan'])) {
                                                    $badgeClass = 'bg-red-100 text-red-800';
                                                    $label = 'Ditolak';
                                                }
                                            @endphp
                                            @if(!empty($statusRaw))
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">{{ $label }}</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">-</span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b border-gray-200">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('internships.show', $internship->id) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                                <a href="{{ route('internships.edit', $internship->id) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                                <form action="{{ route('internships.destroy', $internship->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-8 px-4 border-b border-gray-200">
                                            @if(Auth::user()->role == 'guru')
                                            <x-empty-state title="Belum ada data magang" actionHref="{{ route('internships.create') }}" actionLabel="Tambah Magang" />
                                            @else
                                            <x-empty-state title="Belum ada data magang" />
                                            @endif
                                        </td>
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