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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="bi bi-trash display-1 text-danger mb-3"></i>
                <h5>Apakah Anda yakin ingin menghapus data ini?</h5>
                <p class="text-muted mb-0">Data yang dihapus tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </button>
                <button type="button" class="btn btn-danger" id="confirmDelete">
                    <i class="bi bi-trash me-1"></i>Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let deleteModal = null;
const hospitalId = {{ $hospital->id }};

$(document).ready(function() {
    deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    
    $('.btn-delete').click(function() {
        deleteModal.show();
    });
    
    $('#confirmDelete').click(function() {
        $.ajax({
            url: '/hospitals/' + hospitalId,
            type: 'DELETE',
            success: function(response) {
                deleteModal.hide();
                if(response.success) {
                    if (typeof showToast === 'function') {
                        showToast(response.message, 'success');
                    }
                    setTimeout(function() {
                        window.location.href = '/hospitals';
                    }, 1000);
                }
            },
            error: function(xhr) {
                deleteModal.hide();
                if (typeof showToast === 'function') {
                    showToast('Terjadi kesalahan saat menghapus data', 'error');
                }
            }
        });
    });
});
</script>
@endpush