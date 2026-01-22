@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('hospitals.index') }}" class="text-decoration-none">Rumah Sakit</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Detail Rumah Sakit</h5>
                </div>
                <div class="card-body p-4">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200" class="text-muted"><i class="bi bi-hospital me-2"></i>Nama Rumah Sakit</th>
                            <td class="fw-semibold">{{ $hospital->nama_rumah_sakit }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted"><i class="bi bi-geo-alt me-2"></i>Alamat</th>
                            <td>{{ $hospital->alamat }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted"><i class="bi bi-envelope me-2"></i>Email</th>
                            <td><a href="mailto:{{ $hospital->email }}" class="text-decoration-none">{{ $hospital->email }}</a></td>
                        </tr>
                        <tr>
                            <th class="text-muted"><i class="bi bi-telephone me-2"></i>Telepon</th>
                            <td><a href="tel:{{ $hospital->telepon }}" class="text-decoration-none">{{ $hospital->telepon }}</a></td>
                        </tr>
                        <tr>
                            <th class="text-muted"><i class="bi bi-calendar-plus me-2"></i>Dibuat Pada</th>
                            <td>{{ $hospital->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted"><i class="bi bi-calendar-check me-2"></i>Diupdate Pada</th>
                            <td>{{ $hospital->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('hospitals.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                        <div>
                            <a href="{{ route('hospitals.edit', $hospital) }}" class="btn btn-warning">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                            <button type="button" class="btn btn-danger btn-delete" data-id="{{ $hospital->id }}">
                                <i class="bi bi-trash me-1"></i>Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.btn-delete').click(function() {
        const hospitalId = $(this).data('id');
        
        if(confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                url: '/hospitals/' + hospitalId,
                type: 'DELETE',
                success: function(response) {
                    if(response.success) {
                        showToast(response.message, 'success');
                        setTimeout(function() {
                            window.location.href = '/hospitals';
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    showToast('Terjadi kesalahan saat menghapus data', 'error');
                }
            });
        }
    });
});
</script>
@endpush