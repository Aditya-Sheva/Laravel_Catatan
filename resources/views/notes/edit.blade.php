<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Catatan | Catatan Harian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f8f8;
            color: #222;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        nav {
            background: #111;
            color: #fff;
            padding: 12px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 500;
        }
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 60px 15px;
        }
        .container-box {
            max-width: 700px;
            width: 100%;
            background: #fff;
            padding: 35px 40px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }
        h4 {
            margin-bottom: 25px;
            font-weight: 600;
        }
        .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
        }
        .btn-success {
            background-color: #111;
            border: none;
        }
        footer {
            background: #111;
            color: #ccc;
            text-align: center;
            padding: 18px;
            font-size: 0.9rem;
        }
        .img-preview {
            margin-top: 10px;
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<nav>
    <div><strong>Catatan Harian</strong></div>
    <div>
        <a href="{{ url('/notes') }}">Catatan Saya</a>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
           Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</nav>

<main>
    <div class="container-box">
        <h4>Edit Catatan</h4>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('notes.update', $note->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" name="title" class="form-control"
                       value="{{ old('title', $note->title) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Catatan</label>
                <textarea id="editor" name="content" class="form-control">{{ old('content', $note->content) }}</textarea>
            </div>

            <!-- Tampilkan gambar lama -->
            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini</label><br>
                @if($note->gambar)
                    <img src="{{ asset('storage/' . $note->gambar) }}" class="img-preview">
                @else
                    <p class="text-muted">Belum ada gambar</p>
                @endif
            </div>

            <!-- Upload gambar baru -->
            <div class="mb-3">
                <label class="form-label">Ganti Gambar (opsional)</label>
                <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png">
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('notes.index') }}" class="btn btn-secondary">← Kembali</a>
                <button type="submit" class="btn btn-success px-4">Simpan Perubahan</button>
            </div>

        </form>
    </div>
</main>
<footer>
    <p>© {{ date('Y') }} Catatan Harian | Dibuat dengan hati oleh Anda</p>
</footer>
<!-- TinyMCE -->
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    tinymce.init({
        selector: '#editor',
        height: 300,
        menubar: false,
        plugins: 'lists link code',
        toolbar: 'undo redo | bold italic underline | fontsizeselect fontselect | alignleft aligncenter alignright | bullist numlist | linK | code'
    });
});
</script>
</body>
</html>
