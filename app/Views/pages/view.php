<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?><?= esc($page['judul']) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Breadcrumb -->
<nav aria-label="Breadcrumb" class="mb-8 font-label-md text-label-md text-on-surface-variant flex items-center gap-2 flex-wrap">
    <a class="hover:text-primary transition-colors" href="<?= base_url('/') ?>">Beranda</a>
    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
    <span aria-current="page" class="text-on-surface font-medium"><?= esc($page['judul']) ?></span>
</nav>

<div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm mb-12">
    <div class="p-6 md:p-10">
        <h1 class="font-display text-display text-on-surface mb-8 pb-4 border-b border-outline-variant"><?= esc($page['judul']) ?></h1>
        
        <div class="prose prose-slate max-w-none font-body-md text-body-md text-on-surface flex flex-col gap-4 leading-relaxed ck-content">
            <?= $page['konten'] ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
