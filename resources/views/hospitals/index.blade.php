@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Rumah Sakit</h5>
                    <a href="{{ route('hospitals.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus"></i> Tambah Rumah Sakit
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Rumah Sakit</th>
                                    <th>Alamat</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($hospitals as $index => $hospital)
                                <tr id="hospital-{{ $hospital->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $hospital->nama_rumah_sakit }}</td>
                                    <td>{{ $hospital->alamat }}</td>
                                    <td>{{ $hospital->email }}</td>
                                    <td>{{ $hospital->telepon }}</td>
                                    <td>
                                        <a href="{{ route('hospitals.show', $hospital) }}" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('hospitals.edit', $hospital) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $hospital->id }}">Hapus</button>
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