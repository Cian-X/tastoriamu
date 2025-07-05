<?php
// Test sederhana untuk memeriksa alur order
echo "=== TEST ALUR ORDER TASTORIA ===\n\n";

// 1. Test Route
echo "1. Route yang tersedia:\n";
echo "- /foods (GET) - Lihat menu\n";
echo "- /cart (GET) - Lihat keranjang\n";
echo "- /checkout (GET/POST) - Checkout\n";
echo "- /orders (GET) - Riwayat pesanan user\n";
echo "- /admin/orders (GET) - Semua pesanan admin\n";
echo "- /kurir/dashboard (GET) - Dashboard kurir\n\n";

// 2. Alur Order yang Benar
echo "2. Alur Order yang Benar:\n";
echo "a) User login\n";
echo "b) User pilih menu dan tambah ke cart\n";
echo "c) User checkout dengan metode pembayaran\n";
echo "d) Order dibuat dengan status 'menunggu pembayaran'\n";
echo "e) Admin konfirmasi pembayaran (status jadi 'siap antar')\n";
echo "f) Kurir ambil pesanan (status jadi 'dalam pengiriman')\n";
echo "g) Kurir selesaikan pengiriman (status jadi 'selesai')\n\n";

// 3. Status Order
echo "3. Status Order:\n";
echo "- menunggu pembayaran (kuning)\n";
echo "- siap antar (biru muda)\n";
echo "- dalam pengiriman (biru)\n";
echo "- selesai (hijau)\n\n";

// 4. Role dan Akses
echo "4. Role dan Akses:\n";
echo "- User: bisa pesan, lihat riwayat sendiri\n";
echo "- Admin: bisa lihat semua order, konfirmasi pembayaran\n";
echo "- Kurir: bisa lihat order siap antar, update status\n\n";

// 5. Masalah yang Mungkin
echo "5. Masalah yang Mungkin:\n";
echo "- Database connection (cek .env)\n";
echo "- Route tidak terdaftar (cek routes/web.php)\n";
echo "- Middleware tidak terdaftar (cek bootstrap/app.php)\n";
echo "- Status order tidak konsisten\n";
echo "- User tidak bisa checkout\n";
echo "- Admin tidak bisa konfirmasi pembayaran\n";
echo "- Kurir tidak bisa update status\n\n";

echo "=== SELESAI ===\n";
?> 