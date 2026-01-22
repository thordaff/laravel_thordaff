@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Detail Pasien</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Nama Pasien</th>
                            <td>{{ $patient->nama_pasien }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $patient->alamat }}</td>
                        </tr>
                        <tr>
                            <th>No Telepon</th>
                            <td>{{ $patient->no_telepon }}</td>
                        </tr>
                        <tr>
                            <th>Rumah Sakit</th>
                            <td>
                                <a href="{{ route('hospitals.show', $patient->hospital) }}">
                                    {{ $patient->hospital->nama_rumah_sakit }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat Pada</th>
                            <td>{{ $patient->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Diupdate Pada</th>
                            <td>{{ $patient->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('patients.index') }}" class="btn btn-secondary">Kembali</a>
                        <div>
                            <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warning">Edit</a>
                            <button type="button" class="btn btn-danger btn-delete" data-id="{{ $patient->id }}">Hapus</button>
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
const patientId = {{ $patient->id }};

$(document).ready(function() {
    deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    
    $('.btn-delete').click(function() {
        deleteModal.show();
    });
    
    $('#confirmDelete').click(function() {
        $.ajax({
            url: '/patients/' + patientId,
            type: 'DELETE',
            success: function(response) {
                deleteModal.hide();
                if(response.success) {
                    if (typeof showToast === 'function') {
                        showToast(response.message, 'success');
                    }
                    setTimeout(function() {
                        window.location.href = '/patients';
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