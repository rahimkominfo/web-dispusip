<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Edit Menu Navigasi<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
        <span class="material-symbols-outlined text-sm" data-icon="home">home</span>
        <span>Dashboard</span>
        <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
        <span>Halaman & Tampilan</span>
        <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
        <a href="<?= base_url('admin/menus') ?>" class="hover:underline">Manajemen Menu</a>
        <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
        <span class="font-bold text-primary">Edit</span>
    </div>
    <h2 class="font-headline-lg text-headline-lg text-primary">Edit Menu Navigasi</h2>
</div>

<!-- Validation Error Notifications -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong class="font-bold block mb-1">Gagal menyimpan data:</strong>
        <ul class="list-disc pl-5 text-sm">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-6 max-w-2xl">
    <form action="<?= base_url('admin/menus/update/' . $menu['id']) ?>" method="POST" class="flex flex-col gap-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="title">Label Menu *</label>
                <input required type="text" name="title" id="title" value="<?= old('title', esc($menu['title'])) ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow"/>
            </div>
            
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="url">URL Menu *</label>
                <input required type="text" name="url" id="url" value="<?= old('url', esc($menu['url'])) ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow"/>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="parent_id">Menu Induk (Parent)</label>
                <select name="parent_id" id="parent_id" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow">
                    <option value="">-- Menu Utama (Tidak Ada) --</option>
                    <?php foreach ($parentMenus as $parent): ?>
                        <?php 
                        $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $parent['depth']);
                        $prefix = $parent['depth'] > 0 ? '└── ' : '';
                        ?>
                        <option value="<?= esc($parent['id']) ?>" <?= old('parent_id', esc($menu['parent_id'])) == $parent['id'] ? 'selected' : '' ?>>
                            <?= $indent . $prefix . esc($parent['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="sort_order">Nomor Urutan *</label>
                <input required type="number" min="0" name="sort_order" id="sort_order" value="<?= old('sort_order', esc($menu['sort_order'])) ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow"/>
            </div>

            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="is_active">Status Aktif *</label>
                <select required name="is_active" id="is_active" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow">
                    <option value="1" <?= old('is_active', esc($menu['is_active'])) == '1' ? 'selected' : '' ?>>Aktif</option>
                    <option value="0" <?= old('is_active', esc($menu['is_active'])) == '0' ? 'selected' : '' ?>>Tidak Aktif</option>
                </select>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-outline-variant">
            <button type="submit" class="bg-primary text-on-primary hover:bg-surface-tint rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">save</span> Perbarui Menu
            </button>
            <a href="<?= base_url('admin/menus') ?>" class="border border-outline text-on-surface-variant hover:bg-surface-container-low rounded px-6 py-2 font-label-md text-label-md font-semibold transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
