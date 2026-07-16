<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Halaman Statis<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8 flex justify-between items-center flex-wrap gap-4">
    <div>
        <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
            <i class="fa-solid fa-house text-sm"></i>
            <span>Dashboard</span>
            <i class="fa-solid fa-chevron-right text-sm"></i>
            <span>Halaman & Tampilan</span>
            <i class="fa-solid fa-chevron-right text-sm"></i>
            <span class="font-bold text-primary">Halaman Statis</span>
        </div>
        <h2 class="font-headline-lg text-headline-lg text-primary">Manajemen Halaman Statis</h2>
    </div>
    <a href="<?= base_url('admin/pages/create') ?>" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-4 py-2 font-label-md text-label-md font-semibold flex items-center gap-2 transition-colors">
        <i class="fa-solid fa-plus text-sm"></i> Tambah Halaman
    </a>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm overflow-hidden">
    <!-- Search & Filter Toolbar -->
    <div class="p-4 border-b border-outline-variant bg-surface-container-low flex flex-col sm:flex-row justify-between items-center gap-4">
        <form method="GET" action="<?= base_url('admin/pages') ?>" class="flex items-center gap-2 w-full sm:w-auto max-w-md">
            <div class="relative flex-grow">
                <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]"></i>
                <input type="text" name="cari" value="<?= esc($cari ?? '') ?>" placeholder="Cari halaman..." class="w-full sm:w-80 bg-surface-container-lowest border border-outline-variant rounded pl-10 pr-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow text-sm"/>
            </div>
            <button type="submit" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-4 py-2 font-label-md text-label-md font-semibold transition-colors flex items-center gap-1">
                Cari
            </button>
            <?php if (!empty($cari)): ?>
                <a href="<?= base_url('admin/pages') ?>" class="border border-outline text-on-surface-variant hover:bg-surface-container-low rounded px-4 py-2 font-label-md text-label-md font-semibold transition-colors flex items-center justify-center">
                    Reset
                </a>
            <?php endif; ?>
        </form>
        <?php if (!empty($cari)): ?>
            <div class="text-xs text-on-surface-variant bg-surface-container-high px-3 py-1 rounded">
                Ditemukan <span class="font-bold"><?= $pager->getTotal('default') ?></span> hasil pencarian
            </div>
        <?php endif; ?>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container font-label-md text-label-md text-on-surface-variant border-b border-outline-variant">
                    <th class="p-4 py-3 font-medium w-16">ID</th>
                    <th class="p-4 py-3 font-medium">Judul Halaman</th>
                    <th class="p-4 py-3 font-medium">Slug URL</th>
                    <th class="p-4 py-3 font-medium w-36">Tanggal Dibuat</th>
                    <th class="p-4 py-3 font-medium w-32">Status</th>
                    <th class="p-4 py-3 font-medium text-right w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant">
                <?php if (!empty($pages)): ?>
                    <?php foreach ($pages as $page): ?>
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 py-3 text-on-surface-variant"><?= esc($page['page_id']) ?></td>
                            <td class="p-4 py-3 font-semibold text-primary">
                                <?= esc($page['judul']) ?>
                                <div class="text-xs text-on-surface-variant font-mono mt-0.5"><?= esc($page['page_uuid']) ?></div>
                            </td>
                            <td class="p-4 py-3 text-sm font-mono text-on-surface-variant">/page/<?= esc($page['slug']) ?></td>
                            <td class="p-4 py-3 text-sm text-on-surface-variant"><?= date('d M Y, H:i', strtotime($page['created_at'])) ?></td>
                            <td class="p-4 py-3">
                                <?php if ($page['status'] === 'Diterbitkan'): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#E6F4EA] text-[#137333] border border-[#137333]/10">
                                        Diterbitkan
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-surface-container text-on-surface border border-outline-variant">
                                        Draf
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button onclick="navigator.clipboard.writeText('<?= base_url('page/' . esc($page['slug'])) ?>').then(() => alert('URL halaman berhasil disalin!'));" class="p-1 text-on-surface-variant hover:text-primary transition-colors rounded hover:bg-surface-container" title="Salin URL Halaman">
                                        <i class="fa-solid fa-copy text-[20px]"></i>
                                    </button>
                                    <a href="<?= base_url('admin/pages/edit/' . $page['page_id']) ?>" class="p-1 text-on-surface-variant hover:text-primary transition-colors rounded hover:bg-surface-container" title="Edit">
                                        <i class="fa-solid fa-pen text-[20px]"></i>
                                    </a>
                                    <a href="<?= base_url('admin/pages/delete/' . $page['page_id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus halaman statis ini?')" class="p-1 text-on-surface-variant hover:text-error transition-colors rounded hover:bg-error-container" title="Hapus">
                                        <i class="fa-solid fa-trash text-[20px]"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="p-4 text-center text-on-surface-variant">Belum ada halaman statis terdaftar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <?php if (isset($pager) && $pager->getPageCount() > 1): ?>
        <div class="p-4 border-t border-outline-variant bg-surface-container-low flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="text-xs text-on-surface-variant">
                Menampilkan halaman <?= $pager->getCurrentPage('default') ?> dari <?= $pager->getPageCount('default') ?> (Total <?= $pager->getTotal('default') ?> halaman)
            </div>
            <div>
                <?= $pager->only(['cari'])->links('default', 'default_full') ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
