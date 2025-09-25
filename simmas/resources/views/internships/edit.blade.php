@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Data Magang</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('internships.update', $internship->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="dudi_id" class="col-md-4 col-form-label text-md-end">DUDI</label>
                            <div class="col-md-6">
                                <select id="dudi_id" class="form-select @error('dudi_id') is-invalid @enderror" name="dudi_id" required>
                                    <option value="">Pilih DUDI</option>
                                    @foreach($dudis as $dudi)
                                        <option value="{{ $dudi->id }}" {{ (old('dudi_id', $internship->dudi_id) == $dudi->id) ? 'selected' : '' }}>{{ $dudi->name }}</option>
                                    @endforeach
                                </select>
                                @error('dudi_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="student_id" class="col-md-4 col-form-label text-md-end">Siswa</label>
                            <div class="col-md-6">
                                <select id="student_id" class="form-select @error('student_id') is-invalid @enderror" name="student_id" required>
                                    <option value="">Pilih Siswa</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ (old('student_id', $internship->student_id) == $student->id) ? 'selected' : '' }}>{{ $student->name }} ({{ $student->nis_nip }})</option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="teacher_id" class="col-md-4 col-form-label text-md-end">Guru Pembimbing</label>
                            <div class="col-md-6">
                                <select id="teacher_id" class="form-select @error('teacher_id') is-invalid @enderror" name="teacher_id" required>
                                    <option value="">Pilih Guru</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ (old('teacher_id', $internship->teacher_id) == $teacher->id) ? 'selected' : '' }}>{{ $teacher->name }} ({{ $teacher->nis_nip }})</option>
                                    @endforeach
                                </select>
                                @error('teacher_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="start_date" class="col-md-4 col-form-label text-md-end">Tanggal Mulai</label>
                            <div class="col-md-6">
                                <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', $internship->start_date) }}" required>
                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="end_date" class="col-md-4 col-form-label text-md-end">Tanggal Selesai</label>
                            <div class="col-md-6">
                                <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date', $internship->end_date) }}" required>
                                @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">Deskripsi</label>
                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $internship->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="status" class="col-md-4 col-form-label text-md-end">Status</label>
                            <div class="col-md-6">
                                <select id="status" class="form-select @error('status') is-invalid @enderror" name="status" required>
                                    <option value="Pending" {{ (old('status', $internship->status) == 'Pending') ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Aktif" {{ (old('status', $internship->status) == 'Aktif') ? 'selected' : '' }}>Aktif</option>
                                    <option value="Selesai" {{ (old('status', $internship->status) == 'Selesai') ? 'selected' : '' }}>Selesai</option>
                                    <option value="Ditolak" {{ (old('status', $internship->status) == 'Ditolak') ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('internships.index') }}" class="btn btn-secondary">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection