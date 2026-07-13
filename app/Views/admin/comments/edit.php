<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Edit Komentar<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
        <span class="material-symbols-outlined text-sm" data-icon="home">home</span>
        <span>Dashboard</span>
        <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
        <span>Manajemen Konten</span>
        <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
        <a href="<?= base_url('admin/comments') ?>" class="hover:underline">Comments</a>
        <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
        <span class="font-bold text-primary">Edit</span>
    </div>
    <h2 class="font-headline-lg text-headline-lg text-primary">Edit Komentar Pengunjung</h2>
</div>

<!-- Validation Error Notifications -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong class="font-bold block mb-1">Gagal menyimpan komentar:</strong>
        <ul class="list-disc pl-5 text-sm">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-6 max-w-2xl">
    <form action="<?= base_url('admin/comments/update/' . $comment['komentar_id']) ?>" method="POST" class="flex flex-col gap-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="nama_pengunjung">Nama Pengunjung *</label>
                <input required type="text" name="nama_pengunjung" id="nama_pengunjung" value="<?= old('nama_pengunjung', esc($comment['nama_pengunjung'])) ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow"/>
            </div>

            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="email_pengunjung">Email Pengunjung</label>
                <input type="email" name="email_pengunjung" id="email_pengunjung" value="<?= old('email_pengunjung', esc($comment['email_pengunjung'])) ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow"/>
            </div>
        </div>

        <div class="flex flex-col gap-1">
            <label class="font-label-md text-label-md text-on-surface" for="status">Status Moderasi *</label>
            <select required name="status" id="status" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow">
                <option value="Menunggu" <?= old('status', esc($comment['status'])) == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                <option value="Disetujui" <?= old('status', esc($comment['status'])) == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                <option value="Spam" <?= old('status', esc($comment['status'])) == 'Spam' ? 'selected' : '' ?>>Spam</option>
            </select>
        </div>

        <div class="flex flex-col gap-1">
            <label class="font-label-md text-label-md text-on-surface" for="isi_komentar">Isi Teks Komentar *</label>
            <textarea required name="isi_komentar" id="isi_komentar" rows="5" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow"><?= old('isi_komentar', esc($comment['isi_komentar'])) ?></textarea>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-outline-variant">
            <button type="submit" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">save</span> Perbarui Komentar
            </button>
            <a href="<?= base_url('admin/comments') ?>" class="border border-outline text-on-surface-variant hover:bg-surface-container-low rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
