<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Berita & Artikel<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8 flex justify-between items-center flex-wrap gap-4">
    <div>
        <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
            <span class="material-symbols-outlined text-sm" data-icon="home">home</span>
            <span>Dashboard</span>
            <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
            <span>Manajemen Konten</span>
            <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
            <span class="font-bold text-primary">News</span>
        </div>
        <h2 class="font-headline-lg text-headline-lg text-primary">Manajemen Berita & Artikel</h2>
    </div>
    <a href="<?= base_url('admin/news/create') ?>" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-4 py-2 font-label-md text-label-md font-semibold flex items-center gap-2 transition-colors">
        <span class="material-symbols-outlined text-sm">add</span> Tulis Berita
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
                    <th class="p-4 py-3 font-medium">Judul Berita</th>
                    <th class="p-4 py-3 font-medium">Kategori</th>
                    <th class="p-4 py-3 font-medium">Penulis</th>
                    <th class="p-4 py-3 font-medium w-24 text-center">Dibaca</th>
                    <th class="p-4 py-3 font-medium w-36">Tanggal Rilis</th>
                    <th class="p-4 py-3 font-medium w-32">Status</th>
                    <th class="p-4 py-3 font-medium text-right w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant">
                <?php if (!empty($articles)): ?>
                    <?php foreach ($articles as $art): ?>
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 py-3">
                                <?php if (!empty($art['gambar_utama'])): ?>
                                    <img src="<?= esc($art['gambar_utama']) ?>" alt="Cover" class="w-16 h-12 object-cover rounded border border-outline-variant shadow-sm" onerror="this.src='<?= base_url('img/logo.png') ?>'; this.className='w-10 h-10 object-contain';"/>
                                <?php else: ?>
                                    <div class="w-16 h-12 bg-surface-container rounded border border-outline-variant flex items-center justify-center text-xs text-on-surface-variant">No Image</div>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 py-3">
                                <span class="font-semibold text-primary block"><?= esc($art['judul']) ?></span>
                                <span class="text-xs text-on-surface-variant font-mono block mt-0.5"><?= esc($art['slug']) ?></span>
                            </td>
                            <td class="p-4 py-3 text-sm">
                                <?php if (!empty($art['categories_list'])): ?>
                                    <span class="text-on-surface font-medium"><?= esc($art['categories_list']) ?></span>
                                <?php else: ?>
                                    <span class="text-on-surface-variant text-xs italic">Tanpa Kategori</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-surface-container text-on-surface">
                                    <?= esc($art['author_name'] ?: 'Staf Dispusip') ?>
                                </span>
                            </td>
                            <td class="p-4 py-3 text-center font-medium text-on-surface-variant">
                                <?= esc($art['jumlah_tayang']) ?>x
                            </td>
                            <td class="p-4 py-3 text-sm text-on-surface-variant">
                                <?= date('d M Y, H:i', strtotime($art['tanggal_publikasi'])) ?>
                            </td>
                            <td class="p-4 py-3">
                                <?php if ($art['status'] === 'Ditayangkan'): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#E6F4EA] text-[#137333] border border-[#137333]/10">
                                        Ditayangkan
                                    </span>
                                <?php elseif ($art['status'] === 'Diarsipkan'): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-surface-container text-on-surface border border-outline-variant">
                                        Diarsipkan
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#FEF7E0] text-[#B06000] border border-[#B06000]/10">
                                        Draf
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?= base_url('admin/news/edit/' . $art['artikel_id']) ?>" class="p-1 text-on-surface-variant hover:text-primary transition-colors rounded hover:bg-surface-container" title="Edit">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </a>
                                    <a href="<?= base_url('admin/news/delete/' . $art['artikel_id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini secara permanen?')" class="p-1 text-on-surface-variant hover:text-error transition-colors rounded hover:bg-error-container" title="Hapus">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="p-4 text-center text-on-surface-variant">Belum ada berita terdaftar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
