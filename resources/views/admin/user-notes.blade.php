<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Notes {{ $user->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f4f3f1;
        color: #222;
        margin: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* NAVBAR */
    nav {
        background: #1b1b1b;
        padding: 14px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #2e2e2e;
    }
    nav a {
        color: #e1e1e1;
        text-decoration: none;
        margin-left: 20px;
        font-weight: 500;
        transition: 0.2s ease;
    }
    nav a:hover {
        color: #c8a97e;
    }

    main {
        flex: 1;
        padding: 60px 15px;
        display: flex;
        justify-content: center;
    }

    .container-box {
        width: 100%;
        max-width: 1100px;
        background: #fff;
        padding: 35px;
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        border: 1px solid #eee;
    }

    /* BACK BUTTON */
    .btn-back {
        background: #1b1b1b;
        color: #fff;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        margin-bottom: 25px;
        display: inline-block;
        transition: 0.2s ease;
    }
    .btn-back:hover {
        background: #3c2f25;
    }

    /* USER INFO PANEL */
    .user-info {
        background: #faf7f3;
        padding: 25px;
        border-radius: 10px;
        border-left: 5px solid #3c2f25;
        margin-bottom: 30px;
    }
    .user-info h5 {
        font-weight: 600;
        color: #1b1b1b;
        margin-bottom: 12px;
    }

    /* NOTE CARD */
    .note-card {
        background: #fff;
        border: 1px solid #e8e5e1;
        border-radius: 10px;
        padding: 22px;
        margin-bottom: 22px;
        transition: 0.25s ease;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    }
    .note-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 22px rgba(0,0,0,0.12);
    }

    .note-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1b1b1b;
        margin-bottom: 10px;
    }

    .note-content {
        color: #5a5a5a;
        margin-bottom: 15px;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    .note-image {
        width: 100%;
        max-height: 330px;
        object-fit: cover;
        border-radius: 8px;
        margin: 15px 0;
        border: 1px solid #ddd;
    }

    .note-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        color: #888;
        border-top: 1px solid #eee;
        padding-top: 12px;
        margin-top: 10px;
    }

    /* BUTTON DELETE */
    .btn-delete {
        background: #c0392b;
        border: none;
        color: #fff;
        padding: 7px 14px;
        border-radius: 6px;
        font-size: 0.85rem;
        transition: 0.2s ease;
    }
    .btn-delete:hover {
        background: #a93226;
    }

    footer {
        background: #1b1b1b;
        color: #ccc;
        text-align: center;
        padding: 18px;
        font-size: 0.9rem;
        border-top: 1px solid #2e2e2e;
    }
</style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <div><strong style="color:#c8a97e;">Admin Panel - Notes User</strong></div>
    <div>
        <a href="{{ url('/') }}">Beranda</a>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
           Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
</nav>

<!-- CONTENT -->
<main>
    <div class="container-box">

        <a href="{{ route('admin.users') }}" class="btn-back">← Kembali ke Daftar Users</a>

        @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <!-- USER INFO -->
        <div class="user-info">
            <h5>{{ $user->name }}</h5>
            <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="mb-1"><strong>Total Notes:</strong> {{ $user->notes->count() }}</p>
        </div>

        <h4 class="mb-4">Daftar Notes</h4>

        @if($notes->count() > 0)
            @foreach($notes as $note)
            <div class="note-card">

                <div class="note-title">{{ $note->title }}</div>

                @if($note->content)
                <div class="note-content">{{ Str::limit(strip_tags($note->content), 300) }}</div>
                @endif

                @if($note->gambar)
                <img src="{{ Storage::url($note->gambar) }}" class="note-image" alt="Gambar Note">
                @endif

                <div class="note-meta">
                    <span>{{ $note->created_at->format('d M Y H:i') }}</span>
                    <button class="btn-delete" onclick="confirmDelete({{ $note->id }})">
                        Hapus
                    </button>
                </div>
            </div>

            <!-- DELETE FORM -->
            <form id="delete-form-{{ $note->id }}" action="{{ route('admin.delete-note', $note->id) }}"
                  method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>

            @endforeach

            <!-- PAGINATION -->
            @if($notes->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $notes->links() }}
            </div>
            @endif

        @else
            <div class="alert alert-info">User ini belum memiliki notes.</div>
        @endif

    </div>
</main>

<footer>
    <p>© {{ date('Y') }} Catatan Harian | Admin Panel</p>
</footer>

<script>
function confirmDelete(noteId) {
    if (confirm('Yakin ingin menghapus note ini? Tindakan tidak dapat dibatalkan.')) {
        document.getElementById('delete-form-' + noteId).submit();
    }
}
</script>

</body>
</html>
