<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Catatan Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f8f8;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
        }

        main {
            flex: 1;
            padding: 60px 15px;
            display: flex;
            justify-content: center;
        }

        .container-box {
            max-width: 700px;
            background: #fff;
            padding: 35px 40px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            width: 100%;
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
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            display: none;
        }
    </style>
</head>
<body>
    <nav>
        <div><strong>Catatan Harian</strong></div>
        <div>
            <a href="{{ url('/notes') }}">Beranda</a>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </div>
    </nav>

    <main>
        <div class="container-box">
            <h4 class="mb-4">Buat Catatan Baru</h4>

            <!-- Tambahkan enctype untuk upload file -->
            <form action="{{ route('notes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label>Judul</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Isi Catatan</label>
                    <textarea name="content" rows="5" class="form-control" required></textarea>
                </div>

                <!-- ✅ Kolom upload gambar -->
                <div class="mb-3">
                    <label>Upload Gambar (opsional)</label>
                    <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png" onchange="previewImage(event)">
                    <img id="imgPreview" class="img-preview" alt="Preview Gambar">
                </div>

                <button class="btn btn-success">Simpan</button>
                <a href="{{ route('notes.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </main>

    <footer>
        <p>© {{ date('Y') }} Catatan Harian | Dibuat dengan hati oleh Anda</p>
    </footer>

    <script>
        // Fungsi untuk menampilkan preview gambar sebelum upload
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
</body>
</html>
