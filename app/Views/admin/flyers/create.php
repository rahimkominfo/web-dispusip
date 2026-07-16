<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Tambah Banner/Flyer<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
        <i class="fa-solid fa-house text-sm"></i>
        <span>Dashboard</span>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <span>Halaman & Tampilan</span>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <a href="<?= base_url('admin/flyers') ?>" class="hover:underline">Banner/Flyer</a>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <span class="font-bold text-primary">Tambah</span>
    </div>
    <h2 class="font-headline-lg text-headline-lg text-primary">Tambah Banner/Flyer Baru</h2>
</div>

<!-- Validation Error Notifications -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong class="font-bold block mb-1">Gagal menyimpan data:</strong>
        <ul class="list-disc pl-5 text-sm">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-6 max-w-2xl">
    <form action="<?= base_url('admin/flyers/store') ?>" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="judul">Judul Banner/Flyer *</label>
                <input required type="text" name="judul" id="judul" value="<?= old('judul') ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow" placeholder="Contoh: Transformasi Digital Kearsipan"/>
            </div>
            
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="label">Label Banner / Kategori</label>
                <input type="text" name="label" id="label" value="<?= old('label') ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow" placeholder="Contoh: Kearsipan, Perpustakaan"/>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="urutan">Nomor Urutan Tampil *</label>
                <input required type="number" min="0" name="urutan" id="urutan" value="<?= old('urutan', '1') ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow"/>
            </div>

            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="status">Status Aktif *</label>
                <select required name="status" id="status" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow">
                    <option value="Aktif" <?= old('status', 'Aktif') == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="Tidak Aktif" <?= old('status') == 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                </select>
            </div>
        </div>

        <div class="border-t border-outline-variant pt-4 flex flex-col gap-4">
            <h3 class="font-title-md text-title-md text-primary font-semibold">Media Flyer / Banner</h3>
            
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="gambar_file">Upload File Gambar (Rekomendasi) *</label>
                <input type="file" name="gambar_file" id="gambar_file" accept="image/*" class="w-full text-on-surface text-sm border border-outline-variant rounded p-2 focus:outline-none"/>
                <p class="text-xs text-on-surface-variant mt-1">Format file: JPG, JPEG, PNG, WEBP. Maksimum: 8MB.</p>
            </div>


        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-outline-variant">
            <button type="submit" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors flex items-center gap-2">
                <i class="fa-solid fa-save text-sm"></i> Simpan Banner/Flyer
            </button>
            <a href="<?= base_url('admin/flyers') ?>" class="border border-outline text-on-surface-variant hover:bg-surface-container-low rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
