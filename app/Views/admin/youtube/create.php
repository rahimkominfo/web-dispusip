<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Tambah Video YouTube<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
        <i class="fa-solid fa-house text-sm"></i>
        <span>Dashboard</span>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <span>Media & Galeri</span>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <a href="<?= base_url('admin/youtube') ?>" class="hover:underline">Youtube</a>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <span class="font-bold text-primary">Tambah</span>
    </div>
    <h2 class="font-headline-lg text-headline-lg text-primary font-bold">Tambah Video YouTube Baru</h2>
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
    <form action="<?= base_url('admin/youtube/store') ?>" method="POST" class="flex flex-col gap-6">
        <?= csrf_field() ?>
        
        <div class="flex flex-col gap-1">
            <label class="font-label-md text-label-md text-on-surface font-semibold" for="judul">Judul Video *</label>
            <input required type="text" name="judul" id="judul" value="<?= old('judul') ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-shadow" placeholder="Masukkan judul video YouTube...">
        </div>

        <div class="flex flex-col gap-1">
            <label class="font-label-md text-label-md text-on-surface font-semibold" for="youtube_id">Video ID / URL YouTube *</label>
            <input required type="text" name="youtube_id" id="youtube_id" value="<?= old('youtube_id') ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-shadow" placeholder="Contoh: dQw4w9WgXcQ atau https://www.youtube.com/watch?v=dQw4w9WgXcQ">
            <span class="text-xs text-on-surface-variant leading-relaxed">Anda dapat memasukkan ID video YouTube (11 karakter) atau menempelkan tautan lengkap video YouTube.</span>
        </div>

        <div class="flex flex-col gap-1">
            <label class="font-label-md text-label-md text-on-surface font-semibold" for="deskripsi">Deskripsi Video</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-shadow" placeholder="Masukkan deskripsi singkat mengenai video..."><?= old('deskripsi') ?></textarea>
        </div>

        <div class="flex flex-col gap-1">
            <label class="font-label-md text-label-md text-on-surface font-semibold" for="status">Status *</label>
            <select required name="status" id="status" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-shadow">
                <option value="Aktif" <?= old('status', 'Aktif') == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="Tidak Aktif" <?= old('status') == 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-outline-variant">
            <button type="submit" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors flex items-center gap-2">
                <i class="fa-solid fa-save text-sm"></i> Simpan Video
            </button>
            <a href="<?= base_url('admin/youtube') ?>" class="border border-outline text-on-surface-variant hover:bg-surface-container-low rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
