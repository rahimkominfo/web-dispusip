<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Galeri Kegiatan (Event Gallery)<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8 flex justify-between items-center flex-wrap gap-4">
    <div>
        <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
            <i class="fa-solid fa-house text-sm"></i>
            <span>Dashboard</span>
            <i class="fa-solid fa-chevron-right text-sm"></i>
            <span>Media & Galeri</span>
            <i class="fa-solid fa-chevron-right text-sm"></i>
            <span class="font-bold text-primary">Event Gallery</span>
        </div>
        <h2 class="font-headline-lg text-headline-lg text-primary">Galeri Kegiatan (Event Gallery)</h2>
    </div>
    <a href="<?= base_url('admin/gallery/create') ?>" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-4 py-2 font-label-md text-label-md font-semibold flex items-center gap-2 transition-colors">
        <i class="fa-solid fa-plus text-sm"></i> Tambah Galeri
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
                    <th class="p-4 py-3 font-medium w-24">Cover</th>
                    <th class="p-4 py-3 font-medium">Judul Event (Album)</th>
                    <th class="p-4 py-3 font-medium">Deskripsi Singkat</th>
                    <th class="p-4 py-3 font-medium w-24 text-center">Jumlah Foto</th>
                    <th class="p-4 py-3 font-medium w-36">Tanggal Dibuat</th>
                    <th class="p-4 py-3 font-medium text-right w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant">
                <?php if (!empty($galleries)): ?>
                    <?php foreach ($galleries as $gallery): ?>
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 py-3">
                                <?php if (!empty($gallery['sampul_url'])): ?>
                                    <img src="<?= esc($gallery['sampul_url']) ?>" alt="Cover" class="w-16 h-12 object-cover rounded border border-outline-variant shadow-sm" onerror="this.src='<?= base_url('img/logo.png') ?>'; this.className='w-10 h-10 object-contain';"/>
                                <?php else: ?>
                                    <div class="w-16 h-12 bg-surface-container rounded border border-outline-variant flex items-center justify-center text-xs text-on-surface-variant">No Cover</div>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 py-3">
                                <span class="font-semibold text-primary block"><?= esc($gallery['judul']) ?></span>
                            </td>
                            <td class="p-4 py-3 text-sm text-on-surface-variant max-w-xs truncate">
                                <?= esc($gallery['deskripsi'] ?: 'Tidak ada deskripsi') ?>
                            </td>
                            <td class="p-4 py-3 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#E8F0FE] text-[#1A73E8]">
                                    <?= esc($gallery['image_count']) ?> Foto
                                </span>
                            </td>
                            <td class="p-4 py-3 text-sm text-on-surface-variant"><?= date('d M Y, H:i', strtotime($gallery['created_at'])) ?></td>
                            <td class="p-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?= base_url('admin/gallery/edit/' . $gallery['galeri_id']) ?>" class="p-1 text-on-surface-variant hover:text-primary transition-colors rounded hover:bg-surface-container" title="Edit & Kelola Foto">
                                        <i class="fa-solid fa-pen text-[20px]"></i>
                                    </a>
                                    <a href="<?= base_url('admin/gallery/delete/' . $gallery['galeri_id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus album galeri ini beserta seluruh foto di dalamnya secara permanen?')" class="p-1 text-on-surface-variant hover:text-error transition-colors rounded hover:bg-error-container" title="Hapus Album">
                                        <i class="fa-solid fa-trash text-[20px]"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="p-4 text-center text-on-surface-variant">Belum ada album galeri kegiatan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
