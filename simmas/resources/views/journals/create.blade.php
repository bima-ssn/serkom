@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Modal-style Container -->
            <div class="modal-style-container">
                <!-- Header dengan Background -->
                <div class="modal-header-bg">
                    <div class="text-center text-white py-5">
                        <h1 class="h2 fw-bold mb-2">Tambah Jurnal Harian</h1>
                        <p class="mb-0 opacity-75">Dokumentasikan kegiatan magang harian Anda</p>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="modal-content-area">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <!-- Panduan Section -->
                            <div class="guidance-card mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="guidance-icon">
                                        <i class="fas fa-lightbulb"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-semibold text-primary mb-2">Panduan Penulisan Jurnal</h6>
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center">
                                                    <span class="bullet-point"></span>
                                                    <small>Minimal 50 karakter untuk deskripsi kegiatan</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center">
                                                    <span class="bullet-point"></span>
                                                    <small>Deskripsikan kegiatan dengan jelas dan spesifik</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center">
                                                    <span class="bullet-point"></span>
                                                    <small>Sertakan kendala yang dihadapi (jika ada)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center">
                                                    <span class="bullet-point"></span>
                                                    <small>Upload dokumentasi pendukung</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center">
                                                    <span class="bullet-point"></span>
                                                    <small>Pastikan tanggal sesuai dengan hari kerja</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('journals.store') }}" enctype="multipart/form-data">
                                @csrf

                                <!-- Informasi Dasar Card -->
                                <div class="card info-card mb-4">
                                    <div class="card-body">
                                        <h6 class="card-title fw-semibold text-gray-700 mb-3">Informasi Dasar</h6>
                                        <div class="row g-3">
                                            <!-- Pilih Magang (jika lebih dari satu) -->
                                            @if(isset($internships) && count($internships) > 1)
                                            <div class="col-md-12">
                                                <div class="info-field">
                                                    <label class="info-label">Magang <span class="text-danger">*</span></label>
                                                    <select class="form-select @error('internship_id') is-invalid @enderror" id="internship_id" name="internship_id" required>
                                                        <option value="">Pilih Magang</option>
                                                        @foreach ($internships as $internship)
                                                            <option value="{{ $internship->id }}" {{ old('internship_id') == $internship->id ? 'selected' : '' }}>
                                                                {{ $internship->student->name }} - {{ $internship->dudi->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('internship_id')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            @elseif(isset($internships) && count($internships) === 1)
                                                <input type="hidden" name="internship_id" value="{{ $internships->first()->id }}">
                                            @endif
                                            <div class="col-md-6">
                                                <div class="info-field">
                                                    <label class="info-label">Tanggal <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                                    @error('date')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-field">
                                                    <label class="info-label">Status</label>
                                                    <div class="info-value">
                                                        <span class="status-badge waiting">
                                                            <i class="fas fa-clock me-1"></i>
                                                            Menunggu Verifikasi
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kegiatan Harian Card -->
                                <div class="card activity-card mb-4">
                                    <div class="card-body">
                                        <h6 class="card-title fw-semibold text-gray-700 mb-3">Kegiatan Harian</h6>
                                        
                                        <div class="activity-field">
                                            <label class="activity-label">
                                                Deskripsi kegiatan <span class="text-danger">*</span>
                                            </label>
                                            <p class="activity-hint">
                                                Deskripsikan kegiatan yang Anda lakukan hari ini secara jelas. 
                                                <strong>Contoh:</strong> Membuat wireframe untuk halaman login menggunakan Figma, 
                                                kemudian melakukan coding HTML dan CSS untuk implementasi screen tersebut...
                                            </p>
                                            
                                            <div class="textarea-container">
                                                <textarea class="form-control activity-textarea @error('description') is-invalid @enderror" 
                                                          id="description" 
                                                          name="description" 
                                                          rows="6" minlength="50"
                                                          placeholder="Tuliskan detail kegiatan magang Anda hari ini..."
                                                          required>{{ old('description') }}</textarea>
                                                <div class="textarea-footer">
                                                    <div class="char-counter">
                                                        <span id="charCount">0</span>/50 karakter
                                                    </div>
                                                </div>
                                            </div>
                                            @error('description')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Dokumentasi Card -->
                                <div class="card documentation-card mb-4">
                                    <div class="card-body">
                                        <h6 class="card-title fw-semibold text-gray-700 mb-3">Dokumentasi Pendukung</h6>
                                        
                                        <div class="upload-area">
                                            <div class="upload-header">
                                                <label class="upload-label">Upload file (Optional)</label>
                                                <p class="upload-subtitle">File yang dapat diupload: screenshot hasil kerja, dokumentasi code, foto kegiatan</p>
                                            </div>
                                            
                                            <div class="file-input-wrapper">
                                                <input type="file" 
                                                       class="form-control file-input @error('documentation') is-invalid @enderror" 
                                                       id="documentation" 
                                                       name="documentation"
                                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                                <div class="file-input-overlay">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                    <span>Pilih file dokumentasi</span>
                                                </div>
                                            </div>
                                            
                                            @error('documentation')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                            
                                            <div class="file-info mt-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="file-info-item">
                                                            <i class="fas fa-file-alt me-2"></i>
                                                            <span>Format: PDF, DOC, DOCX, JPG, PNG</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="file-info-item">
                                                            <i class="fas fa-weight-hanging me-2"></i>
                                                            <span>Maksimal: 2 MB</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Validation Alert -->
                                <div class="alert validation-alert mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="alert-icon">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="alert-title mb-2">Lengkapi form terlebih dahulu:</h6>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-circle me-2"></i>
                                                        <small>Pilih tanggal yang valid</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-circle me-2"></i>
                                                        <small>Deskripsi kegiatan minimal 50 karakter</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="action-buttons">
                                    <a href="{{ route('journals.index') }}" class="btn btn-cancel">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Batal
                                    </a>
                                    <button type="submit" class="btn btn-submit" id="submitBtn" disabled>
                                        <i class="fas fa-save me-2"></i>
                                        Simpan Jurnal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.modal-style-container {
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin: 20px auto;
    max-width: 1200px;
}

.modal-header-bg {
    background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);
    position: relative;
}

.modal-header-bg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.1"><path d="M500 50Q600 0 700 50t200 0v50H0V50q100-50 200-50T500 50z"/></svg>') bottom center/cover no-repeat;
}

