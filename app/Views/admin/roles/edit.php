<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Edit Peran<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
        <i class="fa-solid fa-house text-sm"></i>
        <span>Dashboard</span>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <a href="<?= base_url('admin/roles') ?>" class="hover:underline">Peran</a>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <span class="font-bold text-primary">Edit</span>
    </div>
    <h2 class="font-headline-lg text-headline-lg text-primary">Edit Peran: <?= esc($role['nama_peran']) ?></h2>
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
    <form action="<?= base_url('admin/roles/update/' . $role['peran_id']) ?>" method="POST" class="flex flex-col gap-6">
        <?= csrf_field() ?>
        
        <div class="flex flex-col gap-1">
            <label class="font-label-md text-label-md text-on-surface" for="nama_peran">Nama Peran *</label>
            <input required type="text" name="nama_peran" id="nama_peran" value="<?= old('nama_peran', $role['nama_peran']) ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow" placeholder="Misal: Redaktur, Pengamat"/>
        </div>

        <div class="flex flex-col gap-1">
            <label class="font-label-md text-label-md text-on-surface" for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow resize-y" placeholder="Deskripsikan peran ini..."><?= old('deskripsi', $role['deskripsi']) ?></textarea>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-outline-variant">
            <button type="submit" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors flex items-center gap-2">
                <i class="fa-solid fa-save text-sm"></i> Simpan Perubahan
            </button>
            <a href="<?= base_url('admin/roles') ?>" class="border border-outline text-on-surface-variant hover:bg-surface-container-low rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
