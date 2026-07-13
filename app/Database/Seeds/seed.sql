-- Clean up existing data to avoid duplicate key errors
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE trn_komentar;
TRUNCATE TABLE trn_artikel_kategori;
TRUNCATE TABLE trn_artikel_tags;
TRUNCATE TABLE trn_artikel;
TRUNCATE TABLE sys_users;
TRUNCATE TABLE sys_peran;
TRUNCATE TABLE mst_kategori;
TRUNCATE TABLE mst_tags;
TRUNCATE TABLE mst_menu;
TRUNCATE TABLE mst_running_text;
TRUNCATE TABLE mst_flyer;
SET FOREIGN_KEY_CHECKS = 1;

-- Seed sys_peran
INSERT INTO sys_peran (peran_id, nama_peran, deskripsi, created_at)
VALUES (1, 'Admin', 'Administrator Utama', NOW());

-- Seed sys_users (password is BCRYPT for 'admin123')
INSERT INTO sys_users (user_id, user_uuid, username, email, password, nama_publik, peran_id, tanggal_daftar)
VALUES (1, 'user-uuid-1111-2222-333333333333', 'admin', 'admin@sinjaikab.go.id', '$2y$10$wE99Y0gN9KpeA4uQ.t4XqOqGf.uWlD2k3eI9fP2L581r9/r0s2UjG', 'Admin Dispusip', 1, NOW());

-- Seed mst_kategori
INSERT INTO mst_kategori (kategori_id, kategori_uuid, nama, slug, created_at) VALUES
(1, 'cat-uuid-1', 'Layanan Perpustakaan', 'layanan-perpustakaan', NOW()),
(2, 'cat-uuid-2', 'Kearsipan Daerah', 'kearsipan-daerah', NOW()),
(3, 'cat-uuid-3', 'Kegiatan & Event', 'kegiatan-event', NOW()),
(4, 'cat-uuid-4', 'Pengumuman Resmi', 'pengumuman-resmi', NOW());

-- Seed mst_tags
INSERT INTO mst_tags (tag_id, nama, slug, created_at) VALUES
(1, 'Buku', 'buku', NOW()),
(2, 'ArsipDigital', 'arsip-digital', NOW()),
(3, 'Literasi', 'literasi', NOW()),
(4, 'Pusda', 'pusda', NOW()),
(5, 'Bimtek', 'bimtek', NOW());

