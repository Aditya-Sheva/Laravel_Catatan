<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Catatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
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
        }

        main {
            flex: 1;
            padding: 60px 15px;
            display: flex;
            justify-content: center;
        }

        .container-box {
            width: 100%;
            max-width: 800px;
            background: #fff;
            padding: 40px 50px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }

        .note-title {
            font-weight: 600;
            font-size: 1.6rem;
        }

        .note-content {
            white-space: pre-wrap;
            margin-top: 15px;
            line-height: 1.7;
        }

        .note-image {
            margin: 20px 0;
            text-align: center;
        }

        .note-image img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        footer {
            background: #111;
            color: #ccc;
            text-align: center;
            padding: 18px;
            font-size: 0.9rem;
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
            <h4 class="note-title">{{ $note->title }}</h4>
            <p class="text-muted mb-2">Dibuat pada {{ $note->created_at->format('d M Y H:i') }}</p>
            <hr>

            <!-- ✅ Tampilkan gambar jika ada -->
            @if($note->gambar)
                <div class="note-image">
                    <img src="{{ asset('storage/' . $note->gambar) }}" alt="Gambar Catatan">
                </div>
            @endif


            <div class="note-content">{{ $note->content }}</div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('notes.index') }}" class="btn btn-secondary">← Kembali</a>
                <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-warning">Edit Catatan</a>
            </div>
        </div>
    </main>

    

    <footer>
        <p>© {{ date('Y') }} Catatan Harian | Dibuat dengan hati oleh Anda</p>
    </footer>
</body>
</html>
