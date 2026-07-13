<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Peran (Roles)<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8 flex justify-between items-center flex-wrap gap-4">
    <div>
        <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
            <span class="material-symbols-outlined text-sm" data-icon="home">home</span>
            <span>Dashboard</span>
            <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
            <span class="font-bold text-primary">Peran</span>
        </div>
        <h2 class="font-headline-lg text-headline-lg text-primary">Manajemen Peran (Roles)</h2>
    </div>
    <a href="<?= base_url('admin/roles/create') ?>" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-4 py-2 font-label-md text-label-md font-semibold flex items-center gap-2 transition-colors">
        <span class="material-symbols-outlined text-sm">add</span> Tambah Peran
    </a>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container font-label-md text-label-md text-on-surface-variant border-b border-outline-variant">
                    <th class="p-4 py-3 font-medium w-16">ID</th>
                    <th class="p-4 py-3 font-medium">Nama Peran</th>
                    <th class="p-4 py-3 font-medium">Deskripsi</th>
                    <th class="p-4 py-3 font-medium text-right w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant">
                <?php if (!empty($roles)): ?>
                    <?php foreach ($roles as $role): ?>
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 py-3 font-bold"><?= esc($role['peran_id']) ?></td>
                            <td class="p-4 py-3 font-semibold text-primary"><?= esc($role['nama_peran']) ?></td>
                            <td class="p-4 py-3 text-on-surface-variant text-sm"><?= esc($role['deskripsi'] ?: '-') ?></td>
                            <td class="p-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?= base_url('admin/roles/edit/' . $role['peran_id']) ?>" class="p-1 text-on-surface-variant hover:text-primary transition-colors rounded hover:bg-surface-container" title="Edit">
                                        <span class="material-symbols-outlined text-[20px]" data-icon="edit">edit</span>
                                    </a>
                                    <a href="<?= base_url('admin/roles/delete/' . $role['peran_id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus peran ini?')" class="p-1 text-on-surface-variant hover:text-error transition-colors rounded hover:bg-error-container" title="Hapus">
                                        <span class="material-symbols-outlined text-[20px]" data-icon="delete">delete</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="p-4 text-center text-on-surface-variant">Belum ada peran terdaftar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
