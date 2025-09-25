@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar Jurnal Harian</span>
                    <a href="{{ route('journals.create') }}" class="btn btn-primary btn-sm">Tambah Jurnal</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Magang</th>
                                    <th>Kegiatan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($journals as $index => $journal)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($journal->date)->format('d/m/Y') }}</td>
                                        <td>{{ $journal->internship->student->name }} - {{ $journal->internship->dudi->name }}</td>
                                        <td>{{ Str::limit($journal->description, 100) }}</td>
                                        <td>
                                            @if($journal->status == 'Menunggu Verifikasi')
                                                <span class="badge bg-warning">Menunggu Verifikasi</span>
                                            @elseif($journal->status == 'Disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($journal->status == 'Ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('journals.show', $journal->id) }}" class="btn btn-info btn-sm">Detail</a>
                                            <a href="{{ route('journals.edit', $journal->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('journals.destroy', $journal->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus jurnal ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data jurnal</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $journals->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection