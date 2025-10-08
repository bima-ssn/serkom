@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header dengan Background -->
            <div class="header-journal mb-4">
                <div class="d-flex justify-content-between align-items-center text-white">
                    <div>
                        <h1 class="h2 mb-1">Detail Jurnal Harian</h1>
                        <p class="mb-0 opacity-75">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ \Carbon\Carbon::parse($journal->date)->format('l, j F Y') }}
                        </p>
                    </div>
                    <div class="status-badge">
                        @if($journal->status == 'Menunggu Verifikasi')
                            <span class="badge bg-warning">
                                <i class="bi bi-clock-history me-1"></i>Menunggu Verifikasi
                            </span>
                        @elseif($journal->status == 'Disetujui')
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>Disetujui
                            </span>
                        @elseif($journal->status == 'Ditolak')
                            <span class="badge bg-danger">
                                <i class="bi bi-x-circle me-1"></i>Ditolak
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Card Utama -->
            <div class="card journal-card">
                <div class="card-body p-4">
                    <!-- Informasi Siswa -->
                    <div class="info-section mb-4">
                        <div class="section-header mb-3">
                            <i class="bi bi-person-badge section-icon"></i>
                            <h5 class="section-title">Informasi Siswa</h5>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">Nama Siswa</div>
                                    <div class="info-value">{{ $journal->internship->student->name }}</div>
                                    <div class="info-meta">NIS: {{ $journal->internship->student->nis ?? '2024001' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">Kelas & Jurusan</div>
                                    <div class="info-value">{{ $journal->internship->student->class ?? 'XII RPL 1' }}</div>
                                    <div class="info-meta">Jurusan: {{ $journal->internship->student->major ?? 'Rekayasa Perangkat Lunak' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Garis Pemisah -->
                    <div class="divider my-4"></div>

                    <!-- Tempat Magang -->
                    <div class="info-section mb-4">
                        <div class="section-header mb-3">
                            <i class="bi bi-building section-icon"></i>
                            <h5 class="section-title">Tempat Magang</h5>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="info-item">
                                    <div class="info-label">Perusahaan</div>
                                    <div class="info-value">{{ $journal->internship->dudi->name }}</div>
                                    <div class="info-meta">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        {{ $journal->internship->dudi->address ?? 'JL HR Muhammad No. 123, Surabaya' }}
                                    </div>
                                    <div class="info-meta">
                                        <i class="bi bi-person me-1"></i>
                                        PIC: {{ $journal->internship->dudi->pic_name ?? 'Budi Santoso' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <div class="info-label">Guru Pembimbing</div>
                                    <div class="info-value text-primary">{{ $journal->internship->teacher->name }}</div>
                                    <div class="info-meta">Pembimbing Magang</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Garis Pemisah Tebal -->
                    <div class="divider-thick my-4"></div>

                    <!-- Kegiatan Hari Ini -->
                    <div class="activity-section mb-4">
                        <div class="section-header mb-3">
                            <i class="bi bi-journal-text section-icon"></i>
                            <h5 class="section-title">Kegiatan Hari Ini</h5>
                            <div class="date-badge">
                                <i class="bi bi-calendar-date me-1"></i>
                                {{ \Carbon\Carbon::parse($journal->date)->format('l, j F Y') }}
                            </div>
                        </div>
                        <div class="activity-content">
                            <div class="activity-text">
                                {{ $journal->description }}
                            </div>
                        </div>
                    </div>

                    <!-- Dokumentasi -->
                    @if($journal->documentation_path)
                    <div class="documentation-section mb-4">
                        <div class="section-header mb-3">
                            <i class="bi bi-image section-icon"></i>
                            <h5 class="section-title">Dokumentasi</h5>
                        </div>
                        <div class="documentation-item">
                            <div class="doc-preview">
                                <div class="doc-icon">
                                    <i class="bi bi-file-earmark-image"></i>
                                </div>
                                <div class="doc-info">
                                    <div class="doc-name">documentasi.jpg</div>
                                    <div class="doc-size">File dokumentasi kegiatan</div>
                                </div>
                            </div>
                            <div class="doc-actions">
                                <a href="{{ asset('storage/' . $journal->documentation_path) }}" 
                                   class="btn btn-download" 
                                   target="_blank">
                                    <i class="bi bi-eye me-1"></i>Lihat
                                </a>
                                <a href="{{ asset('storage/' . $journal->documentation_path) }}" 
                                   download 
                                   class="btn btn-primary">
                                    <i class="bi bi-download me-1"></i>Unduh
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Informasi Tambahan -->
                    <div class="meta-section">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                @if($journal->teacher_notes)
                                <div class="teacher-notes">
                                    <div class="notes-header">
                                        <i class="bi bi-chat-left-text me-2"></i>
                                        <strong>Catatan Guru:</strong>
                                    </div>
                                    <div class="notes-content">
                                        {{ $journal->teacher_notes }}
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="timeline-info text-md-end">
                                    <div class="timeline-item">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Dibuat: {{ \Carbon\Carbon::parse($journal->created_at)->format('j/n/Y') }}
                                    </div>
                                    <div class="timeline-item">
                                        <i class="bi bi-arrow-clockwise me-1"></i>
                                        Diperbarui: {{ \Carbon\Carbon::parse($journal->updated_at)->format('j/n/Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Verifikasi untuk Guru -->
                    @if(auth()->user()->role === 'guru' && $journal->status === 'Menunggu Verifikasi')
                    <div class="verification-section mt-4">
                        <div class="verification-header">
                            <i class="bi bi-patch-check me-2"></i>
                            <h5 class="mb-0">Verifikasi Jurnal</h5>
                        </div>
                        <div class="verification-body">
                            <form method="POST" action="{{ route('journals.verify', $journal->id) }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="status" class="form-label fw-semibold">Status Verifikasi</label>
                                        <select class="form-select form-select-lg @error('status') is-invalid @enderror" 
                                                id="status" 
                                                name="status" 
                                                required>
                                            <option value="">Pilih Status</option>
                                            <option value="Disetujui">Disetujui</option>
                                            <option value="Ditolak">Ditolak</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <label for="teacher_notes" class="form-label fw-semibold">Catatan untuk Siswa</label>
                                    <textarea class="form-control @error('teacher_notes') is-invalid @enderror" 
                                              id="teacher_notes" 
                                              name="teacher_notes" 
                                              rows="4" 
                                              placeholder="Berikan catatan, masukan, atau apresiasi untuk siswa...">{{ old('teacher_notes') }}</textarea>
                                    @error('teacher_notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="action-buttons mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-check-lg me-2"></i>Simpan Verifikasi
                                    </button>
                                    <a href="{{ route('journals.index') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-1"></i>Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    @else
                    <!-- Tombol Aksi -->
                    <div class="action-section mt-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('journals.index') }}" class="btn btn-back">
                                <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
                            </a>
                            <div class="action-buttons">
                                @if(auth()->user()->role === 'siswa')
                                    <a href="{{ route('journals.edit', $journal->id) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil me-2"></i>Edit Jurnal
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Header Styling */
.header-journal {
    background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(67, 97, 238, 0.3);
}

/* Card Styling */
.journal-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

/* Section Header */
.section-header {
    display: flex;
    align-items: center;
    gap: 12px;
}

.section-icon {
    font-size: 1.5rem;
    color: #4361ee;
    background: rgba(67, 97, 238, 0.1);
    padding: 10px;
    border-radius: 10px;
}

.section-title {
    color: #2b2d42;
    font-weight: 600;
    margin: 0;
    flex-grow: 1;
}

/* Info Item Styling */
.info-item {
    padding: 1rem;
    background: #f8f9ff;
    border-radius: 10px;
    border-left: 4px solid #4361ee;
}

.info-label {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
    margin-bottom: 4px;
}

.info-value {
    font-size: 1.125rem;
    color: #2b2d42;
    font-weight: 600;
    margin-bottom: 4px;
}

.info-meta {
    font-size: 0.875rem;
    color: #6c757d;
}

/* Divider */
.divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, #dee2e6, transparent);
}

.divider-thick {
    height: 3px;
    background: linear-gradient(90deg, transparent, #4361ee, transparent);
    opacity: 0.3;
}

/* Activity Section */
.activity-content {
    background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
}

.activity-text {
    line-height: 1.7;
    color: #495057;
    font-size: 1.05rem;
}

.date-badge {
    background: rgba(67, 97, 238, 0.1);
    color: #4361ee;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 500;
    font-size: 0.875rem;
}

/* Documentation */
.documentation-item {
    display: flex;
    align-items: center;
    justify-content: between;
    background: #f8f9ff;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.25rem;
    gap: 1rem;
}

.doc-preview {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-grow: 1;
}

.doc-icon {
    font-size: 2rem;
    color: #4361ee;
    background: rgba(67, 97, 238, 0.1);
    padding: 12px;
    border-radius: 10px;
}

.doc-info {
    flex-grow: 1;
}

.doc-name {
    font-weight: 600;
    color: #2b2d42;
    margin-bottom: 4px;
}

.doc-size {
    font-size: 0.875rem;
    color: #6c757d;
}

.doc-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-download {
    background: #6c757d;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-download:hover {
    background: #5a6268;
    color: white;
}

/* Teacher Notes */
.teacher-notes {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border: 1px solid #ffecb5;
    border-radius: 12px;
    padding: 1.25rem;
}

.notes-header {
    color: #856404;
    margin-bottom: 8px;
}

.notes-content {
    color: #664d03;
    line-height: 1.6;
}

/* Timeline Info */
.timeline-info {
    color: #6c757d;
    font-size: 0.875rem;
}

.timeline-item {
    margin-bottom: 6px;
}

/* Verification Section */
.verification-section {
    background: linear-gradient(135deg, #fff9db 0%, #fff3cd 100%);
    border: 2px solid #ffeaa7;
    border-radius: 15px;
    overflow: hidden;
}

.verification-header {
    background: #ffd43b;
    color: #664d03;
    padding: 1rem 1.5rem;
    font-weight: 600;
}

.verification-body {
    padding: 1.5rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.btn-back {
    background: #6c757d;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: #5a6268;
    color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-journal {
        padding: 1.5rem;
    }
    
    .documentation-item {
        flex-direction: column;
        text-align: center;
    }
    
    .doc-actions {
        justify-content: center;
    }
    
    .action-buttons {
        flex-direction: column;
        width: 100%;
    }
    
    .action-buttons .btn {
        width: 100%;
    }
}

/* Animation */
.journal-card {
    animation: slideUp 0.5s ease-out;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection