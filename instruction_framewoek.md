# Penjelasan Mengenai MSJ Framework 

Instruksi MSJFramework_v12" ini menjelaskan kerangka kerja (framework) pembuatan aplikasi di PT. Multi Spunindo Jaya Tbk, yang dibangun menggunakan Laravel 12.

# Jenis Class Yang Tersedia: 
1. upper: Mengubah ukuran font menjadi huruf kapital semua
2. lower: Mengubah ukuran font menjadi huruf kecil semua.
3. filter: Berfungsi sebagai filter di layout laporan.
4. notspace: Menghapus spasi pada inputan.
5. readonly: Membuat inputan tidak bisa diedit.
6. check-date: Memberi warna kuning jika tanggal di bawah batas kolom 'length'.
7. check-stock: Memberi warna merah jika stok di bawah batas kolom 'sub'.

# char: Input teks.
1. char = Tampilan Input Text
2. currency: Angka dengan format mata uang (misal: IDR).
3. date: Tampilan tanggal.
4. date2: Rentang tanggal (khusus untuk layout laporan).
5. email: Format email.
6. enum: Pilihan (select option).
7. file: Unggah file (pdf, xls, xlsx, maksimal 2048 KB).
8. hidden: Menyembunyikan bidang.
9. image: Unggah gambar (jpg, png, jpeg, maksimal 2048 KB).
10. join: Menampilkan data dari tabel gabungan.
11. number: Angka.
12. password: Khusus untuk kata sandi.
13. report: Digunakan pada layout laporan di urutan pertama.
14. search: Input teks dengan modal pencarian.
15. string: Input teks (sama seperti char).
16. text: Text area.

# Alur Proses

Menjelaskan bagaimana URL diakses, melewati routes/web.php, PageController, (Url)Controller, dan berinteraksi dengan tampilan (views).

# Jenis Layout yang Tersedia (6 Layout):
Layout Standard: Tampilan Daftar, Tampil, Tambah, Edit, Hapus dengan satu primary key.
Layout Master: Sama seperti Layout Standard, tetapi bisa menggunakan lebih dari satu primary key.
Layout System: Menggunakan lebih dari satu primary key dan memiliki dua bagian tampilan (Header dan Detail).
Layout Report: Tampilan Filter dan Hasil Laporan.
Layout Sublink: Tampilan Detail dari tautan lain, memiliki dua tampilan seperti Layout System.
Layout Manual: Untuk membuat tampilan manual dengan folder khusus di resources/views.

# Routes Untuk Layout Manual

Menjelaskan empat routes utama: Index, Add (dengan fungsi store), Show, dan Edit (dengan fungsi update dan destroy).

# Membuat File Tamplian Manual.

Khusus Layout Manual Jika Anda Memilih Ini, Maka Harus Membuat Folder Sesuai Nama URL
Di Dalam Folder Views->(Nama GMENU)->(NamaURL).

# Penjelasan List Menu: 

1. ID Menu = Digunakan sebagai primary key setiap menu.
2. Group Menu = Group Menu sebagai pengelompokan berbagai list menu.
3. Urut = No. Urut Menu agar lebih rapi.
4. Nama = Nama Menu yang tampil oleh user.
5. Icon = Icon Menu sebagai gambar atau simbol di setiap list menu.
6. URL = Link Menu sebagai link menu.
7. Tabel = Nama Tabel Menu berguna untuk pemanggilan data saat menggunakan layout selain layout manual dan layout report.
8. Where = Berguna Untuk Memfilter Data Di Level Menu.
9. Layout = Untuk menentukan tampilan menu yang di pilih. Pilih Manual Untuk Custom
Manual.
10. SubMenu = Pilih Menu yang akan dijadikan header menu. Pastikan menu yg dipilih sudah
memakai layout sublink.
11. Show = Setting Untuk Menu Tampil Atau Tidak
12. Javascript = Setting Untuk Menggunakan JS Tambahan Atau Tidak, Jika memilih iya maka harus menambahkan file JS di folder “resources\views\js\(idmenu).blade.php”
13. Notifikasi(Query) = Query Ini Akan Muncul Di Samping List Menu, berisi query dengan hasilharus 1 data dan harus memakai alias “notif”
Contoh query untuk menu users : “select count(*) as 'notofikasi' from users where isactive = '1'”