.modal-content-area {
    padding: 40px 0;
}

.guidance-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 1px solid #e3e6f0;
    border-radius: 12px;
    padding: 24px;
}

.guidance-icon {
    background: #0dcaf0;
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 16px;
    flex-shrink: 0;
}

.bullet-point {
    width: 6px;
    height: 6px;
    background: #6c757d;
    border-radius: 50%;
    margin-right: 8px;
    flex-shrink: 0;
}

.card {
    border: 1px solid #e3e6f0;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.card-body {
    padding: 28px;
}

.info-field {
    background: #f8f9fa;
    border: 1px solid #e3e6f0;
    border-radius: 8px;
    padding: 16px;
}

.info-label {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
    margin-bottom: 4px;
    display: block;
}

.info-value {
    font-weight: 600;
    color: #2d3748;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.status-badge.waiting {
    background: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.activity-field {
    position: relative;
}

.activity-label {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 8px;
    display: block;
}

.activity-hint {
    color: #6c757d;
    font-size: 0.875rem;
    line-height: 1.5;
    margin-bottom: 16px;
    background: #f8f9fa;
    padding: 12px;
    border-radius: 8px;
    border-left: 4px solid #0dcaf0;
}

.textarea-container {
    position: relative;
}

.activity-textarea {
    border-radius: 8px;
    border: 2px solid #e3e6f0;
    padding: 16px;
    font-size: 0.95rem;
    line-height: 1.5;
    resize: vertical;
    transition: all 0.3s ease;
}

.activity-textarea:focus {
    border-color: #0dcaf0;
    box-shadow: 0 0 0 3px rgba(13, 202, 240, 0.1);
}

.textarea-footer {
    display: flex;
    justify-content: flex-end;
    margin-top: 8px;
}

.char-counter {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
}

.upload-area {
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    padding: 24px;
    text-align: center;
}

.upload-header {
    margin-bottom: 20px;
}

.upload-label {
    font-weight: 600;
    color: #2d3748;
    display: block;
    margin-bottom: 4px;
}

.upload-subtitle {
    color: #6c757d;
    font-size: 0.875rem;
    margin: 0;
}

.file-input-wrapper {
    position: relative;
    max-width: 400px;
    margin: 0 auto;
}

.file-input {
    position: relative;
    z-index: 2;
    opacity: 0;
    height: 60px;
    cursor: pointer;
}

.file-input-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: white;
    border: 2px dashed #0dcaf0;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0dcaf0;
    font-weight: 500;
    transition: all 0.3s ease;
    z-index: 1;
}

