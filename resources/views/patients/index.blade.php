@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold text-dark"><i class="bi bi-person-heart me-2"></i>Data Pasien</h2>
            <p class="text-muted">Kelola data pasien rumah sakit</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient text-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Daftar Pasien</h5>
                    <a href="{{ route('patients.create') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Baru
                    </a>
                </div>
                <div class="card-body p-4">
                    <!-- Filter Dropdown -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="hospital_filter" class="form-label fw-semibold">
                                <i class="bi bi-funnel me-1"></i>Filter berdasarkan Rumah Sakit:
                            </label>
                            <select class="form-select" id="hospital_filter">
                                <option value="">Semua Rumah Sakit</option>
                                @foreach($hospitals as $hospital)
                                    <option value="{{ $hospital->id }}">{{ $hospital->nama_rumah_sakit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="50">No</th>
                                    <th><i class="bi bi-person me-1"></i>Nama Pasien</th>
                                    <th><i class="bi bi-geo-alt me-1"></i>Alamat</th>
                                    <th><i class="bi bi-telephone me-1"></i>No Telepon</th>
                                    <th><i class="bi bi-hospital me-1"></i>Rumah Sakit</th>
                                    <th class="text-center" width="250">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="patients-table-body">
                                @forelse($patients as $index => $patient)
                                <tr id="patient-{{ $patient->id }}">
                                    <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                    <td class="fw-semibold">{{ $patient->nama_pasien }}</td>
                                    <td class="text-muted">{{ $patient->alamat }}</td>
                                    <td><a href="tel:{{ $patient->no_telepon }}" class="text-decoration-none">{{ $patient->no_telepon }}</a></td>
                                    <td><span class="badge bg-primary">{{ $patient->hospital->nama_rumah_sakit }}</span></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('patients.show', $patient) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('patients.edit', $patient) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="{{ $patient->id }}" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                        <p class="mb-0">Belum ada data pasien</p>
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
    // Filter AJAX
    $('#hospital_filter').change(function() {
        const hospitalId = $(this).val();
        
        $.ajax({
            url: '/patients',
            type: 'GET',
            data: {
                hospital_id: hospitalId
            },
            success: function(response) {
                let html = '';
                if(response.data.length > 0) {
                    response.data.forEach(function(patient, index) {
                        html += `
                            <tr id="patient-${patient.id}">
                                <td class="text-center fw-bold">${index + 1}</td>
                                <td class="fw-semibold">${patient.nama_pasien}</td>
                                <td class="text-muted">${patient.alamat}</td>
                                <td><a href="tel:${patient.no_telepon}" class="text-decoration-none">${patient.no_telepon}</a></td>
                                <td><span class="badge bg-primary">${patient.hospital.nama_rumah_sakit}</span></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="/patients/${patient.id}" class="btn btn-sm btn-outline-info" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/patients/${patient.id}/edit" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="${patient.id}" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = '<tr><td colspan="6" class="text-center py-5 text-muted"><i class="bi bi-inbox display-4 d-block mb-3"></i><p class="mb-0">Tidak ada data pasien</p></td></tr>';
                }
                $('#patients-table-body').html(html);
            },
            error: function(xhr) {
                alert('Terjadi kesalahan saat memfilter data');
            }
        });
    });

    // Delete AJAX
    $(document).on('click', '.btn-delete', function() {
        const patientId = $(this).data('id');
        
        if(confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                url: '/patients/' + patientId,
                type: 'DELETE',
                success: function(response) {
                    if(response.success) {
                        $('#patient-' + patientId).fadeOut(300, function() {
                            $(this).remove();
                        });
                        showToast(response.message, 'success');
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