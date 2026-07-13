<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Edit Berita<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
        <span class="material-symbols-outlined text-sm" data-icon="home">home</span>
        <span>Dashboard</span>
        <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
        <span>Manajemen Konten</span>
        <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
        <a href="<?= base_url('admin/news') ?>" class="hover:underline">News</a>
        <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
        <span class="font-bold text-primary">Edit</span>
    </div>
    <h2 class="font-headline-lg text-headline-lg text-primary">Edit Berita & Artikel</h2>
</div>

<!-- Validation Error Notifications -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong class="font-bold block mb-1">Gagal menyimpan berita:</strong>
        <ul class="list-disc pl-5 text-sm">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-6">
    <form action="<?= base_url('admin/news/update/' . $article['artikel_id']) ?>" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left 2/3 Content Column -->
            <div class="md:col-span-2 flex flex-col gap-6">
                <div class="flex flex-col gap-1">
                    <label class="font-label-md text-label-md text-on-surface" for="judul">Judul Berita / Artikel *</label>
                    <input required type="text" name="judul" id="judul" value="<?= old('judul', esc($article['judul'])) ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow"/>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="font-label-md text-label-md text-on-surface" for="slug">Slug URL *</label>
                    <input required type="text" name="slug" id="slug" value="<?= old('slug', esc($article['slug'])) ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow"/>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="font-label-md text-label-md text-on-surface" for="abstrak">Ringkasan Singkat (Abstrak / Lead) *</label>
                    <textarea name="abstrak" id="abstrak" rows="3" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow"><?= old('abstrak', esc($article['abstrak'])) ?></textarea>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="font-label-md text-label-md text-on-surface" for="editor">Konten Lengkap *</label>
                    <div class="ck-editor-container">
                        <textarea name="konten" id="editor" rows="15" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow editor"><?= old('konten', esc($article['konten'])) ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Right 1/3 Options/Meta Column -->
            <div class="flex flex-col gap-6 border-l border-outline-variant pl-0 md:pl-6">
                <div class="flex flex-col gap-1">
                    <label class="font-label-md text-label-md text-on-surface" for="status">Status Penerbitan *</label>
                    <select required name="status" id="status" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow">
                        <option value="Draf" <?= old('status', esc($article['status'])) == 'Draf' ? 'selected' : '' ?>>Draf</option>
                        <option value="Ditayangkan" <?= old('status', esc($article['status'])) == 'Ditayangkan' ? 'selected' : '' ?>>Ditayangkan</option>
                        <option value="Diarsipkan" <?= old('status', esc($article['status'])) == 'Diarsipkan' ? 'selected' : '' ?>>Diarsipkan</option>
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="font-label-md text-label-md text-on-surface" for="tanggal_publikasi">Tanggal Publikasi *</label>
                    <input required type="datetime-local" name="tanggal_publikasi" id="tanggal_publikasi" value="<?= old('tanggal_publikasi', date('Y-m-d\TH:i', strtotime($article['tanggal_publikasi']))) ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow"/>
                </div>

                <!-- Categories check list -->
                <div class="flex flex-col gap-2">
                    <label class="font-label-md text-label-md text-on-surface font-semibold">Kategori Berita</label>
                    <div class="bg-surface-container-low rounded-lg p-3 max-h-48 overflow-y-auto border border-outline-variant flex flex-col gap-2">
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <?php 
                                    $isChecked = in_array($cat['kategori_id'], $selectedCategories);
                                ?>
                                <label class="flex items-center gap-2 text-sm text-on-surface cursor-pointer hover:bg-surface-container p-1 rounded transition-colors">
                                    <input type="checkbox" name="categories[]" value="<?= esc($cat['kategori_id']) ?>" <?= $isChecked ? 'checked' : '' ?> class="rounded text-primary focus:ring-primary-container"/>
                                    <span><?= esc($cat['nama']) ?></span>
                                </label>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="text-xs text-on-surface-variant italic">Belum ada kategori tersedia.</span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Tags check list -->
                <div class="flex flex-col gap-2">
                    <label class="font-label-md text-label-md text-on-surface font-semibold">Tags Berita</label>
                    <div class="bg-surface-container-low rounded-lg p-3 max-h-48 overflow-y-auto border border-outline-variant flex flex-col gap-2">
                        <?php if (!empty($tags)): ?>
                            <?php foreach ($tags as $tag): ?>
                                <?php 
                                    $isChecked = in_array($tag['tag_id'], $selectedTags);
                                ?>
                                <label class="flex items-center gap-2 text-sm text-on-surface cursor-pointer hover:bg-surface-container p-1 rounded transition-colors">
                                    <input type="checkbox" name="tags[]" value="<?= esc($tag['tag_id']) ?>" <?= $isChecked ? 'checked' : '' ?> class="rounded text-primary focus:ring-primary-container"/>
                                    <span>#<?= esc($tag['nama']) ?></span>
                                </label>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="text-xs text-on-surface-variant italic">Belum ada tags tersedia.</span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Image options -->
                <div class="border-t border-outline-variant pt-4 flex flex-col gap-4">
                    <h4 class="font-title-sm text-title-sm text-primary font-semibold">Gambar Utama</h4>
                    
                    <?php if (!empty($article['gambar_utama'])): ?>
                        <div class="flex flex-col gap-1">
                            <label class="font-label-md text-label-md text-on-surface">Gambar Saat Ini</label>
                            <div class="w-full h-40 rounded-lg overflow-hidden border border-outline-variant bg-surface-container relative">
                                <img src="<?= esc($article['gambar_utama']) ?>" alt="Current Cover" class="w-full h-full object-cover" onerror="this.src='<?= base_url('img/logo.png') ?>'; this.className='w-16 h-16 object-contain m-auto absolute inset-0';"/>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="flex flex-col gap-1">
                        <label class="font-label-md text-label-md text-on-surface" for="gambar_utama">Ganti File Gambar</label>
                        <input type="file" name="gambar_utama" id="gambar_utama" accept="image/*" class="w-full text-on-surface text-sm border border-outline-variant rounded p-2 focus:outline-none"/>
                        <p class="text-xs text-on-surface-variant mt-1">Biarkan kosong jika tidak ingin mengganti gambar. Format: JPG, PNG, WEBP. Max: 8MB.</p>
                    </div>

                    <div class="relative flex py-1 items-center">
                        <div class="flex-grow border-t border-outline-variant"></div>
                        <span class="flex-shrink mx-3 text-xs font-semibold text-on-surface-variant uppercase">Atau Ganti URL</span>
                        <div class="flex-grow border-t border-outline-variant"></div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="font-label-md text-label-md text-on-surface" for="gambar_url">URL Link Gambar</label>
                        <input type="text" name="gambar_url" id="gambar_url" value="<?= old('gambar_url', esc($article['gambar_utama'])) ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-outline-variant">
            <button type="submit" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">save</span> Simpan Perubahan
            </button>
            <a href="<?= base_url('admin/news') ?>" class="border border-outline text-on-surface-variant hover:bg-surface-container-low rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
