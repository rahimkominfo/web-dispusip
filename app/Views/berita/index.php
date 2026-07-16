<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Berita &amp; Artikel<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Breadcrumb -->
<nav aria-label="Breadcrumb" class="text-on-surface-variant font-caption text-caption flex items-center gap-2 mb-6">
    <a class="hover:text-primary underline-offset-2 hover:underline" href="<?= base_url('/') ?>">Beranda</a>
    <i class="fa-solid fa-chevron-right text-sm"></i>
    <span aria-current="page" class="font-medium text-on-surface">Berita &amp; Artikel</span>
</nav>

<!-- Page Title -->
<div class="mb-8">
    <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary">Arsip Berita &amp; Artikel DISPUSIP</h1>
    <p class="font-body-md text-body-md text-on-surface-variant mt-2 max-w-3xl">Kumpulan berita terbaru, artikel informatif, dan dokumentasi kegiatan dari Dinas Perpustakaan dan Kearsipan.</p>
</div>

<div class="flex flex-col lg:flex-row gap-gutter">
    <!-- Left Column: Main Content (70%) -->
    <div class="lg:w-8/12 flex flex-col gap-6">
        <!-- Filter & Search Row -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded p-4 flex flex-col sm:flex-row gap-4 items-center justify-between shadow-sm">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <label class="font-label-md text-label-md text-on-surface-variant whitespace-nowrap" for="category-filter">Kategori:</label>
                <select class="bg-surface border border-outline-variant rounded px-3 py-1.5 text-sm w-full sm:w-48 focus:ring-2 focus:ring-primary focus:border-primary" id="category-filter">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= esc($cat['slug']) ?>" <?= $kategori_slug === $cat['slug'] ? 'selected' : '' ?>><?= esc($cat['nama']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <label class="font-label-md text-label-md text-on-surface-variant whitespace-nowrap" for="sort-filter">Urutkan:</label>
                <select class="bg-surface border border-outline-variant rounded px-3 py-1.5 text-sm w-full sm:w-40 focus:ring-2 focus:ring-primary focus:border-primary" id="sort-filter">
                    <option value="terbaru" <?= $urutkan === 'terbaru' ? 'selected' : '' ?>>Terbaru</option>
                    <option value="terlama" <?= $urutkan === 'terlama' ? 'selected' : '' ?>>Terlama</option>
                    <option value="terpopuler" <?= $urutkan === 'terpopuler' ? 'selected' : '' ?>>Terpopuler</option>
                </select>
            </div>
        </div>

        <!-- News List (Cards) -->
        <div class="flex flex-col gap-6">
            <?php if (!empty($articles)): ?>
                <?php foreach ($articles as $artikel): ?>
                    <article class="bg-surface-container-lowest border border-outline-variant rounded flex flex-col sm:flex-row overflow-hidden hover:shadow-md transition-shadow duration-300 group">
                        <div class="sm:w-1/3 relative h-48 sm:h-auto shrink-0">
                            <?php if ($artikel['gambar_utama']): ?>
                                <img alt="<?= esc($artikel['judul']) ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="<?= esc($artikel['gambar_utama']) ?>"/>
                            <?php else: ?>
                                <div class="absolute inset-0 w-full h-full bg-surface-container-high flex items-center justify-center">
                                    <i class="fa-solid fa-image text-4xl text-outline"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-5 flex flex-col sm:w-2/3">
                            <div class="flex items-center gap-2 mb-2 font-caption text-caption text-on-surface-variant flex-wrap">
                                <span class="bg-primary-container text-on-primary-container px-2 py-0.5 rounded font-medium">Berita</span>
                                <span>•</span>
                                <span class="flex items-center gap-1"><i class="fa-solid fa-calendar text-[14px]"></i> <?= date('d M Y', strtotime($artikel['tanggal_publikasi'])) ?></span>
                                <span>•</span>
                                <span class="flex items-center gap-1"><i class="fa-solid fa-user text-[14px]"></i> <?= esc($artikel['author_name'] ?? 'Admin') ?></span>
                            </div>
                            <h2 class="font-title-lg text-title-lg text-primary mb-2 group-hover:text-surface-tint transition-colors line-clamp-2">
                                <a href="<?= base_url('berita/' . $artikel['slug']) ?>"><?= esc($artikel['judul']) ?></a>
                            </h2>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-4 line-clamp-2"><?= esc($artikel['abstrak'] ?? strip_tags($artikel['konten'])) ?></p>
                            <div class="mt-auto">
                                <a class="inline-flex items-center gap-1 font-label-md text-label-md text-surface-tint font-semibold hover:text-primary transition-colors" href="<?= base_url('berita/' . $artikel['slug']) ?>">
                                    Selengkapnya <i class="fa-solid fa-arrow-right text-sm transition-transform group-hover:translate-x-1"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-12 bg-surface-container-lowest border border-outline-variant rounded shadow-sm text-on-surface-variant">
                    <i class="fa-solid fa-search-minus text-4xl mb-2"></i>
                    <p>Tidak ada berita ditemukan.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if (!empty($articles)): ?>
            <div class="mt-8 flex justify-center">
                <?= $pager->links('default', 'default_full') ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Right Column: Sidebar (30%) -->
    <aside class="lg:w-4/12 flex flex-col gap-6">
        <!-- Search Widget -->
        <div class="bg-surface-container-low border-t-2 border-secondary rounded p-5 shadow-sm">
            <h3 class="font-title-lg text-title-lg text-primary font-bold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-search text-secondary"></i> Pencarian
            </h3>
            <form action="<?= base_url('berita') ?>" method="GET" class="flex flex-col gap-3">
                <?php if (!empty($kategori_slug)): ?>
                    <input type="hidden" name="kategori" value="<?= esc($kategori_slug) ?>"/>
                <?php endif; ?>
                <?php if (!empty($urutkan)): ?>
                    <input type="hidden" name="urutkan" value="<?= esc($urutkan) ?>"/>
                <?php endif; ?>
                <input name="cari" value="<?= esc($cari) ?>" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-outline" placeholder="Masukkan kata kunci..." type="text"/>
                <button class="bg-primary text-on-primary rounded py-2 px-4 font-label-md text-label-md font-semibold hover:bg-surface-tint transition-colors flex justify-center items-center gap-2" type="submit">
                    Cari <i class="fa-solid fa-search text-sm"></i>
                </button>
            </form>
        </div>

        <!-- Categories Widget -->
        <div class="bg-surface-container-low border-t-2 border-secondary rounded p-5 shadow-sm">
            <h3 class="font-title-lg text-title-lg text-primary font-bold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-list text-secondary"></i> Kategori
            </h3>
            <ul class="flex flex-col gap-2 font-body-md text-body-md">
                <?php foreach ($categories as $cat): ?>
                    <li>
                        <a class="flex justify-between items-center group py-1 border-b border-outline-variant/30" href="<?= base_url('berita?kategori=' . $cat['slug']) ?>">
                            <span class="text-on-surface-variant group-hover:text-primary transition-colors <?= $kategori_slug === $cat['slug'] ? 'font-bold text-primary' : '' ?>"><?= esc($cat['nama']) ?></span>
                            <span class="bg-surface-container-highest text-on-surface text-xs py-0.5 px-2 rounded-full group-hover:bg-primary-container group-hover:text-on-primary-container transition-colors"><?= esc($cat['artikel_count']) ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Popular Tags Widget -->
        <div class="bg-surface-container-low border-t-2 border-secondary rounded p-5 shadow-sm">
            <h3 class="font-title-lg text-title-lg text-primary font-bold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-tag text-secondary"></i> Tag Populer
            </h3>
            <div class="flex flex-wrap gap-2">
                <?php foreach ($tags as $tag): ?>
                    <a class="bg-surface-container-highest hover:bg-primary-container hover:text-on-primary-container text-on-surface font-caption text-caption py-1.5 px-3 rounded-full transition-colors border border-outline-variant/50" href="#">#<?= esc($tag['nama']) ?></a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Popular Articles Widget -->
        <div class="bg-surface-container-low border-t-2 border-secondary rounded p-5 shadow-sm">
            <h3 class="font-title-lg text-title-lg text-primary font-bold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-secondary"></i> Artikel Terpopuler
            </h3>
            <div class="flex flex-col gap-4">
                <?php foreach ($popular_articles as $pop): ?>
                    <a class="group flex gap-3 items-start" href="<?= base_url('berita/' . $pop['slug']) ?>">
                        <div class="w-16 h-16 shrink-0 rounded overflow-hidden bg-surface-variant">
                            <?php if ($pop['gambar_utama']): ?>
                                <img alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" src="<?= esc($pop['gambar_utama']) ?>"/>
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fa-solid fa-image text-xl text-outline"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h4 class="font-label-md text-label-md text-on-surface group-hover:text-primary transition-colors line-clamp-2"><?= esc($pop['judul']) ?></h4>
                            <span class="font-caption text-caption text-on-surface-variant flex items-center gap-1 mt-1">
                                <i class="fa-solid fa-eye text-[12px]"></i> <?= number_format($pop['jumlah_tayang']) ?> kali dibaca
                            </span>
                        </div>
                    </a>
                    <hr class="border-outline-variant/30 last:hidden"/>
                <?php endforeach; ?>
            </div>
        </div>
    </aside>
</div>

<script>
    document.getElementById('category-filter').addEventListener('change', function() {
        let val = this.value;
        let url = new URL(window.location.href);
        if (val) {
            url.searchParams.set('kategori', val);
        } else {
            url.searchParams.delete('kategori');
        }
        url.searchParams.delete('page'); // reset page
        window.location.href = url.toString();
    });

    document.getElementById('sort-filter').addEventListener('change', function() {
        let val = this.value;
        let url = new URL(window.location.href);
        if (val) {
            url.searchParams.set('urutkan', val);
        } else {
            url.searchParams.delete('urutkan');
        }
        window.location.href = url.toString();
    });
</script>
<?= $this->endSection() ?>
