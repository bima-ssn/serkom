@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Tambah Jurnal Harian</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('journals.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="internship_id" class="form-label">Magang</label>
                            <select class="form-select @error('internship_id') is-invalid @enderror" id="internship_id" name="internship_id" required>
                                <option value="">Pilih Magang</option>
                                @foreach ($internships as $internship)
                                    <option value="{{ $internship->id }}" {{ old('internship_id') == $internship->id ? 'selected' : '' }}>
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
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Kegiatan</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="documentation" class="form-label">Dokumentasi (Opsional)</label>
                            <input type="file" class="form-control @error('documentation') is-invalid @enderror" id="documentation" name="documentation">
                            <small class="text-muted">Format: jpg, jpeg, png. Maksimal 2MB</small>
                            @error('documentation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('journals.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection