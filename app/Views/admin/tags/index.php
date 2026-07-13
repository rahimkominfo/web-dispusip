<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Tags Artikel<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8 flex justify-between items-center flex-wrap gap-4">
    <div>
        <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
            <span class="material-symbols-outlined text-sm" data-icon="home">home</span>
            <span>Dashboard</span>
            <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
            <span>Manajemen Konten</span>
            <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
            <span class="font-bold text-primary">Tags</span>
        </div>
        <h2 class="font-headline-lg text-headline-lg text-primary">Manajemen Tags Artikel</h2>
    </div>
    <a href="<?= base_url('admin/tags/create') ?>" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-4 py-2 font-label-md text-label-md font-semibold flex items-center gap-2 transition-colors">
        <span class="material-symbols-outlined text-sm">add</span> Tambah Tag
    </a>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm overflow-hidden max-w-4xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container font-label-md text-label-md text-on-surface-variant border-b border-outline-variant">
                    <th class="p-4 py-3 font-medium w-16">ID</th>
                    <th class="p-4 py-3 font-medium">Nama Tag</th>
                    <th class="p-4 py-3 font-medium">Slug URL</th>
                    <th class="p-4 py-3 font-medium w-36 text-center">Artikel Terkait</th>
                    <th class="p-4 py-3 font-medium w-36">Tanggal Dibuat</th>
                    <th class="p-4 py-3 font-medium text-right w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant">
                <?php if (!empty($tags)): ?>
                    <?php foreach ($tags as $tag): ?>
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 py-3 text-on-surface-variant"><?= esc($tag['tag_id']) ?></td>
                            <td class="p-4 py-3 font-semibold text-primary">
                                <span class="inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm text-on-surface-variant">tag</span>
                                    <?= esc($tag['nama']) ?>
                                </span>
                            </td>
                            <td class="p-4 py-3 text-sm font-mono text-on-surface-variant">/berita?tag=<?= esc($tag['slug']) ?></td>
                            <td class="p-4 py-3 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#E8F0FE] text-[#1A73E8]">
                                    <?= esc($tag['artikel_count']) ?> Artikel
                                </span>
                            </td>
                            <td class="p-4 py-3 text-sm text-on-surface-variant"><?= date('d M Y, H:i', strtotime($tag['created_at'])) ?></td>
                            <td class="p-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?= base_url('admin/tags/edit/' . $tag['tag_id']) ?>" class="p-1 text-on-surface-variant hover:text-primary transition-colors rounded hover:bg-surface-container" title="Edit">
                                        <span class="material-symbols-outlined text-[20px]" data-icon="edit">edit</span>
                                    </a>
                                    <a href="<?= base_url('admin/tags/delete/' . $tag['tag_id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus tag ini secara permanen?')" class="p-1 text-on-surface-variant hover:text-error transition-colors rounded hover:bg-error-container" title="Hapus">
                                        <span class="material-symbols-outlined text-[20px]" data-icon="delete">delete</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="p-4 text-center text-on-surface-variant">Belum ada tag artikel terdaftar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
