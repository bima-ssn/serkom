@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edit Jurnal Harian</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('journals.update', $journal->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="internship_id" class="form-label">Magang</label>
                            <select class="form-select @error('internship_id') is-invalid @enderror" id="internship_id" name="internship_id" required>
                                <option value="">Pilih Magang</option>
                                @foreach ($internships as $internship)
                                    <option value="{{ $internship->id }}" {{ old('internship_id', $journal->internship_id) == $internship->id ? 'selected' : '' }}>
                                        {{ $internship->student->name }} - {{ $internship->dudi->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('internship_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $journal->date->format('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Kegiatan</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', $journal->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="Menunggu Verifikasi" {{ old('status', $journal->status) == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="Disetujui" {{ old('status', $journal->status) == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="Ditolak" {{ old('status', $journal->status) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="teacher_notes" class="form-label">Catatan Guru</label>
                            <textarea class="form-control @error('teacher_notes') is-invalid @enderror" id="teacher_notes" name="teacher_notes" rows="3">{{ old('teacher_notes', $journal->teacher_notes) }}</textarea>
                            @error('teacher_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="documentation" class="form-label">Dokumentasi</label>
                            @if($journal->documentation_path)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $journal->documentation_path) }}" alt="Dokumentasi" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('documentation') is-invalid @enderror" id="documentation" name="documentation">
                            <small class="text-muted">Format: jpg, jpeg, png. Maksimal 2MB</small>
                            @error('documentation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('journals.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection