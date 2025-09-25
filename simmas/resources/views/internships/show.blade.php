@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Detail Magang</div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">DUDI</div>
                        <div class="col-md-8">{{ $internship->dudi->name }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Siswa</div>
                        <div class="col-md-8">{{ $internship->student->name }} ({{ $internship->student->nis_nip }})</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Guru Pembimbing</div>
                        <div class="col-md-8">{{ $internship->teacher->name }} ({{ $internship->teacher->nis_nip }})</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Tanggal Mulai</div>
                        <div class="col-md-8">{{ \Carbon\Carbon::parse($internship->start_date)->format('d/m/Y') }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Tanggal Selesai</div>
                        <div class="col-md-8">{{ \Carbon\Carbon::parse($internship->end_date)->format('d/m/Y') }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Deskripsi</div>
                        <div class="col-md-8">{{ $internship->description ?? '-' }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status</div>
                        <div class="col-md-8">
                            @if($internship->status == 'Pending')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif($internship->status == 'Aktif')
                                <span class="badge bg-success">Aktif</span>
                            @elseif($internship->status == 'Selesai')
                                <span class="badge bg-primary">Selesai</span>
                            @elseif($internship->status == 'Ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h5 class="mt-4 mb-3">Jurnal Harian</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kegiatan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($internship->journals as $index => $journal)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($journal->date)->format('d/m/Y') }}</td>
                                        <td>{{ Str::limit($journal->description, 100) }}</td>
                                        <td>
                                            @if($journal->status == 'Menunggu Verifikasi')
                                                <span class="badge bg-warning">Menunggu</span>
                                            @elseif($journal->status == 'Disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($journal->status == 'Ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('journals.show', $journal->id) }}" class="btn btn-info btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data jurnal</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('internships.edit', $internship->id) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('internships.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection