# Struktur Database `dispusip_db`

Dokumen ini menjelaskan struktur database `dispusip_db` yang digunakan pada sistem website Dinas Perpustakaan dan Kearsipan (Dispusip). 

Database ini menggunakan **MySQL/MariaDB** dengan total **18 tabel** yang terbagi menjadi tabel sistem (`sys_`), tabel master (`mst_`), tabel transaksi (`trn_`), serta tabel migrasi.

---

## Daftar Tabel (Overview)

| Nama Tabel | Prefiks/Jenis | Deskripsi Fungsi |
| :--- | :--- | :--- |
| [migrations](#1-tabel-migrations) | Sistem | Melacak riwayat migrasi skema database (bawaan CodeIgniter 4). |
| [sys_peran](#2-tabel-sys_peran) | Sistem (`sys_`) | Menyimpan jenis peran (roles) hak akses pengguna. |
| [sys_users](#3-tabel-sys_users) | Sistem (`sys_`) | Menyimpan data akun pengguna website (admin, redaktur, dll). |
| [mst_flyer](#4-tabel-mst_flyer) | Master (`mst_`) | Menyimpan banner/flyer promosi atau info penting. |
| [mst_kategori](#5-tabel-mst_kategori) | Master (`mst_`) | Kategori artikel (berita, artikel ilmiah, dsb) secara hierarkis. |
| [mst_media](#6-tabel-mst_media) | Master (`mst_`) | Library media file (gambar/dokumen pendukung). |
| [mst_menu](#7-tabel-mst_menu) | Master (`mst_`) | Navigasi menu dinamis pada website. |
| [mst_pages](#8-tabel-mst_pages) | Master (`mst_`) | Halaman statis (seperti Profil, Visi Misi, dll). |
| [mst_running_text](#9-tabel-mst_running_text) | Master (`mst_`) | Mengelola teks pengumuman berjalan. |
| [mst_subscribers](#10-tabel-mst_subscribers) | Master (`mst_`) | Menyimpan daftar email pelanggan buletin/newsletter. |
| [mst_tags](#11-tabel-mst_tags) | Master (`mst_`) | Tag/label pencarian artikel. |
| [trn_artikel](#12-tabel-trn_artikel) | Transaksi (`trn_`) | Konten artikel atau berita utama. |
| [trn_artikel_kategori](#13-tabel-trn_artikel_kategori) | Pivot/Relasi | Menghubungkan artikel dengan satu atau beberapa kategori. |
| [trn_artikel_media](#14-tabel-trn_artikel_media) | Pivot/Relasi | Menghubungkan artikel dengan media file pendukung. |
| [trn_artikel_tags](#15-tabel-trn_artikel_tags) | Pivot/Relasi | Menghubungkan artikel dengan tag penanda. |
| [trn_galeri](#16-tabel-trn_galeri) | Transaksi (`trn_`) | Album foto/galeri kegiatan. |
| [trn_galeri_gambar](#17-tabel-trn_galeri_gambar) | Transaksi (`trn_`) | Foto-foto di dalam suatu album galeri kegiatan. |
| [trn_komentar](#18-tabel-trn_komentar) | Transaksi (`trn_`) | Komentar pengunjung pada artikel. |

---

## Detail Struktur Tabel

### 1. Tabel `migrations`
Tabel ini digunakan oleh CodeIgniter 4 untuk mencatat dan melacak proses migrasi database.

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `id` | bigint unsigned | NO | PRI | *auto_increment* | ID unik migrasi. |
| `version` | varchar(255) | NO | | | Versi migrasi (format datetime). |
| `class` | varchar(255) | NO | | | Nama class migrasi. |
| `group` | varchar(255) | NO | | | Grup database (default, tests, dll). |
| `namespace` | varchar(255) | NO | | | Namespace dari class migrasi. |
| `time` | int | NO | | | Timestamp eksekusi migrasi. |
| `batch` | int unsigned | NO | | | Angka batch pengelompokan migrasi. |

---

### 2. Tabel `sys_peran`
Menyimpan peran/hak akses pengguna sistem (misalnya: Admin, Redaktur, Pengamat).

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `peran_id` | int unsigned | NO | PRI | *auto_increment* | ID unik peran. |
| `nama_peran` | varchar(50) | NO | UNI | | Nama peran (misal: Admin, Redaktur). |
| `deskripsi` | varchar(255) | YES | | NULL | Deskripsi tugas peran tersebut. |
| `created_at` | datetime | YES | | NULL | Waktu pembuatan data. |
| `updated_at` | datetime | YES | | NULL | Waktu perubahan terakhir data. |
| `deleted_at` | datetime | YES | | NULL | Waktu penghapusan logis (*soft delete*). |

---

### 3. Tabel `sys_users`
Menyimpan informasi kredensial dan profil dari para pengguna pengelola website.

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `user_id` | int | NO | PRI | *auto_increment* | ID unik user. |
| `user_uuid` | char(36) | YES | | NULL | UUID untuk representasi non-increment. |
| `username` | varchar(50) | NO | UNI | | Username untuk login. |
| `email` | varchar(100) | NO | UNI | | Alamat email user. |
| `password` | varchar(255) | NO | | | Password terenkripsi (hash). |
| `nama_publik` | varchar(100) | NO | | | Nama lengkap atau nama pena. |
| `peran_id` | int unsigned | YES | | NULL | Referensi ke `sys_peran(peran_id)`. |
| `tanggal_daftar` | datetime | NO | | CURRENT_TIMESTAMP | Waktu pendaftaran/pembuatan user. |
| `updated_at` | datetime | YES | | NULL | Waktu perubahan terakhir data (*on update*). |
| `deleted_at` | datetime | YES | MUL | NULL | Waktu penghapusan logis (*soft delete*). |

---

### 4. Tabel `mst_flyer`
Menyimpan data banner promosi, poster digital, atau pengumuman gambar yang berganti-ganti (slider/flyer).

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `flayer_id` | int unsigned | NO | PRI | *auto_increment* | ID unik flyer. |
| `uuid` | varchar(36) | YES | MUL | NULL | UUID flyer. |
| `judul` | varchar(255) | NO | | | Judul/nama flyer. |
| `gambar_url` | varchar(255) | NO | | | URL/path file gambar flyer. |
| `label` | varchar(100) | YES | | NULL | Label tambahan/kategori flyer. |
| `status` | enum('Aktif','Tidak Aktif') | NO | MUL | 'Aktif' | Status publikasi flyer. |
| `urutan` | int | NO | | 0 | Urutan tampilan (sorting). |
| `created_at` | datetime | YES | | NULL | Waktu pembuatan. |
| `updated_at` | datetime | YES | | NULL | Waktu perubahan terakhir. |
| `deleted_at` | datetime | YES | | NULL | Waktu penghapusan logis. |

---

### 5. Tabel `mst_kategori`
Mengelola kategori artikel secara hierarkis (mendukung sub-kategori).

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `kategori_id` | int | NO | PRI | *auto_increment* | ID unik kategori. |
| `kategori_uuid` | varchar(36) | YES | | NULL | UUID kategori. |
| `nama` | varchar(100) | NO | | | Nama kategori. |
| `slug` | varchar(100) | NO | UNI | | Slug URL yang ramah SEO. |
| `kategori_induk_id` | int | YES | MUL | NULL | ID kategori induk (referensi diri). |
| `created_at` | datetime | NO | | CURRENT_TIMESTAMP | Waktu kategori dibuat. |
| `updated_at` | datetime | YES | | NULL | Waktu pembaruan (*on update*). |
| `deleted_at` | datetime | YES | MUL | NULL | Waktu penghapusan logis. |

**Relasi Foreign Key:**
* `kategori_induk_id` berelasi ke `mst_kategori(kategori_id)` dengan aksi `ON DELETE SET NULL ON UPDATE CASCADE`.

---

### 6. Tabel `mst_media`
Penyimpanan library berkas media (gambar, PDF, video, dll) yang diunggah oleh pengguna.

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `media_id` | int | NO | PRI | *auto_increment* | ID unik media. |
| `nama_file` | varchar(255) | NO | | | Nama asli berkas media. |
| `url_file` | varchar(255) | NO | | | URL/path untuk mengakses file. |
| `tipe_file` | varchar(50) | NO | | | MIME-type berkas (misal: image/jpeg). |
| `caption` | text | YES | | NULL | Keterangan teks media. |
| `user_id` | int | NO | MUL | | Pengunggah berkas, relasi ke `sys_users`. |
| `created_at` | datetime | NO | | CURRENT_TIMESTAMP | Waktu media diunggah. |
| `updated_at` | datetime | YES | | NULL | Waktu perubahan terakhir. |
| `deleted_at` | datetime | YES | MUL | NULL | Waktu penghapusan logis. |

**Relasi Foreign Key:**
* `user_id` berelasi ke `sys_users(user_id)` dengan aksi `ON DELETE CASCADE ON UPDATE CASCADE`.

---

### 7. Tabel `mst_menu`
Mengatur struktur menu navigasi dinamis pada bagian front-end maupun back-end website.

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `id` | int unsigned | NO | PRI | *auto_increment* | ID unik menu. |
| `parent_id` | int unsigned | YES | MUL | NULL | ID menu induk jika berupa sub-menu. |
| `title` | varchar(100) | NO | | | Label menu yang akan tampil. |
| `url` | varchar(255) | NO | | | URL tujuan menu. |
| `sort_order` | int | NO | | 0 | Urutan prioritas penataan menu. |
| `is_active` | tinyint(1) | NO | | 1 | Status aktif menu (1 = Aktif, 0 = Nonaktif). |
| `created_at` | datetime | YES | | NULL | Waktu menu ditambahkan. |
| `updated_at` | datetime | YES | | NULL | Waktu menu diperbarui. |
| `deleted_at` | datetime | YES | | NULL | Waktu menu dihapus secara logis. |

---

### 8. Tabel `mst_pages`
Menyimpan konten halaman statis sistem (contoh: Profil Dinas, Sejarah, Struktur Organisasi).

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `page_id` | int unsigned | NO | PRI | *auto_increment* | ID unik halaman statis. |
| `page_uuid` | char(36) | YES | | NULL | UUID halaman. |
| `judul` | varchar(255) | NO | | | Judul halaman statis. |
| `slug` | varchar(255) | NO | MUL | | Slug unik ramah SEO untuk URL. |
| `konten` | longtext | YES | | NULL | Konten/isi halaman (HTML). |
| `status` | enum('Draf','Diterbitkan') | NO | MUL | 'Draf' | Status rilis halaman. |
| `created_at` | datetime | YES | | NULL | Waktu pembuatan halaman. |
| `updated_at` | datetime | YES | | NULL | Waktu terakhir diperbarui. |
| `deleted_at` | datetime | YES | | NULL | Waktu penghapusan logis. |

---

### 9. Tabel `mst_running_text`
Menyimpan teks berjalan (running text) yang digunakan untuk pengumuman sekilas di bagian header/footer web.

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `id` | int unsigned | NO | PRI | *auto_increment* | ID unik teks berjalan. |
| `teks` | text | NO | | | Isi teks pengumuman. |
| `is_active` | tinyint(1) | NO | | 1 | Status aktif running text (1 = Aktif, 0 = Nonaktif). |
| `created_at` | datetime | YES | | NULL | Waktu pembuatan. |
| `updated_at` | datetime | YES | | NULL | Waktu pembaruan terakhir. |
| `deleted_at` | datetime | YES | | NULL | Waktu penghapusan logis. |

---

### 10. Tabel `mst_subscribers`
Menyimpan data pendaftaran newsletter pengunjung.

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `subscriber_id` | int | NO | PRI | *auto_increment* | ID unik pelanggan. |
| `email` | varchar(100) | NO | UNI | | Alamat email pelanggan. |
| `status` | enum('Aktif','Tidak Aktif','Batal') | NO | | 'Aktif' | Status langganan. |
| `created_at` | datetime | NO | | CURRENT_TIMESTAMP | Waktu pertama langganan. |
| `updated_at` | datetime | YES | | NULL | Waktu pembaruan status (*on update*). |
| `deleted_at` | datetime | YES | MUL | NULL | Waktu penghapusan secara logis. |

---

### 11. Tabel `mst_tags`
Menyimpan kumpulan tag (label penanda kata kunci) untuk artikel.

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `tag_id` | int | NO | PRI | *auto_increment* | ID unik tag. |
| `nama` | varchar(50) | NO | | | Nama tag (misal: "Kearsipan", "Perpustakaan"). |
| `slug` | varchar(50) | NO | UNI | | Slug tag untuk rute URL pencarian. |
| `created_at` | datetime | YES | | CURRENT_TIMESTAMP | Waktu pembuatan tag. |
| `updated_at` | datetime | YES | | CURRENT_TIMESTAMP | Waktu perubahan terakhir tag. |
| `deleted_at` | datetime | YES | MUL | NULL | Waktu penghapusan logis. |

---

### 12. Tabel `trn_artikel`
Merupakan tabel utama transaksi yang menyimpan seluruh berita, artikel, dan terbitan tulisan lainnya.

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `artikel_id` | int | NO | PRI | *auto_increment* | ID unik artikel. |
| `artikel_uuid` | char(36) | YES | | NULL | UUID artikel. |
| `judul` | varchar(255) | NO | | | Judul artikel. |
| `slug` | varchar(255) | NO | UNI | | Slug unik ramah SEO untuk rute artikel. |
| `konten` | longtext | NO | | | Konten lengkap isi artikel (HTML). |
| `gambar_utama` | varchar(255) | YES | | NULL | URL/path gambar utama/fitur artikel. |
| `abstrak` | text | YES | | NULL | Ringkasan singkat/cuplikan isi artikel. |
| `user_id` | int | NO | MUL | | Pembuat artikel, relasi ke `sys_users(user_id)`. |
| `status` | enum('Draf','Ditayangkan','Diarsipkan') | NO | MUL | 'Draf' | Status tayang artikel. |
| `jumlah_tayang` | int | NO | | 0 | Statistik counter jumlah views. |
| `tanggal_publikasi` | datetime | NO | | CURRENT_TIMESTAMP | Tanggal rilis artikel ke publik. |
| `updated_at` | datetime | YES | | NULL | Tanggal pembaruan artikel (*on update*). |
| `deleted_at` | datetime | YES | MUL | NULL | Waktu penghapusan logis. |

**Relasi Foreign Key:**
* `user_id` berelasi ke `sys_users(user_id)` dengan aksi `ON UPDATE CASCADE`.

---

### 13. Tabel `trn_artikel_kategori`
Tabel pivot penghubung relasi Many-to-Many antara tabel `trn_artikel` dengan `mst_kategori`.

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `artikel_id` | int | NO | PRI | | ID artikel. |
| `kategori_id` | int | NO | PRI | | ID kategori. |

**Relasi Foreign Key:**
* `artikel_id` berelasi ke `trn_artikel(artikel_id)` dengan aksi `ON DELETE CASCADE`.
* `kategori_id` berelasi ke `mst_kategori(kategori_id)` dengan aksi `ON DELETE CASCADE`.

---

### 14. Tabel `trn_artikel_media`
Tabel pivot penghubung relasi Many-to-Many antara `trn_artikel` dengan `mst_media` untuk mengaitkan berkas media ke dalam artikel dengan urutan tertentu.

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `artikel_id` | int | NO | PRI | | ID artikel. |
| `media_id` | int | NO | PRI | | ID media. |
| `urutan` | int | YES | | 0 | Urutan tampilan media di artikel. |
| `is_featured` | tinyint(1) | YES | | 0 | Penanda apakah media ini dijadikan sampul/fitur utama (1 = Ya, 0 = Tidak). |

**Relasi Foreign Key:**
* `artikel_id` berelasi ke `trn_artikel(artikel_id)` dengan aksi `ON DELETE CASCADE`.
* `media_id` berelasi ke `mst_media(media_id)` dengan aksi `ON DELETE CASCADE`.

---

### 15. Tabel `trn_artikel_tags`
Tabel pivot penghubung relasi Many-to-Many antara `trn_artikel` dengan `mst_tags`.

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `artikel_id` | int | NO | PRI | | ID artikel. |
| `tag_id` | int | NO | PRI | | ID tag. |

**Relasi Foreign Key:**
* `artikel_id` berelasi ke `trn_artikel(artikel_id)` dengan aksi `ON DELETE CASCADE`.
* `tag_id` berelasi ke `mst_tags(tag_id)` dengan aksi `ON DELETE CASCADE`.

---

### 16. Tabel `trn_galeri`
Menyimpan entitas album/kegiatan galeri foto utama.

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `galeri_id` | int | NO | PRI | *auto_increment* | ID unik album galeri. |
| `judul` | varchar(255) | NO | | | Nama album kegiatan. |
| `sampul_url` | varchar(255) | NO | | | Gambar cover utama album galeri. |
| `deskripsi` | text | YES | | NULL | Deskripsi singkat mengenai album. |
| `created_at` | datetime | NO | | CURRENT_TIMESTAMP | Tanggal pembuatan album. |
| `updated_at` | datetime | YES | | NULL | Tanggal terakhir pembaruan album (*on update*). |
| `deleted_at` | datetime | YES | MUL | NULL | Waktu penghapusan logis. |

---

### 17. Tabel `trn_galeri_gambar`
Menyimpan aset gambar-gambar (Multiple Images) di dalam album kegiatan `trn_galeri`.

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `galeri_gambar_id` | int | NO | PRI | *auto_increment* | ID unik gambar galeri. |
| `galeri_id` | int | NO | MUL | | ID album kegiatan pemilik, relasi ke `trn_galeri(galeri_id)`. |
| `gambar_url` | varchar(255) | NO | | | URL/path gambar. |
| `caption` | varchar(255) | YES | | NULL | Penjelasan singkat gambar tersebut. |

**Relasi Foreign Key:**
* `galeri_id` berelasi ke `trn_galeri(galeri_id)` dengan aksi `ON DELETE CASCADE`.

---

### 18. Tabel `trn_komentar`
Menyimpan komentar yang dikirimkan oleh pengunjung pada postingan artikel, mendukung percakapan bersarang (reply).

| Nama Kolom | Tipe Data | Nullable | Key | Default | Keterangan |
| :--- | :--- | :---: | :---: | :---: | :--- |
| `komentar_id` | int | NO | PRI | *auto_increment* | ID unik komentar. |
| `artikel_id` | int | NO | MUL | | ID artikel yang dikomentari, relasi ke `trn_artikel(artikel_id)`. |
| `nama_pengunjung` | varchar(100) | NO | | | Nama pengunjung yang berkomentar. |
| `email_pengunjung` | varchar(100) | YES | | NULL | Email pengunjung (opsional). |
| `isi_komentar` | text | NO | | | Isi teks komentar. |
| `status` | enum('Disetujui','Menunggu','Spam') | NO | | 'Menunggu' | Status persetujuan penayangan komentar. |
| `komentar_induk_id` | int | YES | MUL | NULL | ID komentar induk jika merupakan reply (relasi self). |
| `created_at` | datetime | NO | | CURRENT_TIMESTAMP | Waktu komentar dibuat. |
| `updated_at` | datetime | YES | | NULL | Waktu modifikasi (*on update*). |
| `deleted_at` | datetime | YES | MUL | NULL | Waktu penghapusan logis. |

**Relasi Foreign Key:**
* `artikel_id` berelasi ke `trn_artikel(artikel_id)` dengan aksi `ON DELETE CASCADE ON UPDATE CASCADE`.
* `komentar_induk_id` berelasi ke `trn_komentar(komentar_id)` dengan aksi `ON DELETE CASCADE ON UPDATE CASCADE`.


Migrasi Prototype HTML Statis & Integrasi Database ke CodeIgniter 4

Konteks Proyek:

Framework Utama: CodeIgniter 4

CSS Framework: Tailwind CSS (sudah terinstal via PostCSS)

Iconography: FontAwesome (tersedia di lokal)

WYSIWYG Editor: CKEditor 5 (tersedia di lokal)

Database: Sudah disiapkan dan siap digunakan untuk mengganti konten statis.

Kondisi Saat Ini:
Saya memiliki file desain statis di public/assets/prototype/:

admin_dashboard.html (Halaman admin/setelah login)

home.html (Halaman utama publik)

berita.html (Halaman daftar berita publik)

detail_berita.html (Halaman detail berita publik)

Instruksi Eksekusi:
Ubah prototype tersebut menjadi struktur MVC dinamis CodeIgniter 4 yang terhubung dengan database melalui langkah-langkah berikut:

1. Pembuatan Models:

Buatkan kerangka CI4 Model untuk entitas yang relevan (misalnya BeritaModel.php).

Definisikan properti standar CI4 seperti $table, $primaryKey, dan $allowedFields (asumsikan struktur tabel standar untuk berita).

2. Pembuatan Layouts (Template Wrapper):

Buat layout publik (app/Views/layouts/public.php) dari home.html dan layout admin (app/Views/layouts/admin.php) dari admin_dashboard.html.

Ekstrak <head>, <nav>, dan <footer>. Gunakan base_url() untuk memanggil aset Tailwind, FontAwesome, dan CKEditor.

3. Pembuatan Controllers (Pengambilan Data):

Buat Controller Home.php, Berita.php, dan Admin.php.

Di dalam method controller, panggil Model yang bersangkutan, ambil data dari database (misal menggunakan findAll() atau paginate()), lalu passing data tersebut ke View dalam bentuk array.

Contoh untuk detail berita, buat method yang menerima parameter slug atau id dan memanggil fungsi where() dari model.

4. Pembuatan Views (Rendering Data Dinamis):

Pindahkan area konten utama HTML ke file View (app/Views/home/index.php, app/Views/berita/index.php, app/Views/berita/detail.php, app/Views/admin/dashboard.php).

Gunakan <?= $this->extend('layouts/nama_layout') ?> dan <?= $this->section('content') ?>.

Ganti teks dan gambar statis (dummy) dari HTML dengan sintaks PHP/CI4 (misal: foreach untuk looping daftar berita, dan esc($item['judul']) untuk menampilkan data dari database).

Pastikan CKEditor diinisialisasi pada form input di halaman admin dashboard jika ada.

5. Konfigurasi Routes:

Definisikan app/Config/Routes.php agar mengarahkan URL ke Controller yang tepat, termasuk route dinamis untuk detail berita (misal: $routes->get('berita/(:segment)', 'Berita::detail/$1');).
