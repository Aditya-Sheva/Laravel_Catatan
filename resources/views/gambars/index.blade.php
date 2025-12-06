@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Gambar</h2>
    <a href="{{ route('gambars.create') }}" class="btn btn-primary mb-3">Tambah Gambar</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($gambars as $item)
            <div class="col-md-3 mb-3">
                <div class="card">
                    @if($item->gambar)
                        <img src="{{ asset('storage/'.$item->gambar) }}" class="card-img-top" alt="{{ $item->judul }}">
                    @else
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Tidak ada gambar">
                    @endif
                    <div class="card-body">
                        <h5>{{ $item->judul }}</h5>
                        <a href="{{ route('gambars.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('gambars.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
