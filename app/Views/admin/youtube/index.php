<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen YouTube<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8 flex justify-between items-center flex-wrap gap-4">
    <div>
        <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
            <i class="fa-solid fa-house text-sm"></i>
            <span>Dashboard</span>
            <i class="fa-solid fa-chevron-right text-sm"></i>
            <span>Media & Galeri</span>
            <i class="fa-solid fa-chevron-right text-sm"></i>
            <span class="font-bold text-primary">Youtube</span>
        </div>
        <h2 class="font-headline-lg text-headline-lg text-primary font-bold">Manajemen Video YouTube</h2>
    </div>
    <a href="<?= base_url('admin/youtube/create') ?>" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-4 py-2 font-label-md text-label-md font-semibold flex items-center gap-2 transition-colors">
        <i class="fa-solid fa-plus text-sm"></i> Tambah Video
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
                    <th class="p-4 py-3 font-medium w-16 text-center">No</th>
                    <th class="p-4 py-3 font-medium w-36">Thumbnail</th>
                    <th class="p-4 py-3 font-medium">Judul & Detail Video</th>
                    <th class="p-4 py-3 font-medium w-32">Status</th>
                    <th class="p-4 py-3 font-medium text-right w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant">
                <?php if (!empty($videos)): ?>
                    <?php $no = 1; foreach ($videos as $video): ?>
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 py-3 text-on-surface-variant text-center font-medium"><?= $no++ ?></td>
                            <td class="p-4 py-3">
                                <div class="relative w-28 aspect-video rounded bg-surface-container overflow-hidden border border-outline-variant">
                                    <img src="https://img.youtube.com/vi/<?= esc($video['youtube_id']) ?>/mqdefault.jpg" alt="<?= esc($video['judul']) ?>" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/30 hover:bg-black/10 transition-colors">
                                        <i class="fa-brands fa-youtube text-red-600 text-2xl drop-shadow"></i>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 py-3">
                                <div class="font-bold text-primary text-base hover:underline mb-1">
                                    <a href="https://www.youtube.com/watch?v=<?= esc($video['youtube_id']) ?>" target="_blank" rel="noopener noreferrer" class="flex items-center gap-1.5">
                                        <?= esc($video['judul']) ?>
                                        <i class="fa-solid fa-external-link text-xs opacity-60"></i>
                                    </a>
                                </div>
                                <div class="text-xs text-on-surface-variant font-mono">
                                    ID: <span class="bg-surface-container px-1.5 py-0.5 rounded text-secondary font-bold"><?= esc($video['youtube_id']) ?></span>
                                </div>
                                <?php if (!empty($video['deskripsi'])): ?>
                                    <p class="text-xs text-on-surface-variant line-clamp-2 mt-1.5 leading-relaxed max-w-xl">
                                        <?= esc($video['deskripsi']) ?>
                                    </p>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 py-3">
                                <?php if ($video['status'] === 'Aktif'): ?>
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
                                    <a href="<?= base_url('admin/youtube/edit/' . $video['video_id']) ?>" class="p-1 text-on-surface-variant hover:text-primary transition-colors rounded hover:bg-surface-container" title="Edit">
                                        <i class="fa-solid fa-pen text-[20px]"></i>
                                    </a>
                                    <a href="<?= base_url('admin/youtube/delete/' . $video['video_id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus video YouTube ini?')" class="p-1 text-on-surface-variant hover:text-error transition-colors rounded hover:bg-error-container" title="Hapus">
                                        <i class="fa-solid fa-trash text-[20px]"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="p-8 text-center text-on-surface-variant">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <i class="fa-brands fa-youtube text-4xl opacity-30 text-error"></i>
                                <span>Belum ada video YouTube terdaftar.</span>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
