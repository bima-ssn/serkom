@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Detail Jurnal Harian</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Siswa</div>
                        <div class="col-md-8">{{ $journal->internship->student->name }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">DUDI</div>
                        <div class="col-md-8">{{ $journal->internship->dudi->name }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Guru Pembimbing</div>
                        <div class="col-md-8">{{ $journal->internship->teacher->name }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Tanggal</div>
                        <div class="col-md-8">{{ \Carbon\Carbon::parse($journal->date)->format('d/m/Y') }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Kegiatan</div>
                        <div class="col-md-8">{{ $journal->description }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status</div>
                        <div class="col-md-8">
                            @if($journal->status == 'Menunggu Verifikasi')
                                <span class="badge bg-warning">Menunggu Verifikasi</span>
                            @elseif($journal->status == 'Disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($journal->status == 'Ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($journal->teacher_notes)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Catatan Guru</div>
                        <div class="col-md-8">{{ $journal->teacher_notes }}</div>
                    </div>
                    @endif
                    
                    @if($journal->documentation_path)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Dokumentasi</div>
                        <div class="col-md-8">
                            <img src="{{ asset('storage/' . $journal->documentation_path) }}" alt="Dokumentasi" class="img-fluid" style="max-height: 300px;">
                        </div>
                    </div>
                    @endif
                    
                    @if(auth()->user()->role === 'guru' && $journal->status === 'Menunggu Verifikasi')
                    <hr>
                    <h5 class="mt-4 mb-3">Verifikasi Jurnal</h5>
                    <form method="POST" action="{{ route('journals.verify', $journal->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="Disetujui">Disetujui</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="teacher_notes" class="form-label">Catatan</label>
                            <textarea class="form-control @error('teacher_notes') is-invalid @enderror" id="teacher_notes" name="teacher_notes" rows="3">{{ old('teacher_notes') }}</textarea>
                            @error('teacher_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Simpan Verifikasi</button>
                    </form>
                    @endif
                    
                    <div class="mt-4">
                        <a href="{{ route('journals.edit', $journal->id) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('journals.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection