<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Aktivitas User</title>
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

    /* MAIN */
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
        box-shadow: 0 6px 20px rgba(0,0,0,0.10);
        border: 1px solid #eee;
    }

    /* TABLE */
    thead.table-dark {
        background: linear-gradient(135deg, #1c1c1c, #000) !important;
    }

    table tbody tr:hover {
        background: #faf7f3 !important;
        transition: 0.2s;
    }

    /* BADGES */
    .badge-admin {
    background: linear-gradient(135deg, #000, #2a2a2a);
    color: #fff;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.8rem;
    }

    .badge-user {
        background: linear-gradient(135deg, #5a4637, #46362a);
        color: #fff;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
    }

    /* BUTTON */
    .btn-dark-custom {
        background: #1b1b1b;
        color: #fff;
        border: none;
        transition: 0.2s;
    }
    .btn-dark-custom:hover {
        background: #3c2f25;
        color: #fff;
    }

    /* FOOTER */
    footer {
        background: #1b1b1b;
        color: #ccc;
        text-align: center;
        padding: 18px;
        font-size: 0.9rem;
        border-top: 1px solid #2f2f2f;
    }
</style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <div><strong style="color:#c8a97e;">Admin Panel</strong></div>
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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0" style="color:#1b1b1b;">Aktivitas Seluruh User</h4>
            <span class="text-muted">Total User: {{ count($users) }}</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-dark text-light">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Jumlah Notes</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="fw-semibold">{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td class="text-muted">{{ $user->email }}</td>

                        <td>
                            @if($user->role === 'admin')
                                <span class="badge-admin">Admin</span>
                            @else
                                <span class="badge-user">User</span>
                            @endif
                        </td>

                        <td>
                            <span class="badge bg-secondary">{{ $user->notes_count }}</span>
                        </td>

                        <td>
                            <a href="{{ route('admin.user-notes', $user->id) }}"
                               class="btn btn-sm btn-dark-custom">
                               Lihat Notes
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

        <div class="text-end mt-4">
            <a href="{{ url('/') }}" class="btn btn-dark-custom">← Kembali ke Beranda</a>
        </div>

    </div>
</main>

<!-- FOOTER -->
<footer>
    <p>© {{ date('Y') }} Catatan Harian | Admin Panel</p>
</footer>

</body>
</html>
