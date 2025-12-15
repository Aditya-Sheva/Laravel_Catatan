<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Catatan Harian</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(180deg, #f5f5f5, #eeeeee, #e6e6e6);
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #222;
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

        nav b {
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

        /* WRAPPER UTAMA */
        .page-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            padding: 40px 20px;
        }

        /* CARD UTAMA */
        .container-box {
            width: 100%;
            max-width: 1250px;
            background: #fff;
            padding: 50px 55px;
            border-radius: 16px;
            box-shadow: 0 14px 30px rgba(0,0,0,0.08);
            animation: fadeIn 0.6s ease;
            display: flex;
            flex-wrap: wrap;
            gap: 50px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h4, h5 {
            font-family: 'Playfair Display', serif;
            margin: 0;
        }

        /* TOMBOL THEME */
        .btn-dark {
            background: #2B2B2B;
            border-radius: 10px;
            padding: 10px 18px;
        }

        .btn-view {
            background: #5C4033; 
            color: #fff !important;
            border-radius: 8px;
            padding: 6px 14px;
            transition: 0.2s;
        }
        .btn-view:hover { background: #4A3328; }

        .btn-edit {
            background: #2B2B2B;
            color: #fff !important;
            border-radius: 8px;
            padding: 6px 14px;
            transition: 0.2s;
        }
        .btn-edit:hover { background: #1E1E1E; }

        .btn-delete {
            background: #7A5230;
            color: #fff !important;
            border-radius: 8px;
            padding: 6px 14px;
            transition: 0.2s;
        }
        .btn-delete:hover { background: #664327; }

        /* TABEL */
        .table thead {
            background: #2B2B2B;
            color: #fff;
        }

        .table tbody tr:hover {
            background: #f7f7f7;
        }

        /* VIDEO */
        .video-box {
            flex: 0 0 360px;
            text-align: center;
        }

        .video-container {
            position: relative;
            padding-bottom: 56%;
            height: 0;
            overflow: hidden;
            border-radius: 14px;
            box-shadow: 0 10px 28px rgba(0,0,0,0.15);
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
            border-radius: 14px;
        }

        /* FOOTER */
        footer {
            background: #111;
            color: #bbb;
            text-align: center;
            padding: 18px;
            font-size: 0.9rem;
            width: 100%;
            margin-top: auto;
        }

        @media(max-width: 992px) {
            .container-box {
                padding: 35px;
            }
            nav {
                padding: 14px 25px;
            }
            .video-box {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav>
        <b>Catatan Harian</b>
        <div>
            <a href="{{ url('/notes') }}">Beranda</a>
            <a href="{{ route('notes.create') }}">Tambah Catatan</a>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               Logout
            </a>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="page-wrapper">
        <div class="container-box">

            <!-- Kolom Catatan -->
            <div style="flex:1; min-width:500px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Daftar Catatan</h4>
                    <h5>Halo, {{ auth()->user()->name }} 👋</h5>
                </div>

                <a href="{{ route('notes.create') }}" class="btn btn-dark mb-4">+ Buat Catatan Baru</a>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($notes->isEmpty())
                    <p class="text-muted">Belum ada catatan yang dibuat.</p>
                @else
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notes as $note)
                            <tr>
                                <td>{!! $note->title !!}</td>
                                <td class="text-muted mb-2">Dibuat pada {{ $note->created_at->format('d M Y H:i') }}                                <td class="text-center">
                                    <a href="{{ route('notes.show', $note->id) }}" class="btn btn-sm btn-view">Lihat</a>
                                    <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                    <form action="{{ route('notes.destroy', $note->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-delete"
                                                onclick="return confirm('Hapus catatan ini?')">
                                                Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Kolom Video -->
            <div class="video-box">
                <div class="video-container">
                    <video autoplay muted loop controls style="width:100%; border-radius:14px;">
                        <source src="{{ asset('vid/videoplayback.mp4') }}" type="video/mp4">
                    </video>

                </div>
                <p class="mt-3 text-muted">Sedang mencatat…</p>
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        © {{ date('Y') }} Catatan Harian — Dibuat dengan hati oleh Anda
    </footer>

</body>
</html>
