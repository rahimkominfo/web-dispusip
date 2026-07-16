<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Tambah Halaman Statis<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
        <i class="fa-solid fa-house text-sm"></i>
        <span>Dashboard</span>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <span>Halaman & Tampilan</span>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <a href="<?= base_url('admin/pages') ?>" class="hover:underline">Static Pages</a>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <span class="font-bold text-primary">Tambah</span>
    </div>
    <h2 class="font-headline-lg text-headline-lg text-primary">Tambah Halaman Baru</h2>
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

<div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-6">
    <form action="<?= base_url('admin/pages/store') ?>" method="POST" class="flex flex-col gap-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="judul">Judul Halaman *</label>
                <input required type="text" name="judul" id="judul" value="<?= old('judul') ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow" placeholder="Contoh: Profil Dinas, Sejarah, dsb."/>
            </div>
            
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="status">Status Rilis *</label>
                <select required name="status" id="status" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow">
                    <option value="Draf" <?= old('status') == 'Draf' ? 'selected' : '' ?>>Draf</option>
                    <option value="Diterbitkan" <?= old('status', 'Diterbitkan') == 'Diterbitkan' ? 'selected' : '' ?>>Diterbitkan</option>
                </select>
            </div>
        </div>

        <div class="flex flex-col gap-1">
            <label class="font-label-md text-label-md text-on-surface" for="editor">Konten / Isi Halaman</label>
            <div class="ck-editor-container">
                <textarea name="konten" id="editor" rows="12" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow editor"><?= old('konten') ?></textarea>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-outline-variant">
            <button type="submit" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors flex items-center gap-2">
                <i class="fa-solid fa-save text-sm"></i> Simpan Halaman
            </button>
            <a href="<?= base_url('admin/pages') ?>" class="border border-outline text-on-surface-variant hover:bg-surface-container-low rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
