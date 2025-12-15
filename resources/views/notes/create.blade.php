<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Catatan Baru</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(180deg, #f5f5f5, #eeeeee, #e6e6e6);
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* NAVBAR */
        nav {
            background: rgba(20, 20, 20, 0.92);
            backdrop-filter: blur(8px);
            color: #fff;
            padding: 16px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            letter-spacing: 0.4px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
        }

        nav strong {
            font-family: 'Playfair Display', serif;
            font-size: 1.55rem;
            letter-spacing: 0.5px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 22px;
            font-size: 0.95rem;
            transition: 0.25s;
        }

        nav a:hover {
            color: #dcdcdc;
        }

        /* MAIN WRAPPER */
        main {
            flex: 1;
            padding: 50px 20px;
            display: flex;
            justify-content: center;
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* CARD */
        .container-box {
            width: 100%;
            max-width: 850px;
            background: #fff;
            padding: 45px 55px;
            border-radius: 16px;
            box-shadow: 0 14px 30px rgba(0,0,0,0.08);
        }

        h4 {
            font-family: 'Playfair Display', serif;
            font-size: 1.7rem;
        }

        /* BUTTON THEME */
        .btn-success {
            background: #2B2B2B;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 500;
            transition: 0.2s;
        }

        .btn-success:hover {
            background: #1a1a1a;
        }

        .btn-secondary {
            border-radius: 10px;
        }

        /* IMAGE PREVIEW */
        .img-preview {
            margin-top: 12px;
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: none;
        }

        /* FOOTER */
        footer {
            background: #111;
            color: #bbb;
            text-align: center;
            padding: 18px;
            font-size: 0.9rem;
            margin-top: auto;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav>
    <strong>Catatan Harian</strong>
    <div>
        <a href="{{ url('/notes') }}">Beranda</a>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>
</nav>

<!-- Main Content -->
<main>
    <div class="container-box">
        <h4 class="mb-4">Buat Catatan Baru</h4>

        <form action="{{ route('notes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" name="title" class="form-control" required placeholder="Masukkan judul catatan...">
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Catatan</label>
                <textarea id="editor" name="content" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Gambar (opsional)</label>
                <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png" onchange="previewImage(event)">
                <img id="imgPreview" class="img-preview" alt="Preview Gambar">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Simpan Catatan</button>
                <a href="{{ route('notes.index') }}" class="btn btn-secondary">Kembali</a>
            </div>

        </form>
    </div>
</main>

<footer>
    © {{ date('Y') }} Catatan Harian — Dibuat dengan hati oleh Anda
</footer>

<!-- Script Preview Gambar -->
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imgPreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = "";
        preview.style.display = 'none';
    }
}
</script>

<!-- TinyMCE -->
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    tinymce.init({
        selector: '#editor',
        height: 300,
        menubar: false,
        plugins: 'lists link code',
        toolbar: 'undo redo | bold italic underline | fontsize | alignleft aligncenter alignright | bullist numlist | link | code',
        content_style: "body { font-family:'Poppins'; font-size:15px; }"
    });
});
</script>

</body>
</html>
