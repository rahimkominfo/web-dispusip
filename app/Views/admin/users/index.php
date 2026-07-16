<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Pengguna (Users)<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8 flex justify-between items-center flex-wrap gap-4">
    <div>
        <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
            <i class="fa-solid fa-house text-sm"></i>
            <span>Dashboard</span>
            <i class="fa-solid fa-chevron-right text-sm"></i>
            <span class="font-bold text-primary">Pengguna</span>
        </div>
        <h2 class="font-headline-lg text-headline-lg text-primary">Manajemen Pengguna (Users)</h2>
    </div>
    <a href="<?= base_url('admin/users/create') ?>" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-4 py-2 font-label-md text-label-md font-semibold flex items-center gap-2 transition-colors">
        <i class="fa-solid fa-plus text-sm"></i> Tambah Pengguna
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
                    <th class="p-4 py-3 font-medium">Nama Publik</th>
                    <th class="p-4 py-3 font-medium">Username</th>
                    <th class="p-4 py-3 font-medium">Email</th>
                    <th class="p-4 py-3 font-medium">Peran (Role)</th>
                    <th class="p-4 py-3 font-medium text-right w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant">
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 py-3 font-semibold text-primary">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-fixed text-primary flex items-center justify-center font-bold text-sm shrink-0">
                                        <?= strtoupper(substr(esc($user['nama_publik']), 0, 1)) ?>
                                    </div>
                                    <span><?= esc($user['nama_publik']) ?></span>
                                </div>
                            </td>
                            <td class="p-4 py-3"><?= esc($user['username']) ?></td>
                            <td class="p-4 py-3 text-sm text-on-surface-variant"><?= esc($user['email']) ?></td>
                            <td class="p-4 py-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#E6F4EA] text-[#137333] border border-[#137333]/10">
                                    <?= esc($user['nama_peran'] ?: 'Tanpa Peran') ?>
                                </span>
                            </td>
                            <td class="p-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?= base_url('admin/users/edit/' . $user['user_id']) ?>" class="p-1 text-on-surface-variant hover:text-primary transition-colors rounded hover:bg-surface-container" title="Edit">
                                        <i class="fa-solid fa-pen text-[20px]"></i>
                                    </a>
                                    <a href="<?= base_url('admin/users/delete/' . $user['user_id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')" class="p-1 text-on-surface-variant hover:text-error transition-colors rounded hover:bg-error-container" title="Hapus">
                                        <i class="fa-solid fa-trash text-[20px]"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="p-4 text-center text-on-surface-variant">Belum ada pengguna terdaftar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
