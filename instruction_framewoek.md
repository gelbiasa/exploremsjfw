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

1. Routes Index, Contoh URL : “http://127.0.0.1:8000/msenum” Route Ini Akan Mengakses Controller Dengan Function “index” Dan Akan Meneruskan Ke View “list.blade.php”
2. Routes Add, Contoh URL : “http://127.0.0.1:8000/msenum/add” Route Ini Akan Mengakses Controller Dengan Function “add” Dan Akan Meneruskan Ke View “add.blade.php” Controller Dengan Function “store” Sebagai Eksekutor Data Yang Akan Di Simpan.
3. Routes Show, Contoh URL : “http://127.0.0.1:8000/msenum/show/(id)” Route Ini Akan Mengakses Controller Dengan Function “show” Dan Akan Meneruskan Ke View
“show.blade.php”
4. Routes Edit, Contoh URL : “http://127.0.0.1:8000/msenum/edit/(id)” Route Ini Akan Mengakses Controller Dengan Function “edit” Dan Akan Meneruskan Ke View “edit.blade.php”Controller Dengan Function “update” Sebagai Eksekutor Data Yang Akan Di Update. Controller Dengan Function “destroy” Sebagai Eksekutor Data Yang Akan Di Hapus.

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

### Komponen Utama Framework:

#### 1. **Sistem Tabel Konfigurasi**
- `sys_roles` - Manajemen role/peran pengguna
- `sys_gmenu` - Group menu (Master, Transaction, Report, System)
- `sys_dmenu` - Detail menu (submenu dalam setiap group)
- `sys_auth` - Authorization matrix (role vs menu permissions)
- `sys_table` - Konfigurasi field dan validasi untuk form dinamis
- `sys_enum` - Master data untuk dropdown dan pilihan
- `users` - Data pengguna dengan field `idroles` untuk multiple roles

#### 2. **Sistem Role & Authorization**
```php
// Role Structure
'admins'  -> Admin (full access)
'ppic01'  -> Production Planning 01
'ppic02'  -> Production Planning 02  
'itdept'  -> IT Department
```

#### 3. **Layout System (6 Jenis Layout)**
- **Manual**: Custom views dengan folder struktur `views/{gmenu}/{url}/`
- **Standard**: CRUD dengan 1 primary key
- **Master**: CRUD dengan multiple primary keys
- **System**: Header-Detail dengan 2 bagian tampilan
- **Report**: Filter + Result report
- **SubLink**: Detail dari link lain (mirip System)

#### 4. **Dynamic Form Generation**
Framework menggunakan tabel `sys_table` untuk generate form otomatis:
```php
// Field Types Available:
'char', 'string', 'email', 'enum', 'image', 'join', 
'number', 'password', 'text', 'hidden', 'date', 
'file', 'search', 'currency', 'sublink'

// Validation Rules stored in database
'required|max:100|min:4'
'required|exists:mst_produk,pdrk_id'
```

#### 5. **Routing Pattern**
```php
// Dynamic routing untuk semua menu
Route::get('/{page}', [PageController::class, 'index'])
Route::post('/{page}', [PageController::class, 'index']) 
Route::get('/{page}/{action}', [PageController::class, 'index'])
Route::get('/{page}/{action}/{id}', [PageController::class, 'index'])

// PageController sebagai router yang mengarahkan ke controller spesifik
// berdasarkan URL dan layout yang dipilih
```

#### 6. **Controller Pattern**
```php
// Setiap layout memiliki controller base:
- StandardController -> untuk layout 'standr'
- MasterController -> untuk layout 'master'  
- SystemController -> untuk layout 'system'
- TranscController -> untuk layout 'transc'
- SublnkController -> untuk layout 'sublnk'
- Custom Controllers -> untuk layout 'manual'
```

### Alur Kerja Framework:

1. **Menu Loading**: Sistem membaca `sys_gmenu` dan `sys_dmenu` berdasarkan role user
2. **Authorization Check**: Validasi permission dari `sys_auth` 
3. **Dynamic Routing**: URL diteruskan ke PageController
4. **Controller Selection**: Berdasarkan layout, pilih controller yang sesuai
5. **Form Generation**: Untuk non-manual layout, generate form dari `sys_table`
6. **Data Processing**: CRUD operations dengan validation rules dari database

# Alur Modifikasi Framework Layout Manual
Acuan: informasi untuk perubahan kode pada views/transc/trslod itu yang boleh diedit hanya bagian conten sebagai acuan saya sudah menandai dengan membeikan command pada transc/auto dimana kode mana saja yang boleh diedit dengan memberikan tanda {{-- Boleh Diedit}}