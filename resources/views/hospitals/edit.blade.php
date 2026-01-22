@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('hospitals.index') }}" class="text-decoration-none">Rumah Sakit</a></li>
                    <li class="breadcrumb-item active">Edit Data</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Rumah Sakit</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('hospitals.update', $hospital) }}" id="editForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nama_rumah_sakit" class="form-label fw-semibold">
                                <i class="bi bi-hospital me-1"></i>Nama Rumah Sakit <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama_rumah_sakit') is-invalid @enderror" 
                                   id="nama_rumah_sakit" name="nama_rumah_sakit" 
                                   value="{{ old('nama_rumah_sakit', $hospital->nama_rumah_sakit) }}" required>
                            @error('nama_rumah_sakit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="alamat" class="form-label fw-semibold">
                                <i class="bi bi-geo-alt me-1"></i>Alamat <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="3" required>{{ old('alamat', $hospital->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-1"></i>Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" 
                                   value="{{ old('email', $hospital->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="telepon" class="form-label fw-semibold">
                                <i class="bi bi-telephone me-1"></i>Telepon <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                   id="telepon" name="telepon" 
                                   value="{{ old('telepon', $hospital->telepon) }}" 
                                   pattern="[0-9]{10,15}" 
                                   maxlength="15" 
                                   title="Nomor telepon harus 10-15 digit angka" 
                                   required 
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Hanya angka, 10-15 digit</small>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('hospitals.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Kembali
                            </a>
                            <span id="submitBtnWrapper" data-bs-toggle="tooltip" data-bs-placement="top" 
                                  title="Lakukan perubahan terlebih dahulu">
                                <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                    <i class="bi bi-check-circle me-1"></i>Update Data
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    const submitBtn = $('#submitBtn');
    const submitBtnWrapper = $('#submitBtnWrapper');
    const form = $('#editForm');
    const originalValues = {};
    
    const tooltip = new bootstrap.Tooltip(submitBtnWrapper[0], {
        title: 'Lakukan perubahan terlebih dahulu',
        placement: 'top'
    });
    
    // Original values
    form.find('input, textarea, select').each(function() {
        const field = $(this);
        originalValues[field.attr('name')] = field.val();
    });
    
    // Check for changes
    function checkChanges() {
        let hasChanges = false;
        
        form.find('input, textarea, select').each(function() {
            const field = $(this);
            const fieldName = field.attr('name');
            
            if (fieldName && fieldName !== '_token' && fieldName !== '_method') {
                if (field.val() !== originalValues[fieldName]) {
                    hasChanges = true;
                    return false;
                }
            }
        });
        
        if (hasChanges) {
            submitBtn.prop('disabled', false);
            submitBtnWrapper.css('cursor', 'pointer');
            tooltip.disable();
        } else {
            submitBtn.prop('disabled', true);
            submitBtnWrapper.css('cursor', 'not-allowed');
            tooltip.enable();
        }
    }
    
    // Listen to changes
    form.find('input, textarea, select').on('input change', function() {
        checkChanges();
    });
});
</script>
@endpush
@endsection