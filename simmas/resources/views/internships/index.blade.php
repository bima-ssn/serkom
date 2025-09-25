@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Manajemen Magang</span>
                    <a href="{{ route('internships.create') }}" class="btn btn-primary btn-sm">Tambah Magang</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Siswa</th>
                                    <th>DUDI</th>
                                    <th>Guru Pembimbing</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($internships as $index => $internship)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $internship->student->name }}</td>
                                        <td>{{ $internship->dudi->name }}</td>
                                        <td>{{ $internship->teacher->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($internship->start_date)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($internship->end_date)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($internship->status == 'Pending')
                                                <span class="badge bg-warning">Menunggu</span>
                                            @elseif($internship->status == 'Aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @elseif($internship->status == 'Selesai')
                                                <span class="badge bg-primary">Selesai</span>
                                            @elseif($internship->status == 'Ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('internships.show', $internship->id) }}" class="btn btn-info btn-sm">Detail</a>
                                            <a href="{{ route('internships.edit', $internship->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('internships.destroy', $internship->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data magang</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection