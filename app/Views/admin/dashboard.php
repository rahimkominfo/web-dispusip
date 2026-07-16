<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Breadcrumbs & Header -->
<div class="mb-8">
    <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
        <i class="fa-solid fa-house text-sm"></i>
        <span>Dashboard</span>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <span class="font-bold text-primary">Ringkasan</span>
    </div>
    <h2 class="font-headline-lg text-headline-lg text-primary">Selamat Datang, Administrator!</h2>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant flex items-center justify-between shadow-sm hover:shadow-md transition-shadow">
        <div>
            <p class="font-label-md text-label-md text-on-surface-variant mb-1">Artikel</p>
            <p class="font-display text-display text-primary"><?= esc($total_articles) ?></p>
        </div>
        <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
            <i class="fa-solid fa-file-lines"></i>
        </div>
    </div>
    <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant flex items-center justify-between shadow-sm hover:shadow-md transition-shadow">
        <div>
            <p class="font-label-md text-label-md text-on-surface-variant mb-1">Komentar Menunggu</p>
            <p class="font-display text-display text-secondary"><?= esc($total_pending_comments) ?></p>
        </div>
        <div class="w-12 h-12 rounded-full bg-secondary-fixed flex items-center justify-center text-secondary">
            <i class="fa-solid fa-comments"></i>
        </div>
    </div>
    <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant flex items-center justify-between shadow-sm hover:shadow-md transition-shadow">
        <div>
            <p class="font-label-md text-label-md text-on-surface-variant mb-1">User/Staf</p>
            <p class="font-display text-display text-tertiary-container"><?= esc($total_users) ?></p>
        </div>
        <div class="w-12 h-12 rounded-full bg-tertiary-fixed flex items-center justify-center text-tertiary-container">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>
</div>

<!-- Tables Area -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Articles -->
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm overflow-hidden flex flex-col">
        <div class="p-6 border-b border-outline-variant bg-surface-container-low flex justify-between items-center">
            <h3 class="font-title-lg text-title-lg text-primary">Artikel Terbaru</h3>
            <a href="<?= base_url('berita') ?>" target="_blank" class="font-label-md text-label-md text-secondary hover:underline">Lihat Portal</a>
        </div>
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container font-label-md text-label-md text-on-surface-variant border-b border-outline-variant">
                        <th class="p-4 py-3 font-medium">Judul Artikel</th>
                        <th class="p-4 py-3 font-medium">Status</th>
                        <th class="p-4 py-3 font-medium">Tgl Publikasi</th>
                    </tr>
                </thead>
                <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant">
                    <?php if (!empty($recent_articles)): ?>
                        <?php foreach ($recent_articles as $artikel): ?>
                            <tr class="hover:bg-surface-container-low transition-colors">
                                <td class="p-4 py-3 truncate max-w-[200px]" title="<?= esc($artikel['judul']) ?>">
                                    <a class="hover:underline text-primary" href="<?= base_url('berita/' . $artikel['slug']) ?>" target="_blank"><?= esc($artikel['judul']) ?></a>
                                </td>
                                <td class="p-4 py-3">
                                    <?php if ($artikel['status'] === 'Ditayangkan'): ?>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-[#E6F4EA] text-[#137333]">Tayang</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-[#FEF7E0] text-[#B06000]">Draf</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4 py-3 text-on-surface-variant text-sm"><?= date('d M Y', strtotime($artikel['tanggal_publikasi'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="p-4 text-center text-on-surface-variant">Belum ada artikel.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Comment Moderation -->
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm overflow-hidden flex flex-col">
        <div class="p-6 border-b border-outline-variant bg-surface-container-low flex justify-between items-center">
            <h3 class="font-title-lg text-title-lg text-primary">Moderasi Komentar</h3>
            <span class="bg-secondary-fixed text-secondary-fixed-dim px-2 py-1 rounded-full text-xs font-bold text-on-secondary-fixed"><?= esc($total_pending_comments) ?> Menunggu</span>
        </div>
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container font-label-md text-label-md text-on-surface-variant border-b border-outline-variant">
                        <th class="p-4 py-3 font-medium">Pengirim &amp; Komentar</th>
                        <th class="p-4 py-3 font-medium">Artikel Terkait</th>
                        <th class="p-4 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant">
                    <?php if (!empty($pending_comments)): ?>
                        <?php foreach ($pending_comments as $comment): ?>
                            <tr class="hover:bg-surface-container-low transition-colors">
                                <td class="p-4 py-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-full bg-primary-fixed text-primary flex items-center justify-center font-bold text-sm shrink-0">
                                            <?= strtoupper(substr(esc($comment['nama_pengunjung']), 0, 1)) ?>
                                        </div>
                                        <div>
                                            <span class="font-medium block"><?= esc($comment['nama_pengunjung']) ?></span>
                                            <p class="text-xs text-on-surface-variant line-clamp-2" title="<?= esc($comment['isi_komentar']) ?>"><?= esc($comment['isi_komentar']) ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 py-3 truncate max-w-[150px] text-sm text-on-surface-variant" title="<?= esc($comment['artikel_judul']) ?>"><?= esc($comment['artikel_judul']) ?></td>
                                <td class="p-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="<?= base_url('admin/komentar/approve/' . $comment['komentar_id']) ?>" class="p-1 text-[#137333] hover:bg-[#E6F4EA] transition-colors rounded border border-transparent hover:border-[#137333]" title="Setujui">
                                            <i class="fa-solid fa-check-circle text-[20px]"></i>
                                        </a>
                                        <a href="<?= base_url('admin/komentar/spam/' . $comment['komentar_id']) ?>" class="p-1 text-error hover:bg-error-container transition-colors rounded border border-transparent hover:border-error" title="Tandai Spam">
                                            <i class="fa-solid fa-triangle-exclamation text-[20px]"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="p-4 text-center text-on-surface-variant">Tidak ada komentar yang memerlukan moderasi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