-- Seed trn_artikel
INSERT INTO trn_artikel (artikel_id, artikel_uuid, judul, slug, konten, gambar_utama, abstrak, user_id, status, jumlah_tayang, tanggal_publikasi) VALUES
(1, 'art-uuid-1', 'Sosialisasi Pengelolaan Arsip Dinamis bagi Perangkat Daerah', 'sosialisasi-pengelolaan-arsip-dinamis-bagi-perangkat-daerah', 'Dinas Perpustakaan dan Kearsipan (DISPUSIP) kembali menggelar bimbingan teknis terkait tata kelola arsip dinamis guna meningkatkan tertib administrasi di lingkungan pemerintah daerah.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDKuc1YVx63XSCbNRB-Cj4lL08IK-H6oeZJ0Li9Q-YvJVoacLh7iiKlqG8kRKTC9GSDAFmDBMDQ4I9oHcXVrzQFIfE5Co4ISKyeZ8ZmLuPK9_JlIVvD6F22Z2fRuM3O--hIGVWhTPAwg92YO29q3bMuyAd6mtH9vHGaEEjavGi2zKG3U7o88ODe9_kLyOBp6vQUAgjKqWhW1r2KuZmihntCDHRizoryis478y2v64RfhUfygW66YYdn-A', 'Dinas Perpustakaan dan Kearsipan (DISPUSIP) kembali menggelar bimbingan teknis terkait tata kelola arsip dinamis guna meningkatkan tertib administrasi di lingkungan pemerintah daerah.', 1, 'Ditayangkan', 120, '2026-07-08 12:00:00'),
(2, 'art-uuid-2', 'Pojok Baca Digital (POCADI) Resmi Beroperasi di Ruang Publik', 'pojok-baca-digital-pocadi-resmi-beroperasi-di-ruang-publik', 'Upaya peningkatan literasi masyarakat terus dilakukan dengan menyediakan fasilitas Pojok Baca Digital yang dapat diakses secara gratis di berbagai area publik strategis.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBMB6fFNjcO_0-RXxhw-q3Z0k2J4OaPmnC4fnG1XnQEQu7qdmr3dGD_530YILIPVsmgQvKiVQ_wbr_cdUuM8PoRknYLodqxJexTMFCcIqSZCk1esXKTLcpz1gAX0kjnleJTyGiG4W6NhZrrMJFaANOGZzB5XWZojYD-SY71IdoDbqThNZNr4iPuFKwGhNiDP-i5rxRsa86Hb983qVnByikXyXeHfA2FDDv123uq_RPWRXEvNtO-z78R3w', 'Upaya peningkatan literasi masyarakat terus dilakukan dengan menyediakan fasilitas Pojok Baca Digital yang dapat diakses secara gratis di berbagai area publik strategis.', 1, 'Ditayangkan', 98, '2026-07-07 10:00:00'),
(3, 'art-uuid-3', 'Peringatan Hari Kunjung Perpustakaan 2023 Berlangsung Meriah', 'peringatan-hari-kunjung-perpustakaan-2023-berlangsung-meriah', 'Rangkaian acara mulai dari bedah buku, lomba bercerita, hingga pameran arsip sejarah lokal sukses menarik perhatian ribuan pengunjung dari berbagai kalangan pelajar.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBKN6fXME_KAgNglBLG8jFr5234v0y4DUZTeZI-BXUsuq7kfunImTsdMl-cRA6NXJWNc2c28fHUK2mB7RpzqhCxUBcLPG8FKlNfvW94TS3LStbRbhvWWpYLKPLmMbMo-rAtvMp4lGkqkVLzurKOv_np75IWhJkvwpKtcbioNEaNELlTd4qKSBpwXX2Q7UcAI6Wowea-yWwV_3bqQqNidHVRC-1RfWDng32YFFZ_u1ulix7EdH3b3TpQwQ', 'Rangkaian acara mulai dari bedah buku, lomba bercerita, hingga pameran arsip sejarah lokal sukses menarik perhatian ribuan pengunjung dari berbagai kalangan pelajar.', 1, 'Ditayangkan', 245, '2026-07-06 09:00:00'),
(4, 'art-uuid-4', 'Dispusip Lakukan Digitalisasi Arsip Kuno', 'dispusip-lakukan-digitalisasi-arsip-kuno', 'Dinas Perpustakaan dan Kearsipan (Dispusip) terus berupaya menjaga kelestarian sejarah melalui program digitalisasi arsip kuno. Langkah ini diambil sebagai respons terhadap rentannya kondisi fisik dokumen-dokumen bersejarah yang termakan usia, serta untuk mempermudah aksesibilitas bagi peneliti dan masyarakat umum. <br><br> "Dokumen-dokumen ini adalah saksi bisu perjalanan daerah kita. Jika fisiknya hancur, maka sebagian sejarah kita akan hilang selamanya. Digitalisasi adalah solusi terbaik untuk pelestarian jangka panjang," ungkap Kepala Dispusip dalam sambutannya pada acara peresmian ruang digitalisasi baru. <br><br> Proses digitalisasi ini melibatkan pemindaian resolusi tinggi menggunakan perangkat khusus yang tidak merusak lembaran kertas rapuh. Setelah dipindai, file digital akan melalui proses restorasi warna secara virtual and pengindeksan metadata untuk memudahkan pencarian di basis data publik yang rencananya akan diluncurkan tahun depan. <br><br> Diharapkan, dengan beralihnya arsip ke format digital, masyarakat tidak perlu lagi bersentuhan langsung dengan dokumen asli yang rapuh, sehingga umur dokumen fisik dapat diperpanjang secara signifikan.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDg6N8Mx_XHuVFCvWzCTSXpIIaSRxvPwBCaUv4UKeUwBEPcnUE0W_2RBUwrYUHscs6SCKIHglxIL_VIoBG0hV2li-COFXR4RSP8BEBIxcs2qVSzSM6txkzUiQWTPAYSGTTX1mZTXv-ewTnJWZXfhgy75idAaA81OV1ywYWfeTrsEvobtQsbKsEMGKhJTHa_siIM39Fe4ul-RaTrWJon91ty9iQ1MeN2jUo1e-mxzT57jRLOLLx-Kl_zpA', 'Dinas Perpustakaan dan Kearsipan (Dispusip) terus berupaya menjaga kelestarian sejarah melalui program digitalisasi arsip kuno.', 1, 'Ditayangkan', 1245, '2026-07-08 08:00:00'),
(5, 'art-uuid-5', 'Pentingnya Digitalisasi Arsip Kuno di Era Modern', 'pentingnya-digitalisasi-arsip-kuno-di-era-modern', 'Digitalisasi arsip kuno sangat penting untuk pelestarian budaya bangsa. Dengan digitalisasi, akses sejarah menjadi lebih mudah dan cepat.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuD2iS37dvyBCBUdcIShSxl3vJVFsM1nKHpVTU8A6LWrFqu8Kx1-WDkShjY17AoINs-55xSrrQEBvqJB_JmhSJExEgBfIbnvgp1WIKAhVue22ryDfmkQrCu0Qr51oHJVPUNnCa4W8t5AC2NuzPs9pFE74JlWPwAl6tY55Kdam_BZpkJf23x13tIzwUB7LvHvebjRTggHf7iZWe4lT614RNYWlDIdHTr2gg2vuiR-_rkxulcYgjNmATRkzg', 'Digitalisasi arsip kuno sangat penting untuk pelestarian budaya bangsa.', 1, 'Ditayangkan', 1245, '2026-07-08 08:15:00'),
(6, 'art-uuid-6', 'Cara Mudah Mendaftar Keanggotaan Perpustakaan Daerah', 'cara-mudah-mendaftar-keanggotaan-perpustakaan-daerah', 'Masyarakat kini bisa mendaftar keanggotaan perpustakaan secara online melalui aplikasi atau web resmi Dispusip.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuCxgyemN4iKt782HpTchol2fqbhHvA-JMvyCltrLReh1IiUaOlO0f72tPzB2Oj1tOcrexQhvy3XqqTnGN-eSta4mArYsTXpeph5DGrd-moMSxVk0tTgC79xAT37Ie00aMd4jQilA4VWbLE1UWdj14hTzDbIJW0QWoFW8aNFucPNxcc2EchLtcMZuRT_ISAdlXtISdBBGM4-QrLeU7_W6V6mOzMEWojG2jnGKRWr3dNXFzAeDkoGiD7p6Q', 'Masyarakat kini bisa mendaftar keanggotaan perpustakaan secara online.', 1, 'Ditayangkan', 982, '2026-07-07 15:00:00'),
(7, 'art-uuid-7', 'Draft Rapat Koordinasi Tahunan', 'draft-rapat-koordinasi-tahunan', 'Konten draf rapat koordinasi tahunan dispusip.', NULL, 'Konten draf rapat koordinasi tahunan dispusip.', 1, 'Draf', 0, '2026-07-09 10:00:00');

