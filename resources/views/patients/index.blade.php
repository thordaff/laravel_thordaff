@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Pasien</h5>
                    <a href="{{ route('patients.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus"></i> Tambah Pasien
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Filter Dropdown -->
                    <div class="mb-3">
                        <label for="hospital_filter" class="form-label">Filter berdasarkan Rumah Sakit:</label>
                        <select class="form-select" id="hospital_filter">
                            <option value="">Semua Rumah Sakit</option>
                            @foreach($hospitals as $hospital)
                                <option value="{{ $hospital->id }}">{{ $hospital->nama_rumah_sakit }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pasien</th>
                                    <th>Alamat</th>
                                    <th>No Telepon</th>
                                    <th>Rumah Sakit</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="patients-table-body">
                                @forelse($patients as $index => $patient)
                                <tr id="patient-{{ $patient->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $patient->nama_pasien }}</td>
                                    <td>{{ $patient->alamat }}</td>
                                    <td>{{ $patient->no_telepon }}</td>
                                    <td>{{ $patient->hospital->nama_rumah_sakit }}</td>
                                    <td>
                                        <a href="{{ route('patients.show', $patient) }}" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $patient->id }}">Hapus</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data</td>
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
                                <td>${index + 1}</td>
                                <td>${patient.nama_pasien}</td>
                                <td>${patient.alamat}</td>
                                <td>${patient.no_telepon}</td>
                                <td>${patient.hospital.nama_rumah_sakit}</td>
                                <td>
                                    <a href="/patients/${patient.id}" class="btn btn-info btn-sm">Detail</a>
                                    <a href="/patients/${patient.id}/edit" class="btn btn-warning btn-sm">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="${patient.id}">Hapus</button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = '<tr><td colspan="6" class="text-center">Tidak ada data</td></tr>';
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