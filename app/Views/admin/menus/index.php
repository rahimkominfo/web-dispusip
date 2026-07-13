<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Menu Navigasi<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8 flex justify-between items-center flex-wrap gap-4">
    <div>
        <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
            <span class="material-symbols-outlined text-sm" data-icon="home">home</span>
            <span>Dashboard</span>
            <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
            <span>Halaman & Tampilan</span>
            <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
            <span class="font-bold text-primary">Manajemen Menu</span>
        </div>
        <h2 class="font-headline-lg text-headline-lg text-primary">Manajemen Menu Navigasi</h2>
    </div>
    <a href="<?= base_url('admin/menus/create') ?>" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-4 py-2 font-label-md text-label-md font-semibold flex items-center gap-2 transition-colors">
        <span class="material-symbols-outlined text-sm">add</span> Tambah Menu
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
                    <th class="p-4 py-3 font-medium">Label Menu (Title)</th>
                    <th class="p-4 py-3 font-medium">URL</th>
                    <th class="p-4 py-3 font-medium">Menu Induk (Parent)</th>
                    <th class="p-4 py-3 font-medium w-24">Urutan</th>
                    <th class="p-4 py-3 font-medium w-28">Status</th>
                    <th class="p-4 py-3 font-medium text-right w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant">
                <?php if (!empty($menus)): ?>
                    <?php foreach ($menus as $item): ?>
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 py-3 text-on-surface-variant"><?= esc($item['id']) ?></td>
                            <td class="p-4 py-3 font-semibold text-primary">
                                <?php if ($item['parent_id']): ?>
                                    <span class="text-on-surface-variant font-normal mr-1">└──</span>
                                <?php endif; ?>
                                <?= esc($item['title']) ?>
                            </td>
                            <td class="p-4 py-3 text-sm font-mono text-on-surface-variant"><?= esc($item['url']) ?></td>
                            <td class="p-4 py-3 text-sm">
                                <?php if ($item['parent_title']): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-surface-container text-on-surface border border-outline-variant">
                                        <?= esc($item['parent_title']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-on-surface-variant text-xs italic">Menu Utama</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 py-3 text-center font-medium"><?= esc($item['sort_order']) ?></td>
                            <td class="p-4 py-3">
                                <?php if ($item['is_active'] == 1): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#E6F4EA] text-[#137333] border border-[#137333]/10">
                                        Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#FCE8E6] text-[#C5221F] border border-[#C5221F]/10">
                                        Tidak Aktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?= base_url('admin/menus/edit/' . $item['id']) ?>" class="p-1 text-on-surface-variant hover:text-primary transition-colors rounded hover:bg-surface-container" title="Edit">
                                        <span class="material-symbols-outlined text-[20px]" data-icon="edit">edit</span>
                                    </a>
                                    <a href="<?= base_url('admin/menus/delete/' . $item['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini? Semua sub-menu di bawahnya akan dialihkan menjadi menu utama.')" class="p-1 text-on-surface-variant hover:text-error transition-colors rounded hover:bg-error-container" title="Hapus">
                                        <span class="material-symbols-outlined text-[20px]" data-icon="delete">delete</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="p-4 text-center text-on-surface-variant">Belum ada menu navigasi terdaftar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
