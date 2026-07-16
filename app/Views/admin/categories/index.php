<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Kategori Berita & Artikel<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8 flex justify-between items-center flex-wrap gap-4">
    <div>
        <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
            <i class="fa-solid fa-house text-sm"></i>
            <span>Dashboard</span>
            <i class="fa-solid fa-chevron-right text-sm"></i>
            <span>Manajemen Konten</span>
            <i class="fa-solid fa-chevron-right text-sm"></i>
            <span class="font-bold text-primary">Categories</span>
        </div>
        <h2 class="font-headline-lg text-headline-lg text-primary">Manajemen Kategori Berita & Artikel</h2>
    </div>
    <a href="<?= base_url('admin/categories/create') ?>" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-4 py-2 font-label-md text-label-md font-semibold flex items-center gap-2 transition-colors">
        <i class="fa-solid fa-plus text-sm"></i> Tambah Kategori
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
                    <th class="p-4 py-3 font-medium">Nama Kategori</th>
                    <th class="p-4 py-3 font-medium">Slug URL</th>
                    <th class="p-4 py-3 font-medium">Kategori Induk (Parent)</th>
                    <th class="p-4 py-3 font-medium w-36 text-center">Jumlah Artikel</th>
                    <th class="p-4 py-3 font-medium w-36">Tanggal Dibuat</th>
                    <th class="p-4 py-3 font-medium text-right w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant">
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $cat): ?>
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 py-3 text-on-surface-variant"><?= esc($cat['kategori_id']) ?></td>
                            <td class="p-4 py-3 font-semibold text-primary">
                                <?php if ($cat['kategori_induk_id']): ?>
                                    <span class="text-on-surface-variant font-normal mr-1">└──</span>
                                <?php endif; ?>
                                <?= esc($cat['nama']) ?>
                            </td>
                            <td class="p-4 py-3 text-sm font-mono text-on-surface-variant">/berita?kategori=<?= esc($cat['slug']) ?></td>
                            <td class="p-4 py-3 text-sm">
                                <?php if ($cat['parent_nama']): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-surface-container text-on-surface border border-outline-variant">
                                        <?= esc($cat['parent_nama']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-on-surface-variant text-xs italic">Kategori Utama</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 py-3 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#E8F0FE] text-[#1A73E8]">
                                    <?= esc($cat['artikel_count']) ?> Artikel
                                </span>
                            </td>
                            <td class="p-4 py-3 text-sm text-on-surface-variant"><?= date('d M Y, H:i', strtotime($cat['created_at'])) ?></td>
                            <td class="p-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?= base_url('admin/categories/edit/' . $cat['kategori_id']) ?>" class="p-1 text-on-surface-variant hover:text-primary transition-colors rounded hover:bg-surface-container" title="Edit">
                                        <i class="fa-solid fa-pen text-[20px]"></i>
                                    </a>
                                    <a href="<?= base_url('admin/categories/delete/' . $cat['kategori_id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Sub-kategori di bawahnya akan dialihkan menjadi kategori utama.')" class="p-1 text-on-surface-variant hover:text-error transition-colors rounded hover:bg-error-container" title="Hapus">
                                        <i class="fa-solid fa-trash text-[20px]"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="p-4 text-center text-on-surface-variant">Belum ada kategori berita terdaftar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
