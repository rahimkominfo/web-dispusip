<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Edit Media<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
        <span class="material-symbols-outlined text-sm" data-icon="home">home</span>
        <span>Dashboard</span>
        <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
        <span>Media & Galeri</span>
        <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
        <a href="<?= base_url('admin/media') ?>" class="hover:underline">Media Library</a>
        <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
        <span class="font-bold text-primary">Edit</span>
    </div>
    <h2 class="font-headline-lg text-headline-lg text-primary">Edit Media</h2>
</div>

<!-- Validation Error Notifications -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong class="font-bold block mb-1">Gagal memperbarui berkas:</strong>
        <ul class="list-disc pl-5 text-sm">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-6 max-w-2xl">
    <form action="<?= base_url('admin/media/update/' . $media['media_id']) ?>" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
        <?= csrf_field() ?>
        
        <div class="flex flex-col gap-1">
            <label class="font-label-md text-label-md text-on-surface">Berkas Saat Ini</label>
            <div class="p-4 bg-surface-container rounded-lg border border-outline-variant flex items-center gap-4">
                <?php 
                    $isImage = strpos($media['tipe_file'], 'image/') === 0;
                    $isPdf = $media['tipe_file'] === 'application/pdf';
                ?>
                <?php if ($isImage): ?>
                    <img src="<?= esc($media['url_file']) ?>" alt="Preview" class="w-20 h-20 object-cover rounded border border-outline shadow-sm" onerror="this.src='<?= base_url('img/logo.png') ?>'; this.className='w-16 h-16 object-contain';"/>
                <?php elseif ($isPdf): ?>
                    <div class="w-20 h-20 bg-red-50 text-red-500 rounded border border-red-200 flex flex-col items-center justify-center shadow-sm">
                        <span class="material-symbols-outlined text-[32px]">picture_as_pdf</span>
                        <span class="text-[9px] font-bold uppercase mt-1">PDF Document</span>
                    </div>
                <?php else: ?>
                    <div class="w-20 h-20 bg-surface-container-high text-on-surface-variant rounded border border-outline-variant flex flex-col items-center justify-center shadow-sm">
                        <span class="material-symbols-outlined text-[32px]">draft</span>
                        <span class="text-[9px] font-bold uppercase mt-1">File</span>
                    </div>
                <?php endif; ?>
                <div class="flex-grow">
                    <span class="font-semibold text-primary block truncate max-w-sm" title="<?= esc($media['nama_file']) ?>"><?= esc($media['nama_file']) ?></span>
                    <span class="text-xs font-mono text-on-surface-variant block mt-1"><?= esc($media['tipe_file']) ?></span>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-1">
            <label class="font-label-md text-label-md text-on-surface" for="media_file">Ganti File Berkas (Opsional)</label>
            <input type="file" name="media_file" id="media_file" class="w-full text-on-surface text-sm border border-outline-variant rounded p-2 focus:outline-none"/>
            <p class="text-xs text-on-surface-variant mt-1">Biarkan kosong jika tidak ingin mengganti berkas file. Jenis file: Gambar (JPG, PNG, GIF, WEBP), PDF, Word, dsb. Maksimum: 8MB.</p>
        </div>

        <div class="flex flex-col gap-1">
            <label class="font-label-md text-label-md text-on-surface" for="caption">Keterangan / Caption Berkas</label>
            <textarea name="caption" id="caption" rows="3" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow" placeholder="Tuliskan keterangan singkat tentang berkas media ini..."><?= old('caption', esc($media['caption'])) ?></textarea>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-outline-variant">
            <button type="submit" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">save</span> Perbarui Media
            </button>
            <a href="<?= base_url('admin/media') ?>" class="border border-outline text-on-surface-variant hover:bg-surface-container-low rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
