@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Gambar</h2>
    <form action="{{ route('gambars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Upload Gambar</label>
            <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