-- Seed trn_artikel_kategori
INSERT INTO trn_artikel_kategori (artikel_id, kategori_id) VALUES
(1, 2), -- Article 1 -> Kearsipan Daerah
(2, 1), -- Article 2 -> Layanan Perpustakaan
(3, 3), -- Article 3 -> Kegiatan & Event
(4, 2), -- Article 4 -> Kearsipan Daerah
(5, 2), -- Article 5 -> Kearsipan Daerah
(6, 1), -- Article 6 -> Layanan Perpustakaan
(7, 4); -- Article 7 -> Pengumuman Resmi

-- Seed trn_artikel_tags
INSERT INTO trn_artikel_tags (artikel_id, tag_id) VALUES
(1, 5), -- Article 1 -> #Bimtek
(2, 3), -- Article 2 -> #Literasi
(3, 1), -- Article 3 -> #Buku
(3, 3), -- Article 3 -> #Literasi
(4, 2), -- Article 4 -> #ArsipDigital
(5, 2), -- Article 5 -> #ArsipDigital
(6, 3); -- Article 6 -> #Literasi

-- Seed trn_komentar
INSERT INTO trn_komentar (komentar_id, artikel_id, nama_pengunjung, email_pengunjung, isi_komentar, status, komentar_induk_id, created_at) VALUES
(1, 4, 'Budi (Masyarakat)', 'budi@gmail.com', 'Wah bagus sekali program ini, sukses!', 'Disetujui', NULL, '2026-07-08 09:00:00'),
(2, 4, 'Admin Dispusip', 'admin@sinjaikab.go.id', 'Terima kasih Pak Budi dukungannya.', 'Disetujui', 1, '2026-07-08 09:30:00'),
(3, 1, 'Budi', 'budi@gmail.com', 'Pertunjukan yang bagus.', 'Disetujui', NULL, '2026-07-08 09:00:00');

-- Seed mst_menu
INSERT INTO mst_menu (id, parent_id, title, url, sort_order, is_active, created_at) VALUES
(1, NULL, 'Home', 'home', 1, 1, NOW()),
(2, NULL, 'Profil', 'profil', 2, 1, NOW()),
(3, NULL, 'Berita & Artikel', 'berita', 3, 1, NOW()),
(4, NULL, 'Galeri Kegiatan', 'galeri', 4, 1, NOW()),
(5, NULL, 'Halaman Statis', 'halaman', 5, 1, NOW()),
(6, NULL, 'Kontak', 'kontak', 6, 1, NOW());

-- Seed mst_running_text
INSERT INTO mst_running_text (id, teks, is_active, created_at) VALUES
(1, 'Selamat Datang di Portal Resmi Dinas Perpustakaan & Kearsipan - Layanan Perpustakaan buka pukul 08.00 - 16.00 WIB', 1, NOW());

-- Seed mst_flyer
INSERT INTO mst_flyer (flayer_id, uuid, judul, gambar_url, label, status, urutan, created_at) VALUES
(1, 'flyer-uuid-1', 'Transformasi Digital Kearsipan untuk Masa Depan', 'hero_banner.jpg', 'Kearsipan', 'Aktif', 1, NOW());
