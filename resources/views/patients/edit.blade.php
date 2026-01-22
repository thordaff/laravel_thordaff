@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Pasien</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('patients.update', $patient) }}" id="editForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_pasien" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control @error('nama_pasien') is-invalid @enderror" 
                                   id="nama_pasien" name="nama_pasien" 
                                   value="{{ old('nama_pasien', $patient->nama_pasien) }}" required>
                            @error('nama_pasien')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="3" required>{{ old('alamat', $patient->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="no_telepon" class="form-label">No Telepon</label>
                            <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" 
                                   id="no_telepon" name="no_telepon" 
                                   value="{{ old('no_telepon', $patient->no_telepon) }}" 
                                   pattern="[0-9]{10,15}" 
                                   maxlength="15" 
                                   title="Nomor telepon harus 10-15 digit angka" 
                                   required 
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            @error('no_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Hanya angka, 10-15 digit</small>
                        </div>

                        <div class="mb-3">
                            <label for="hospital_id" class="form-label">Rumah Sakit</label>
                            <select class="form-select @error('hospital_id') is-invalid @enderror" 
                                    id="hospital_id" name="hospital_id" required>
                                <option value="">Pilih Rumah Sakit</option>
                                @foreach($hospitals as $hospital)
                                    <option value="{{ $hospital->id }}" 
                                        {{ old('hospital_id', $patient->hospital_id) == $hospital->id ? 'selected' : '' }}>
                                        {{ $hospital->nama_rumah_sakit }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hospital_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Kembali</a>
                            <span id="submitBtnWrapper" data-bs-toggle="tooltip" data-bs-placement="top" 
                                  title="Lakukan perubahan terlebih dahulu">
                                <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                    Update
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