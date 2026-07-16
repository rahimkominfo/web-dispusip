<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Edit Galeri Kegiatan<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
        <i class="fa-solid fa-house text-sm"></i>
        <span>Dashboard</span>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <span>Media & Galeri</span>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <a href="<?= base_url('admin/gallery') ?>" class="hover:underline">Event Gallery</a>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <span class="font-bold text-primary">Edit</span>
    </div>
    <h2 class="font-headline-lg text-headline-lg text-primary">Edit Album Galeri Kegiatan</h2>
</div>

<!-- Validation & Action Error Notifications -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong class="font-bold block mb-1">Gagal menyimpan galeri:</strong>
        <ul class="list-disc pl-5 text-sm">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Action Success Notifications -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-6 max-w-4xl">
    <form action="<?= base_url('admin/gallery/update/' . $gallery['galeri_id']) ?>" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
        <?= csrf_field() ?>
        
        <div class="flex flex-col gap-1">
            <label class="font-label-md text-label-md text-on-surface" for="judul">Judul Event / Kegiatan *</label>
            <input required type="text" name="judul" id="judul" value="<?= old('judul', esc($gallery['judul'])) ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow"/>
        </div>

        <div class="flex flex-col gap-1">
            <label class="font-label-md text-label-md text-on-surface" for="deskripsi">Deskripsi Kegiatan</label>
            <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow"><?= old('deskripsi', esc($gallery['deskripsi'])) ?></textarea>
        </div>

        <!-- Cover Media section -->
        <div class="border-t border-outline-variant pt-4 flex flex-col gap-4">
            <h3 class="font-title-md text-title-md text-primary font-semibold">Foto Sampul Album (Cover)</h3>
            
            <?php if (!empty($gallery['sampul_url'])): ?>
                <div class="flex flex-col gap-1">
                    <label class="font-label-md text-label-md text-on-surface">Sampul Saat Ini</label>
                    <div class="w-full h-48 rounded-lg overflow-hidden border border-outline-variant bg-surface-container relative">
                        <img src="<?= esc($gallery['sampul_url']) ?>" alt="Current Cover" class="w-full h-full object-cover" onerror="this.src='<?= base_url('img/logo.png') ?>'; this.className='w-16 h-16 object-contain m-auto absolute inset-0';"/>
                    </div>
                </div>
            <?php endif; ?>

            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="sampul_file">Ganti File Sampul</label>
                <input type="file" name="sampul_file" id="sampul_file" accept="image/*" class="w-full text-on-surface text-sm border border-outline-variant rounded p-2 focus:outline-none"/>
                <p class="text-xs text-on-surface-variant mt-1">Biarkan kosong jika tidak ingin mengganti sampul. Format file: JPG, JPEG, PNG, WEBP. Maksimum: 8MB.</p>
            </div>


        </div>

        <!-- Current Album Photos Grid -->
        <div class="border-t border-outline-variant pt-4 flex flex-col gap-4">
            <h3 class="font-title-md text-title-md text-primary font-semibold">Foto Album Saat Ini</h3>
            
            <?php if (!empty($photos)): ?>
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-4">
                    <?php foreach ($photos as $photo): ?>
                        <div class="relative group rounded-lg overflow-hidden border border-outline-variant bg-surface-container aspect-video shadow-sm">
                            <img src="<?= esc($photo['gambar_url']) ?>" alt="Gallery Photo" class="w-full h-full object-cover" onerror="this.src='<?= base_url('img/logo.png') ?>'; this.className='w-12 h-12 object-contain m-auto absolute inset-0';"/>
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                                <a href="<?= base_url('admin/gallery/delete-image/' . $gallery['galeri_id'] . '/' . $photo['galeri_gambar_id']) ?>" onclick="return confirm('Hapus foto ini dari galeri secara permanen?')" class="p-1.5 bg-red-600 hover:bg-red-700 text-white rounded-full transition-colors shadow-lg" title="Hapus Foto">
                                    <i class="fa-solid fa-trash text-[18px]"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-sm text-on-surface-variant italic">Belum ada foto kegiatan di dalam album ini.</p>
            <?php endif; ?>
        </div>

        <!-- Add More Photos -->
        <div class="border-t border-outline-variant pt-4 flex flex-col gap-4">
            <h3 class="font-title-md text-title-md text-primary font-semibold">Tambah Foto Kegiatan</h3>
            
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="gallery_files">Pilih Berkas Foto Tambahan</label>
                <input type="file" name="gallery_files[]" id="gallery_files" accept="image/*" multiple class="w-full text-on-surface text-sm border border-outline-variant rounded p-2 focus:outline-none"/>
                <p class="text-xs text-on-surface-variant mt-1">Anda dapat memilih beberapa foto untuk ditambahkan ke album ini.</p>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-outline-variant">
            <button type="submit" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors flex items-center gap-2">
                <i class="fa-solid fa-save text-sm"></i> Simpan Perubahan
            </button>
            <a href="<?= base_url('admin/gallery') ?>" class="border border-outline text-on-surface-variant hover:bg-surface-container-low rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
