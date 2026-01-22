@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Detail Rumah Sakit</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Nama Rumah Sakit</th>
                            <td>{{ $hospital->nama_rumah_sakit }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $hospital->alamat }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $hospital->email }}</td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>{{ $hospital->telepon }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat Pada</th>
                            <td>{{ $hospital->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Diupdate Pada</th>
                            <td>{{ $hospital->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('hospitals.index') }}" class="btn btn-secondary">Kembali</a>
                        <div>
                            <a href="{{ route('hospitals.edit', $hospital) }}" class="btn btn-warning">Edit</a>
                            <button type="button" class="btn btn-danger btn-delete" data-id="{{ $hospital->id }}">Hapus</button>
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
                        alert(response.message);
                        window.location.href = '/hospitals';
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