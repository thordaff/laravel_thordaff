@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold text-dark"><i class="bi bi-hospital me-2"></i>Data Rumah Sakit</h2>
            <p class="text-muted">Kelola data rumah sakit</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient text-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Daftar Rumah Sakit</h5>
                    <a href="{{ route('hospitals.create') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Baru
                    </a>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="50">No</th>
                                    <th><i class="bi bi-hospital me-1"></i>Nama Rumah Sakit</th>
                                    <th><i class="bi bi-geo-alt me-1"></i>Alamat</th>
                                    <th><i class="bi bi-envelope me-1"></i>Email</th>
                                    <th><i class="bi bi-telephone me-1"></i>Telepon</th>
                                    <th class="text-center" width="250">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($hospitals as $index => $hospital)
                                <tr id="hospital-{{ $hospital->id }}">
                                    <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                    <td class="fw-semibold">{{ $hospital->nama_rumah_sakit }}</td>
                                    <td class="text-muted">{{ $hospital->alamat }}</td>
                                    <td><a href="mailto:{{ $hospital->email }}" class="text-decoration-none">{{ $hospital->email }}</a></td>
                                    <td><a href="tel:{{ $hospital->telepon }}" class="text-decoration-none">{{ $hospital->telepon }}</a></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('hospitals.show', $hospital) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('hospitals.edit', $hospital) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="{{ $hospital->id }}" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                        <p class="mb-0">Belum ada data rumah sakit</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
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
                        $('#hospital-' + hospitalId).fadeOut(300, function() {
                            $(this).remove();
                        });
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat menghapus data');
                }
            });
        }
    });
});
</script>
@endpush