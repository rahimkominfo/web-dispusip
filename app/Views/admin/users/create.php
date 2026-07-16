<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Tambah Pengguna<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
        <i class="fa-solid fa-house text-sm"></i>
        <span>Dashboard</span>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <a href="<?= base_url('admin/users') ?>" class="hover:underline">Pengguna</a>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <span class="font-bold text-primary">Tambah</span>
    </div>
    <h2 class="font-headline-lg text-headline-lg text-primary">Tambah Pengguna Baru</h2>
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
    <form action="<?= base_url('admin/users/store') ?>" method="POST" class="flex flex-col gap-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="username">Username *</label>
                <input required type="text" name="username" id="username" value="<?= old('username') ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow" placeholder="Username untuk login"/>
            </div>
            
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="email">Alamat Email *</label>
                <input required type="email" name="email" id="email" value="<?= old('email') ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow" placeholder="contoh@domain.com"/>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="nama_publik">Nama Publik / Lengkap *</label>
                <input required type="text" name="nama_publik" id="nama_publik" value="<?= old('nama_publik') ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow" placeholder="Nama lengkap staf"/>
            </div>

            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="peran_id">Peran (Role) *</label>
                <select required name="peran_id" id="peran_id" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow">
                    <option value="">Pilih Peran...</option>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= esc($role['peran_id']) ?>" <?= old('peran_id') == $role['peran_id'] ? 'selected' : '' ?>><?= esc($role['nama_peran']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="flex flex-col gap-1">
            <label class="font-label-md text-label-md text-on-surface" for="password">Password *</label>
            <input required type="password" name="password" id="password" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow" placeholder="Minimal 6 karakter"/>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-outline-variant">
            <button type="submit" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors flex items-center gap-2">
                <i class="fa-solid fa-save text-sm"></i> Simpan Pengguna
            </button>
            <a href="<?= base_url('admin/users') ?>" class="border border-outline text-on-surface-variant hover:bg-surface-container-low rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
