<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= $this->renderSection('title') ?> - Dinas Perpustakaan &amp; Kearsipan (DISPUSIP) Sinjai</title>
    
    <!-- Local Compiled Tailwind and FontAwesome CSS -->
    <link href="<?= base_url('css/app.css') ?>" rel="stylesheet"/>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600;700&amp;family=Inter:wght@400;500&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    
    <style>
        .marquee {
            overflow: hidden;
            white-space: nowrap;
        }
        .marquee p {
            display: inline-block;
            animation: marquee 20s linear infinite;
        }
        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-md antialiased min-h-screen flex flex-col">

<?php
// Load dynamic menu and running text directly in layout for clean MVC integration
$menuModel = new \App\Models\MenuModel();
$menus = $menuModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();

$runningTextModel = new \App\Models\RunningTextModel();
$runningText = $runningTextModel->where('is_active', 1)->first();
?>

<!-- Top Bar Marquee -->
<div class="bg-primary text-on-primary py-2 text-caption font-caption">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter marquee">
        <p><?= esc($runningText['teks'] ?? 'Selamat Datang di Portal Resmi Dinas Perpustakaan & Kearsipan Sinjai') ?></p>
    </div>
</div>

<!-- TopAppBar -->
<header class="bg-primary dark:bg-primary-container border-b border-outline-variant dark:border-outline shadow-sm sticky top-0 z-50 w-full flex flex-col items-center">
    <div class="w-full max-w-container-max mx-auto px-margin-mobile md:px-gutter py-4 flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Brand -->
        <div class="flex items-center gap-3">
            <img alt="Logo DISPUSIP" class="h-10 w-auto object-contain" src="<?= base_url('img/logo.png') ?>"/>
            <div class="font-title-lg text-title-lg font-bold text-on-primary dark:text-on-primary-container leading-tight">
                DISPUSIP <span class="text-secondary-fixed">Sinjai</span>
            </div>
        </div>
        <!-- Navigation -->
        <nav class="hidden md:flex items-center gap-6">
            <?php foreach ($menus as $menu): ?>
                <?php 
                $menuUrl = (filter_var($menu['url'], FILTER_VALIDATE_URL) ? $menu['url'] : base_url($menu['url']));
                $currentUri = current_url();
                $isActive = (rtrim($menuUrl, '/') === rtrim($currentUri, '/'));
                ?>
                <a class="<?= $isActive ? 'text-secondary-fixed font-bold border-b-2 border-secondary-fixed pb-1' : 'text-on-primary dark:text-on-primary-container opacity-90' ?> font-label-md text-label-md hover:text-secondary-fixed transition-colors duration-200" href="<?= $menuUrl ?>"><?= esc($menu['title']) ?></a>
            <?php endforeach; ?>
        </nav>
        <!-- Search Bar -->
        <form action="<?= base_url('berita') ?>" method="GET" class="relative w-full md:w-auto">
            <input name="cari" value="<?= esc(service('request')->getGet('cari')) ?>" class="w-full md:w-64 pl-10 pr-4 py-2 bg-surface text-on-surface border border-outline rounded focus:border-primary-container focus:ring-2 focus:ring-primary-container focus:ring-offset-2 outline-none transition-all font-body-md text-body-md" placeholder="Cari informasi..." type="text"/>
            <span class="material-symbols-outlined absolute left-3 top-2.5 text-outline">search</span>
        </form>
    </div>
</header>

<!-- Main Content -->
<main class="flex-grow w-full max-w-container-max mx-auto px-margin-mobile md:px-gutter py-8 md:py-12">
    <?= $this->renderSection('content') ?>
</main>

