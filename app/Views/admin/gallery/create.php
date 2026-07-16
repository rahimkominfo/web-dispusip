<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Tambah Galeri Kegiatan<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
        <i class="fa-solid fa-house text-sm"></i>
        <span>Dashboard</span>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <span>Media & Galeri</span>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <a href="<?= base_url('admin/gallery') ?>" class="hover:underline">Event Gallery</a>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <span class="font-bold text-primary">Tambah</span>
    </div>
    <h2 class="font-headline-lg text-headline-lg text-primary">Tambah Album Galeri Kegiatan</h2>
</div>

<!-- Validation Error Notifications -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong class="font-bold block mb-1">Gagal menyimpan galeri:</strong>
        <ul class="list-disc pl-5 text-sm">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-6 max-w-2xl">
    <form action="<?= base_url('admin/gallery/store') ?>" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
        <?= csrf_field() ?>
        
        <div class="flex flex-col gap-1">
            <label class="font-label-md text-label-md text-on-surface" for="judul">Judul Event / Kegiatan *</label>
            <input required type="text" name="judul" id="judul" value="<?= old('judul') ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow" placeholder="Contoh: Peringatan Hari Kearsipan Nasional 2026"/>
        </div>

        <div class="flex flex-col gap-1">
            <label class="font-label-md text-label-md text-on-surface" for="deskripsi">Deskripsi Kegiatan</label>
            <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow" placeholder="Tuliskan keterangan singkat mengenai kegiatan ini..."><?= old('deskripsi') ?></textarea>
        </div>

        <!-- Cover Media section -->
        <div class="border-t border-outline-variant pt-4 flex flex-col gap-4">
            <h3 class="font-title-md text-title-md text-primary font-semibold">Foto Sampul Album (Cover)</h3>
            
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="sampul_file">Upload File Sampul *</label>
                <input type="file" name="sampul_file" id="sampul_file" accept="image/*" class="w-full text-on-surface text-sm border border-outline-variant rounded p-2 focus:outline-none"/>
                <p class="text-xs text-on-surface-variant mt-1">Format file: JPG, JPEG, PNG, WEBP. Maksimum: 8MB.</p>
            </div>


        </div>

        <!-- Multiple Photos section -->
        <div class="border-t border-outline-variant pt-4 flex flex-col gap-4">
            <h3 class="font-title-md text-title-md text-primary font-semibold">Foto Kegiatan (Multiple Photos)</h3>
            
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="gallery_files">Pilih Berkas Foto Kegiatan</label>
                <input type="file" name="gallery_files[]" id="gallery_files" accept="image/*" multiple class="w-full text-on-surface text-sm border border-outline-variant rounded p-2 focus:outline-none"/>
                <p class="text-xs text-on-surface-variant mt-1">Anda dapat memilih beberapa foto sekaligus untuk langsung dimasukkan ke dalam album ini.</p>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-outline-variant">
            <button type="submit" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors flex items-center gap-2">
                <i class="fa-solid fa-save text-sm"></i> Simpan Galeri
            </button>
            <a href="<?= base_url('admin/gallery') ?>" class="border border-outline text-on-surface-variant hover:bg-surface-container-low rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
