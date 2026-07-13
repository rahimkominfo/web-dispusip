# Rekomendasi Ukuran Banner Hero Section - DISPUSIP Sinjai

Dokumen ini berisi spesifikasi ukuran gambar/banner yang disiapkan secara responsif untuk Hero Section pada halaman utama portal Dinas Perpustakaan dan Kearsipan (Dispusip) Sinjai.

Menggunakan pendekatan responsif terpisah (desktop, tablet, mobile) memastikan visual tetap tajam, teks tidak terpotong, dan performa pemuatan halaman (load speed) optimal karena ukuran file yang disesuaikan untuk perangkat mobile lebih kecil.

---

## 📐 Spesifikasi Dimensi & Rasio Aspek

| Tipe Perangkat | Resolusi Rekomendasi (Px) | Rasio Aspek (Aspect Ratio) | Deskripsi Penggunaan |
| :--- | :---: | :---: | :--- |
| 🖥️ **Desktop** | **1920 × 600** atau **1440 × 450** | ~16:5 | Untuk layar laptop dan monitor desktop (lebar). |
| 📁 **Tablet** | **1024 × 450** | ~9:4 | Untuk perangkat tablet (iPad, Android Tablet) dalam orientasi landscape/portrait lebar. |
| 📱 **Mobile** | **640 × 480** atau **480 × 360** | 4:3 / 4:3 | Untuk smartphone (Android, iPhone) agar tampilan gambar lebih proporsional (tinggi) dan teks terbaca jelas. |

---

## 📂 Lokasi Penyimpanan Gambar

Gambar hero responsif disimpan secara statis pada direktori berikut:

1. **Desktop**: `public/img/hero-desktop.jpg`
2. **Tablet**: `public/img/hero-tablet.jpg`
3. **Mobile**: `public/img/hero-mobile.jpg`

---

## 💡 Panduan Desain & Optimasi Banner

1. **Format Gambar**: Gunakan format **WebP** untuk kompresi terbaik tanpa mengurangi kualitas visual secara signifikan. Alternatifnya adalah format **JPEG/JPG** dengan optimasi kompresi ~80%.
2. **Fokus Visual (Focal Point)**: Pastikan objek visual utama di dalam gambar diletakkan di **tengah kanan** (untuk desktop) agar tidak tertutup oleh teks overlay yang berada di sebelah kiri.
3. **Optimasi Kontras / Overlay**: Gunakan overlay gradasi gelap di sebelah kiri (melalui CSS gradient pada kode program) agar teks putih tetap kontras dan mudah dibaca (accessible).
