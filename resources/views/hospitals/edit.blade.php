@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Rumah Sakit</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('hospitals.update', $hospital) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_rumah_sakit" class="form-label">Nama Rumah Sakit</label>
                            <input type="text" class="form-control @error('nama_rumah_sakit') is-invalid @enderror" 
                                   id="nama_rumah_sakit" name="nama_rumah_sakit" 
                                   value="{{ old('nama_rumah_sakit', $hospital->nama_rumah_sakit) }}" required>
                            @error('nama_rumah_sakit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="3" required>{{ old('alamat', $hospital->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" 
                                   value="{{ old('email', $hospital->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                   id="telepon" name="telepon" 
                                   value="{{ old('telepon', $hospital->telepon) }}" required>
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('hospitals.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection