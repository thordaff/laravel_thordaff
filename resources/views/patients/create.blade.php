@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('patients.index') }}" class="text-decoration-none">Pasien</a></li>
                    <li class="breadcrumb-item active">Tambah Baru</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Pasien</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('patients.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="nama_pasien" class="form-label fw-semibold">
                                <i class="bi bi-person me-1"></i>Nama Pasien <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama_pasien') is-invalid @enderror" 
                                   id="nama_pasien" name="nama_pasien" value="{{ old('nama_pasien') }}" 
                                   placeholder="Masukkan nama pasien" required>
                            @error('nama_pasien')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="alamat" class="form-label fw-semibold">
                                <i class="bi bi-geo-alt me-1"></i>Alamat <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="3" 
                                      placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="no_telepon" class="form-label fw-semibold">
                                <i class="bi bi-telephone me-1"></i>No Telepon <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" 
                                   id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" 
                                   placeholder="08XXXXXXXXXX" 
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

                        <div class="mb-4">
                            <label for="hospital_id" class="form-label fw-semibold">
                                <i class="bi bi-hospital me-1"></i>Rumah Sakit <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('hospital_id') is-invalid @enderror" 
                                    id="hospital_id" name="hospital_id" required>
                                <option value="">Pilih Rumah Sakit</option>
                                @foreach($hospitals as $hospital)
                                    <option value="{{ $hospital->id }}" {{ old('hospital_id') == $hospital->id ? 'selected' : '' }}>
                                        {{ $hospital->nama_rumah_sakit }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hospital_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection