<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan Harian</title>
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
            max-width: 900px;
            background: #fff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }

        .btn-dark {
            background: #111;
            border: none;
        }

        /* Tombol Lihat, Edit, Hapus disesuaikan */
        .btn-view {
            background-color: #444;
            color: #fff;
            border: none;
        }
        .btn-view:hover {
            background-color: #222;
        }

        .btn-edit {
            background-color: #000;
            color: #fff;
            border: none;
        }
        .btn-edit:hover {
            background-color: #333;
        }

        .btn-delete {
            background-color: #555;
            color: #fff;
            border: none;
        }
        .btn-delete:hover {
            background-color: #333;
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
            <a href="{{ route('notes.create') }}">Tambah Catatan</a>
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
            <h4 class="mb-4">Daftar Catatan</h4>
            <a href="{{ route('notes.create') }}" class="btn btn-dark mb-3">+ Buat Catatan Baru</a>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($notes->isEmpty())
                <p class="text-muted">Belum ada catatan yang dibuat.</p>
            @else
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notes as $note)
                            <tr>
                                <td>{{ $note->title }}</td>
                                <td>{{ $note->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('notes.show', $note->id) }}" class="btn btn-sm btn-view">Lihat</a>
                                    <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                    <form action="{{ route('notes.destroy', $note->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-delete" onclick="return confirm('Hapus catatan ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </main>

    <footer>
        <p>© {{ date('Y') }} Catatan Harian | Dibuat dengan hati oleh Anda</p>
    </footer>
</body>
</html>
