<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Banner & Flyer<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8 flex justify-between items-center flex-wrap gap-4">
    <div>
        <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
            <i class="fa-solid fa-house text-sm"></i>
            <span>Dashboard</span>
            <i class="fa-solid fa-chevron-right text-sm"></i>
            <span>Halaman & Tampilan</span>
            <i class="fa-solid fa-chevron-right text-sm"></i>
            <span class="font-bold text-primary">Banner/Flyer</span>
        </div>
        <h2 class="font-headline-lg text-headline-lg text-primary">Manajemen Banner & Flyer</h2>
    </div>
    <a href="<?= base_url('admin/flyers/create') ?>" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-4 py-2 font-label-md text-label-md font-semibold flex items-center gap-2 transition-colors">
        <i class="fa-solid fa-plus text-sm"></i> Tambah Banner/Flyer
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
                    <th class="p-4 py-3 font-medium w-16">Preview</th>
                    <th class="p-4 py-3 font-medium">Judul (Title)</th>
                    <th class="p-4 py-3 font-medium">Label</th>
                    <th class="p-4 py-3 font-medium w-24">Urutan</th>
                    <th class="p-4 py-3 font-medium w-32">Status</th>
                    <th class="p-4 py-3 font-medium text-right w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant">
                <?php if (!empty($flyers)): ?>
                    <?php foreach ($flyers as $flyer): ?>
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 py-3">
                                <?php if (!empty($flyer['gambar_url'])): ?>
                                    <img src="<?= esc($flyer['gambar_url']) ?>" alt="Flyer Preview" class="w-16 h-10 object-cover rounded-md border border-outline-variant shadow-sm" onerror="this.src='<?= base_url('img/logo.png') ?>'; this.className='w-10 h-10 object-contain';"/>
                                <?php else: ?>
                                    <div class="w-16 h-10 bg-surface-container rounded-md flex items-center justify-center text-xs text-on-surface-variant">No Image</div>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 py-3 font-semibold text-primary">
                                <?= esc($flyer['judul']) ?>
                                <div class="text-xs text-on-surface-variant font-mono mt-0.5"><?= esc($flyer['uuid']) ?></div>
                            </td>
                            <td class="p-4 py-3">
                                <?php if (!empty($flyer['label'])): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-secondary-container text-on-secondary-container">
                                        <?= esc($flyer['label']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-on-surface-variant text-xs italic">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 py-3 text-center font-medium"><?= esc($flyer['urutan']) ?></td>
                            <td class="p-4 py-3">
                                <?php if ($flyer['status'] === 'Aktif'): ?>
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
                                    <a href="<?= base_url('admin/flyers/edit/' . $flyer['flayer_id']) ?>" class="p-1 text-on-surface-variant hover:text-primary transition-colors rounded hover:bg-surface-container" title="Edit">
                                        <i class="fa-solid fa-pen text-[20px]"></i>
                                    </a>
                                    <a href="<?= base_url('admin/flyers/delete/' . $flyer['flayer_id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus banner/flyer ini?')" class="p-1 text-on-surface-variant hover:text-error transition-colors rounded hover:bg-error-container" title="Hapus">
                                        <i class="fa-solid fa-trash text-[20px]"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="p-4 text-center text-on-surface-variant">Belum ada banner/flyer terdaftar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
