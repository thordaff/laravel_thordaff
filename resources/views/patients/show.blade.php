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
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.btn-delete').click(function() {
        const patientId = $(this).data('id');
        
        if(confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                url: '/patients/' + patientId,
                type: 'DELETE',
                success: function(response) {
                    if(response.success) {
                        showToast(response.message, 'success');
                        setTimeout(function() {
                            window.location.href = '/patients';
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