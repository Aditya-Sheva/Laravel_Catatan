@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Gambar</h2>
    <form action="{{ route('gambars.update', $gambar->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" value="{{ $gambar->judul }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Gambar Sekarang</label><br>
            @if($gambar->gambar)
                <img src="{{ asset('storage/'.$gambar->gambar) }}" width="150" alt="">
            @endif
        </div>
        <div class="mb-3">
            <label>Upload Gambar Baru (opsional)</label>
            <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png">
        </div>
        <button type="submit" class="btn btn-primary">Perbarui</button>
    </form>
</div>
@endsection