.file-input:hover + .file-input-overlay {
    background: #f0fdff;
    border-color: #0bb3d6;
}

.file-info {
    background: white;
    border-radius: 8px;
    padding: 16px;
}

.file-info-item {
    display: flex;
    align-items: center;
    color: #6c757d;
    font-size: 0.875rem;
}

.validation-alert {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 12px;
    padding: 20px;
    border-left: 4px solid #ffc107;
}

.alert-icon {
    color: #856404;
    font-size: 1.25rem;
    margin-right: 16px;
}

.alert-title {
    color: #856404;
    font-size: 0.95rem;
    font-weight: 600;
}

.action-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 24px;
    border-top: 1px solid #e3e6f0;
}

.btn {
    padding: 12px 32px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.btn-cancel {
    background: white;
    color: #6c757d;
    border-color: #dee2e6;
}

.btn-cancel:hover {
    background: #f8f9fa;
    border-color: #adb5bd;
    color: #495057;
}

.btn-submit {
    background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);
    color: white;
    border: none;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(13, 202, 240, 0.4);
}

/* Responsive Design */
@media (max-width: 768px) {
    .modal-content-area {
        padding: 20px 0;
    }
    
    .card-body {
        padding: 20px;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 12px;
    }
    
    .btn {
        width: 100%;
    }
    
    .guidance-card .row {
        flex-direction: column;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const descriptionTextarea = document.getElementById('description');
    const charCount = document.getElementById('charCount');
    const submitBtn = document.getElementById('submitBtn');
    const dateInput = document.getElementById('date');
    const fileInput = document.getElementById('documentation');
    const fileInputOverlay = document.querySelector('.file-input-overlay');

    // Character counter
    function updateCharCount() {
        const count = descriptionTextarea.value.length;
        charCount.textContent = count;
        
        if (count < 50) {
            charCount.style.color = '#dc3545';
        } else {
            charCount.style.color = '#198754';
        }

        validateForm();
    }

    descriptionTextarea.addEventListener('input', updateCharCount);
    updateCharCount();

    // File input interaction
    fileInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            fileInputOverlay.innerHTML = `
                <i class="fas fa-file-check me-2"></i>
                <span>${this.files[0].name}</span>
            `;
            fileInputOverlay.style.borderColor = '#198754';
            fileInputOverlay.style.color = '#198754';
        }
    });

    function validateForm() {
        const enoughChars = descriptionTextarea.value.length >= 50;
        const hasDate = !!dateInput.value;
        submitBtn.disabled = !(enoughChars && hasDate);
    }

    dateInput.addEventListener('change', validateForm);
    validateForm();

    // Add animation on load
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('animate-in');
    });
});
</script>
@endsection