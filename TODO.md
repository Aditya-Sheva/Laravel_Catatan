# TODO: Implementasi Sistem Autentikasi dengan Role di Laravel

- [ ] Buat migrasi untuk menambahkan kolom 'role' ke tabel users
- [ ] Update model User untuk menyertakan 'role' dalam fillable
- [ ] Modifikasi AuthController method register untuk assign role berdasarkan ID
- [ ] Buat RoleMiddleware untuk check role user
- [ ] Daftarkan middleware di bootstrap/app.php
- [ ] Update routes dengan middleware role untuk halaman admin dan user
- [ ] Buat seeder untuk assign role ke user yang sudah ada
- [ ] Jalankan migrasi dan seeder
- [ ] Test login/register dengan role