<!-- Footer -->
<footer class="bg-primary dark:bg-tertiary-container border-t-4 border-secondary mt-auto">
    <div class="w-full py-section-gap px-gutter max-w-container-max mx-auto flex flex-col md:flex-row justify-between gap-8">
        <div class="flex flex-col gap-4 max-w-sm">
            <div class="font-headline-md text-headline-md font-bold text-secondary-fixed">KONTAK</div>
            <div class="flex flex-col gap-3 text-on-primary dark:text-on-tertiary-container opacity-90 font-body-md text-body-md">
                <div class="flex items-start gap-2">
                    <span class="material-symbols-outlined text-secondary-fixed shrink-0 mt-0.5">location_on</span>
                    <span>Jl. R.A. Kartini No. 1 Kelurahan Biringere</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary-fixed shrink-0">mail</span>
                    <a class="hover:underline text-on-primary dark:text-on-tertiary-container" href="mailto:dispusip@sinjaikab.go.id">dispusip@sinjaikab.go.id</a>
                </div>
                <div class="flex gap-4 mt-2 items-center">
                    <a class="text-secondary-fixed hover:text-white transition-colors" href="#" aria-label="Facebook">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/>
                        </svg>
                    </a>
                    <a class="text-secondary-fixed hover:text-white transition-colors" href="#" aria-label="Instagram">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </a>
                    <a class="text-secondary-fixed hover:text-white transition-colors" href="#" aria-label="YouTube">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.498 6.163a3.003 3.003 0 00-2.11-2.11C19.518 3.5 12 3.5 12 3.5s-7.518 0-9.388.553a3.003 3.003 0 00-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 002.11 2.11c1.87.553 9.388.553 9.388.553s7.518 0 9.388-.553a3.003 3.003 0 002.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-3">
            <h4 class="font-title-lg text-title-lg text-on-primary dark:text-on-tertiary-container">Link Terkait</h4>
            <div class="flex flex-wrap gap-2 mt-1">
                <a href="https://inlislite.sinjaikab.go.id/" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity">
                    <img src="<?= base_url('assets/link%20terkait/inlislite.png') ?>" alt="Inlislite" class="h-10 w-auto object-contain rounded bg-white p-1" title="Inlislite">
                </a>
                <a href="https://play.google.com/store/apps/details?id=mam.reader.isulsel" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity">
                    <img src="<?= base_url('assets/link%20terkait/isulsel.jpg') ?>" alt="iSulsel" class="h-10 w-auto object-contain rounded bg-white p-1" title="iSulsel">
                </a>
                <a href="https://www.lapor.go.id/" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity">
                    <img src="<?= base_url('assets/link%20terkait/logo_lapor.jpg') ?>" alt="LAPOR!" class="h-10 w-auto object-contain rounded bg-white p-1" title="LAPOR!">
                </a>
                <a href="https://sinjaikab.go.id/v4/pengaduan-masyarakat/" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity">
                    <img src="<?= base_url('assets/link%20terkait/layananpengaduan.png') ?>" alt="Layanan Pengaduan" class="h-10 w-auto object-contain rounded bg-white p-1" title="Layanan Pengaduan">
                </a>
                <a href="https://sites.google.com/guru.smp.belajar.id/lenterailmu/halaman-awal" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity">
                    <img src="<?= base_url('assets/link%20terkait/perpus_smp7.jpeg') ?>" alt="Perpus SMP 7" class="h-10 w-auto object-contain rounded bg-white p-1" title="Perpus SMP 7">
                </a>
            </div>
        </div>
        <div class="flex flex-col gap-4 w-full md:w-80">
            <h4 class="font-title-lg text-title-lg text-on-primary dark:text-on-tertiary-container">LOKASI</h4>
            <div class="overflow-hidden rounded-lg shadow-sm border border-outline-variant/30">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3973.8625567059403!2d120.25122877365295!3d-5.125835994851277!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbc25d84e88c0b1%3A0x4200855a53dd048a!2sDinas%20Perpustakaan%20dan%20Kearsipan%20Kabupaten%20Sinjai!5e0!3m2!1sid!2sid!4v1783567765849!5m2!1sid!2sid" class="w-full h-40 md:h-48 border-0" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
