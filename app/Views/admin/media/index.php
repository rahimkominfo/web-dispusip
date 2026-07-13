<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Media Library<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8 flex justify-between items-center flex-wrap gap-4">
    <div>
        <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
            <span class="material-symbols-outlined text-sm" data-icon="home">home</span>
            <span>Dashboard</span>
            <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
            <span>Media & Galeri</span>
            <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
            <span class="font-bold text-primary">Media Library</span>
        </div>
        <h2 class="font-headline-lg text-headline-lg text-primary">Media Library</h2>
    </div>
    <a href="<?= base_url('admin/media/create') ?>" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-4 py-2 font-label-md text-label-md font-semibold flex items-center gap-2 transition-colors">
        <span class="material-symbols-outlined text-sm">upload</span> Unggah Berkas
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
                    <th class="p-4 py-3 font-medium w-24">Media</th>
                    <th class="p-4 py-3 font-medium">Nama File</th>
                    <th class="p-4 py-3 font-medium">Tipe / MIME</th>
                    <th class="p-4 py-3 font-medium">Keterangan (Caption)</th>
                    <th class="p-4 py-3 font-medium">Pengunggah</th>
                    <th class="p-4 py-3 font-medium w-36">Tanggal Unggah</th>
                    <th class="p-4 py-3 font-medium text-right w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant">
                <?php if (!empty($media)): ?>
                    <?php foreach ($media as $item): ?>
                        <?php 
                            $isImage = strpos($item['tipe_file'], 'image/') === 0;
                            $isPdf = $item['tipe_file'] === 'application/pdf';
                        ?>
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 py-3">
                                <?php if ($isImage): ?>
                                    <img src="<?= esc($item['url_file']) ?>" alt="<?= esc($item['nama_file']) ?>" class="w-16 h-12 object-cover rounded border border-outline-variant shadow-sm" onerror="this.src='<?= base_url('img/logo.png') ?>'; this.className='w-10 h-10 object-contain';"/>
                                <?php elseif ($isPdf): ?>
                                    <div class="w-16 h-12 bg-red-50 text-red-500 rounded border border-red-200 flex flex-col items-center justify-center shadow-sm">
                                        <span class="material-symbols-outlined text-[24px]">picture_as_pdf</span>
                                        <span class="text-[8px] font-bold uppercase">PDF</span>
                                    </div>
                                <?php else: ?>
                                    <div class="w-16 h-12 bg-surface-container text-on-surface-variant rounded border border-outline-variant flex flex-col items-center justify-center shadow-sm">
                                        <span class="material-symbols-outlined text-[24px]">draft</span>
                                        <span class="text-[8px] font-bold uppercase">FILE</span>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 py-3">
                                <span class="font-semibold text-primary block break-all"><?= esc($item['nama_file']) ?></span>
                                <span class="text-xs text-on-surface-variant font-mono break-all"><?= esc($item['url_file']) ?></span>
                            </td>
                            <td class="p-4 py-3 text-sm font-mono text-on-surface-variant"><?= esc($item['tipe_file']) ?></td>
                            <td class="p-4 py-3 text-sm text-on-surface-variant">
                                <?= esc($item['caption'] ?: 'Tidak ada keterangan') ?>
                            </td>
                            <td class="p-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-surface-container text-on-surface">
                                    <?= esc($item['uploader'] ?: 'Sistem') ?>
                                </span>
                            </td>
                            <td class="p-4 py-3 text-sm text-on-surface-variant"><?= date('d M Y, H:i', strtotime($item['created_at'])) ?></td>
                            <td class="p-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button onclick="copyToClipboard('<?= esc($item['url_file']) ?>')" class="p-1 text-on-surface-variant hover:text-secondary transition-colors rounded hover:bg-surface-container" title="Salin URL">
                                        <span class="material-symbols-outlined text-[20px]">content_copy</span>
                                    </button>
                                    <a href="<?= base_url('admin/media/edit/' . $item['media_id']) ?>" class="p-1 text-on-surface-variant hover:text-primary transition-colors rounded hover:bg-surface-container" title="Edit">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </a>
                                    <a href="<?= base_url('admin/media/delete/' . $item['media_id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus berkas media ini secara permanen dari server?')" class="p-1 text-on-surface-variant hover:text-error transition-colors rounded hover:bg-error-container" title="Hapus">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="p-4 text-center text-on-surface-variant">Belum ada berkas media diunggah.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('URL media berhasil disalin ke clipboard!');
    }, function(err) {
        console.error('Gagal menyalin teks: ', err);
    });
}
</script>
<?= $this->endSection() ?>
