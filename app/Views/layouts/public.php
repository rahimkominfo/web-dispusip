<!DOCTYPE html>
<html lang="id" class="overflow-x-hidden max-w-full">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= $this->renderSection('title') ?> - Dinas Perpustakaan &amp; Kearsipan (DISPUSIP) Sinjai</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo.png') ?>"/>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('img/logo.png') ?>"/>
    
    <!-- Local Compiled Tailwind and FontAwesome CSS -->
    <link href="<?= base_url('css/app.css') ?>" rel="stylesheet"/>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600;700&amp;family=Inter:wght@400;500&amp;display=swap" rel="stylesheet"/>
    
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
        }
        html, body {
            max-width: 100%;
            overflow-x: hidden !important;
        }
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
<body class="bg-background text-on-background font-body-md antialiased min-h-screen flex flex-col overflow-x-hidden w-full max-w-full relative">

<?php
// Load dynamic menu and running text directly in layout for clean MVC integration
$menuModel = new \App\Models\MenuModel();
$menus = $menuModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();

// Build nested menu tree
$menuTree = [];
$menusById = [];

foreach ($menus as $menu) {
    $menu['children'] = [];
    $menusById[$menu['id']] = $menu;
}

foreach ($menusById as $id => &$menu) {
    if ($menu['parent_id'] !== null && isset($menusById[$menu['parent_id']])) {
        $menusById[$menu['parent_id']]['children'][] = &$menu;
    } else {
        $menuTree[] = &$menu;
    }
}
unset($menu);

// Helper function to check if a menu or any of its descendants is active
if (!function_exists('isMenuOrChildActive')) {
    function isMenuOrChildActive($menu, $currentUri) {
        $menuUrl = (filter_var($menu['url'], FILTER_VALIDATE_URL) ? $menu['url'] : base_url($menu['url']));
        if (rtrim($menuUrl, '/') === rtrim($currentUri, '/')) {
            return true;
        }
        if (!empty($menu['children'])) {
            foreach ($menu['children'] as $child) {
                if (isMenuOrChildActive($child, $currentUri)) {
                    return true;
                }
            }
        }
        return false;
    }
}

$runningTextModel = new \App\Models\RunningTextModel();
$runningText = $runningTextModel->where('is_active', 1)->first();
$currentUri = current_url();
?>

<!-- Top Bar Marquee -->
<div class="bg-primary text-on-primary py-2 text-caption font-caption">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter marquee">
        <p><?= esc($runningText['teks'] ?? 'Selamat Datang di Portal Resmi Dinas Perpustakaan & Kearsipan Sinjai') ?></p>
    </div>
</div>

<!-- TopAppBar -->
<header class="bg-primary dark:bg-primary-container border-b border-outline-variant dark:border-outline shadow-sm sticky lg:relative lg:border-b-0 lg:shadow-none top-0 z-50 w-full flex flex-col items-center">
    <!-- Brand & Search Bar / Mobile Controls Row -->
    <div class="w-full max-w-container-max mx-auto px-margin-mobile md:px-gutter py-4 flex items-center justify-between gap-4">
        <!-- Brand -->
        <div class="flex items-center gap-3">
            <img alt="Logo DISPUSIP" class="h-10 w-auto object-contain" src="<?= base_url('img/logo.png') ?>"/>
            <div class="font-title-lg text-title-lg font-bold text-on-primary dark:text-on-primary-container leading-tight">
                DISPUSIP <span class="text-secondary-fixed">Sinjai</span>
            </div>
        </div>
        
        <!-- Mobile Controls (Hamburger) -->
        <div class="flex items-center gap-2 lg:hidden">
            <button id="mobile-menu-toggle" class="text-on-primary dark:text-on-primary-container p-2 focus:outline-none hover:bg-white/10 rounded transition-colors" aria-label="Toggle Menu">
                <i class="fa-solid fa-bars text-[28px]" id="menu-icon"></i>
            </button>
        </div>

        <!-- Search Bar (Desktop) -->
        <div class="hidden lg:block">
            <form action="<?= base_url('berita') ?>" method="GET" class="relative">
                <input name="cari" value="<?= esc(service('request')->getGet('cari')) ?>" class="w-64 pl-10 pr-4 py-2 bg-surface text-on-surface border border-outline rounded focus:border-primary-container focus:ring-2 focus:ring-primary-container focus:ring-offset-2 outline-none transition-all font-body-md text-body-md" placeholder="Cari informasi..." type="text"/>
                <i class="fa-solid fa-search absolute left-3 top-2.5 text-outline"></i>
            </form>
        </div>
    </div>


    <!-- Mobile Navigation Menu Panel (Collapsible) -->
    <div id="mobile-menu-panel" class="hidden w-full bg-primary-container text-on-primary-container lg:hidden border-t border-outline-variant px-margin-mobile py-4 flex flex-col gap-4">
        <!-- Mobile Search Bar -->
        <form action="<?= base_url('berita') ?>" method="GET" class="relative w-full">
            <input name="cari" value="<?= esc(service('request')->getGet('cari')) ?>" class="w-full pl-10 pr-4 py-2 bg-surface text-on-surface border border-outline rounded focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all font-body-md text-body-md" placeholder="Cari informasi..." type="text"/>
            <i class="fa-solid fa-search absolute left-3 top-2.5 text-outline"></i>
        </form>

        <!-- Mobile Navigation List -->
        <div class="flex flex-col gap-2">
            <?php foreach ($menuTree as $index => $menu): 
                $menuUrl = (filter_var($menu['url'], FILTER_VALIDATE_URL) ? $menu['url'] : base_url($menu['url']));
                $isActive = isMenuOrChildActive($menu, $currentUri);
                $hasChildren = !empty($menu['children']);
                $menuId = "mobile-menu-" . $index;
            ?>
                <div class="border-b border-outline-variant/30 pb-2">
                    <?php if (!$hasChildren): ?>
                        <a class="block py-2 font-bold <?= $isActive ? 'text-secondary-fixed' : 'text-on-primary-container' ?> text-label-md" href="<?= $menuUrl ?>"><?= esc($menu['title']) ?></a>
                    <?php else: ?>
                        <div class="flex items-center justify-between py-2 cursor-pointer" onclick="toggleMobileSubmenu('<?= $menuId ?>')">
                            <span class="font-bold <?= $isActive ? 'text-secondary-fixed' : 'text-on-primary-container' ?> text-label-md"><?= esc($menu['title']) ?></span>
                            <i class="fa-solid fa-chevron-down text-[20px] transition-transform duration-200" id="arrow-<?= $menuId ?>"></i>
                        </div>
                        <div id="<?= $menuId ?>" class="hidden pl-4 flex flex-col gap-2 mt-1">
                            <a href="<?= $menuUrl ?>" class="block py-1.5 text-sm text-on-primary-container/85 italic">Buka <?= esc($menu['title']) ?></a>
                            
                            <?php foreach ($menu['children'] as $cIndex => $child): 
                                $childUrl = (filter_var($child['url'], FILTER_VALIDATE_URL) ? $child['url'] : base_url($child['url']));
                                $isChildActive = isMenuOrChildActive($child, $currentUri);
                                $hasSubChildren = !empty($child['children']);
                                $childId = $menuId . "-sub-" . $cIndex;
                            ?>
                                <div class="pl-2 border-l-2 border-outline-variant/40">
                                    <?php if (!$hasSubChildren): ?>
                                        <a href="<?= $childUrl ?>" class="block py-1.5 text-sm <?= $isChildActive ? 'text-secondary-fixed font-bold' : 'text-on-primary-container/80 hover:text-on-primary-container' ?>">
                                            <?= esc($child['title']) ?>
                                        </a>
                                    <?php else: ?>
                                        <div class="flex items-center justify-between py-1.5 cursor-pointer text-sm" onclick="toggleMobileSubmenu('<?= $childId ?>')">
                                            <span class="<?= $isChildActive ? 'text-secondary-fixed font-bold' : 'text-on-primary-container/80' ?>"><?= esc($child['title']) ?></span>
                                            <i class="fa-solid fa-chevron-down text-[18px] transition-transform duration-200" id="arrow-<?= $childId ?>"></i>
                                        </div>
                                        <div id="<?= $childId ?>" class="hidden pl-4 flex flex-col gap-1.5 mt-1">
                                            <a href="<?= $childUrl ?>" class="block py-1 text-xs text-on-primary-container/75 italic">Buka <?= esc($child['title']) ?></a>
                                            <?php foreach ($child['children'] as $subchild): 
                                                $subchildUrl = (filter_var($subchild['url'], FILTER_VALIDATE_URL) ? $subchild['url'] : base_url($subchild['url']));
                                                $isSubActive = isMenuOrChildActive($subchild, $currentUri);
                                            ?>
                                                <a href="<?= $subchildUrl ?>" class="block py-1 text-xs <?= $isSubActive ? 'text-secondary-fixed font-semibold' : 'text-on-primary-container/70' ?>">
                                                    <?= esc($subchild['title']) ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</header>

<!-- Navigation Section (Desktop) - Separate Section, Two Rows -->
<div class="hidden lg:block w-full border-t border-white/10 dark:border-outline/30 bg-primary/95 dark:bg-primary-container/95 py-2.5 lg:sticky lg:top-0 lg:z-50 lg:shadow-sm lg:border-b lg:border-outline-variant dark:lg:border-outline">
    <nav class="max-w-container-max mx-auto px-gutter flex flex-col gap-3">
        <?php
        $currentUri = current_url();
        $totalMenus = count($menuTree);
        $midpoint = ceil($totalMenus / 2);
        $row1 = array_slice($menuTree, 0, $midpoint);
        $row2 = array_slice($menuTree, $midpoint);
        ?>
        <!-- First Row of Menu Items -->
        <div class="flex items-center justify-center flex-wrap gap-x-8 gap-y-1">
            <?php foreach ($row1 as $menu): 
                $menuUrl = (filter_var($menu['url'], FILTER_VALIDATE_URL) ? $menu['url'] : base_url($menu['url']));
                $isActive = isMenuOrChildActive($menu, $currentUri);
            ?>
                <?php if (empty($menu['children'])): ?>
                    <a class="<?= $isActive ? 'text-secondary-fixed font-bold border-b-2 border-secondary-fixed pb-0.5' : 'text-on-primary dark:text-on-primary-container opacity-90' ?> font-label-md text-label-md hover:text-secondary-fixed transition-colors duration-200" href="<?= $menuUrl ?>"><?= esc($menu['title']) ?></a>
                <?php else: ?>
                    <div class="relative group py-1">
                        <a href="<?= $menuUrl ?>" class="flex items-center gap-1 <?= $isActive ? 'text-secondary-fixed font-bold border-b-2 border-secondary-fixed pb-0.5' : 'text-on-primary dark:text-on-primary-container opacity-90' ?> font-label-md text-label-md hover:text-secondary-fixed transition-colors duration-200 focus:outline-none">
                            <span><?= esc($menu['title']) ?></span>
                            <i class="fa-solid fa-chevron-down text-[16px] transition-transform duration-200 group-hover:rotate-180"></i>
                        </a>
                        <!-- Dropdown Menu -->
                        <div class="absolute left-1/2 -translate-x-1/2 top-full mt-1 w-56 rounded shadow-lg bg-primary border border-primary-container py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-2 group-hover:translate-y-0">
                            <?php foreach ($menu['children'] as $child): ?>
                                <?php if (empty($child['children'])): ?>
                                    <?php 
                                    $childUrl = (filter_var($child['url'], FILTER_VALIDATE_URL) ? $child['url'] : base_url($child['url']));
                                    $isChildActive = isMenuOrChildActive($child, $currentUri);
                                    ?>
                                    <a href="<?= $childUrl ?>" class="block px-4 py-2.5 text-sm <?= $isChildActive ? 'text-secondary-fixed font-bold bg-primary-container' : 'text-white/90 hover:text-white hover:bg-primary-container' ?> transition-colors duration-150">
                                        <?= esc($child['title']) ?>
                                    </a>
                                <?php else: ?>
                                    <!-- Level 2 Submenu (Sub-sub menu) -->
                                    <?php 
                                    $childUrl = (filter_var($child['url'], FILTER_VALIDATE_URL) ? $child['url'] : base_url($child['url']));
                                    $isChildActive = isMenuOrChildActive($child, $currentUri);
                                    ?>
                                    <div class="relative group/sub">
                                        <a href="<?= $childUrl ?>" class="w-full flex items-center justify-between px-4 py-2.5 text-sm <?= $isChildActive ? 'text-secondary-fixed font-bold bg-primary-container' : 'text-white/90 hover:text-white hover:bg-primary-container' ?> transition-colors duration-150 text-left focus:outline-none">
                                            <span><?= esc($child['title']) ?></span>
                                            <i class="fa-solid fa-chevron-right text-[16px]"></i>
                                        </a>
                                        <div class="absolute left-full top-0 ml-0.5 w-56 rounded shadow-lg bg-primary border border-primary-container py-2 z-50 opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all duration-200 transform translate-x-2 group-hover/sub:translate-x-0">
                                            <?php foreach ($child['children'] as $subchild): ?>
                                                <?php 
                                                $subchildUrl = (filter_var($subchild['url'], FILTER_VALIDATE_URL) ? $subchild['url'] : base_url($subchild['url']));
                                                $isSubChildActive = isMenuOrChildActive($subchild, $currentUri);
                                                ?>
                                                <a href="<?= $subchildUrl ?>" class="block px-4 py-2.5 text-sm <?= $isSubChildActive ? 'text-secondary-fixed font-bold bg-primary-container' : 'text-white/90 hover:text-white hover:bg-primary-container' ?> transition-colors duration-150">
                                                    <?= esc($subchild['title']) ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <!-- Second Row of Menu Items -->
        <div class="flex items-center justify-center flex-wrap gap-x-8 gap-y-1">
            <?php foreach ($row2 as $menu): 
                $menuUrl = (filter_var($menu['url'], FILTER_VALIDATE_URL) ? $menu['url'] : base_url($menu['url']));
                $isActive = isMenuOrChildActive($menu, $currentUri);
            ?>
                <?php if (empty($menu['children'])): ?>
                    <a class="<?= $isActive ? 'text-secondary-fixed font-bold border-b-2 border-secondary-fixed pb-0.5' : 'text-on-primary dark:text-on-primary-container opacity-90' ?> font-label-md text-label-md hover:text-secondary-fixed transition-colors duration-200" href="<?= $menuUrl ?>"><?= esc($menu['title']) ?></a>
                <?php else: ?>
                    <div class="relative group py-1">
                        <a href="<?= $menuUrl ?>" class="flex items-center gap-1 <?= $isActive ? 'text-secondary-fixed font-bold border-b-2 border-secondary-fixed pb-0.5' : 'text-on-primary dark:text-on-primary-container opacity-90' ?> font-label-md text-label-md hover:text-secondary-fixed transition-colors duration-200 focus:outline-none">
                            <span><?= esc($menu['title']) ?></span>
                            <i class="fa-solid fa-chevron-down text-[16px] transition-transform duration-200 group-hover:rotate-180"></i>
                        </a>
                        <!-- Dropdown Menu -->
                        <div class="absolute left-1/2 -translate-x-1/2 top-full mt-1 w-56 rounded shadow-lg bg-primary border border-primary-container py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-2 group-hover:translate-y-0">
                            <?php foreach ($menu['children'] as $child): ?>
                                <?php if (empty($child['children'])): ?>
                                    <?php 
                                    $childUrl = (filter_var($child['url'], FILTER_VALIDATE_URL) ? $child['url'] : base_url($child['url']));
                                    $isChildActive = isMenuOrChildActive($child, $currentUri);
                                    ?>
                                    <a href="<?= $childUrl ?>" class="block px-4 py-2.5 text-sm <?= $isChildActive ? 'text-secondary-fixed font-bold bg-primary-container' : 'text-white/90 hover:text-white hover:bg-primary-container' ?> transition-colors duration-150">
                                        <?= esc($child['title']) ?>
                                    </a>
                                <?php else: ?>
                                    <!-- Level 2 Submenu (Sub-sub menu) -->
                                    <?php 
                                    $childUrl = (filter_var($child['url'], FILTER_VALIDATE_URL) ? $child['url'] : base_url($child['url']));
                                    $isChildActive = isMenuOrChildActive($child, $currentUri);
                                    ?>
                                    <div class="relative group/sub">
                                        <a href="<?= $childUrl ?>" class="w-full flex items-center justify-between px-4 py-2.5 text-sm <?= $isChildActive ? 'text-secondary-fixed font-bold bg-primary-container' : 'text-white/90 hover:text-white hover:bg-primary-container' ?> transition-colors duration-150 text-left focus:outline-none">
                                            <span><?= esc($child['title']) ?></span>
                                            <i class="fa-solid fa-chevron-right text-[16px]"></i>
                                        </a>
                                        <div class="absolute left-full top-0 ml-0.5 w-56 rounded shadow-lg bg-primary border border-primary-container py-2 z-50 opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all duration-200 transform translate-x-2 group-hover/sub:translate-x-0">
                                            <?php foreach ($child['children'] as $subchild): ?>
                                                <?php 
                                                $subchildUrl = (filter_var($subchild['url'], FILTER_VALIDATE_URL) ? $subchild['url'] : base_url($subchild['url']));
                                                $isSubChildActive = isMenuOrChildActive($subchild, $currentUri);
                                                ?>
                                                <a href="<?= $subchildUrl ?>" class="block px-4 py-2.5 text-sm <?= $isSubChildActive ? 'text-secondary-fixed font-bold bg-primary-container' : 'text-white/90 hover:text-white hover:bg-primary-container' ?> transition-colors duration-150">
                                                    <?= esc($subchild['title']) ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </nav>
</div>

<script>
    // Toggle Mobile Main Menu Panel
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuPanel = document.getElementById('mobile-menu-panel');
    const menuIcon = document.getElementById('menu-icon');

    if (mobileMenuToggle && mobileMenuPanel && menuIcon) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenuPanel.classList.toggle('hidden');
            if (mobileMenuPanel.classList.contains('hidden')) {
                menuIcon.classList.remove('fa-xmark');
                menuIcon.classList.add('fa-bars');
            } else {
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-xmark');
            }
        });
    }

    // Toggle Mobile Accordion Submenus
    function toggleMobileSubmenu(elementId) {
        const submenu = document.getElementById(elementId);
        const arrow = document.getElementById('arrow-' + elementId);
        if (submenu) {
            submenu.classList.toggle('hidden');
            if (arrow) {
                if (submenu.classList.contains('hidden')) {
                    arrow.style.transform = 'rotate(0deg)';
                } else {
                    arrow.style.transform = 'rotate(180deg)';
                }
            }
        }
    }
</script>

<!-- Main Content -->
<main class="flex-grow w-full max-w-container-max mx-auto px-margin-mobile md:px-gutter py-8 md:py-12 overflow-x-hidden">
    <?= $this->renderSection('content') ?>
</main>

<!-- Footer -->
<footer class="bg-primary dark:bg-tertiary-container border-t-4 border-secondary mt-auto">
    <div class="w-full py-section-gap px-gutter max-w-container-max mx-auto flex flex-col md:flex-row justify-between gap-8">
        <div class="flex flex-col gap-4 max-w-sm">
            <div class="font-headline-md text-headline-md font-bold text-secondary-fixed">KONTAK</div>
            <div class="flex flex-col gap-3 text-on-primary dark:text-on-tertiary-container opacity-90 font-body-md text-body-md">
                <div class="flex items-start gap-2">
                    <i class="fa-solid fa-map-marker-alt text-secondary-fixed shrink-0 mt-0.5"></i>
                    <span>Jl. R.A. Kartini No. 1 Kelurahan Biringere</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-envelope text-secondary-fixed shrink-0"></i>
                    <a class="hover:underline text-on-primary dark:text-on-tertiary-container" href="mailto:dispusip@sinjaikab.go.id">dispusip@sinjaikab.go.id</a>
                </div>
                <div class="flex gap-4 mt-2 items-center">
                    <a class="text-secondary-fixed hover:text-white transition-colors" href="https://www.facebook.com/share/18q4pWwx92/" aria-label="Facebook">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/>
                        </svg>
                    </a>
                    <a class="text-secondary-fixed hover:text-white transition-colors" href="https://www.instagram.com/dispusip.sinjaikab?utm_source=qr&igsh=MW1hbGRqeDR6ZDZhdw==" aria-label="Instagram">
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
                <!-- <a href="<?= base_url('opac') ?>" class="hover:opacity-80 transition-opacity">
                    <img src="<?= base_url('assets/link%20terkait/inlislite.png') ?>" alt="Inlislite OPAC" class="h-10 w-auto object-contain rounded bg-white p-1" title="Inlislite OPAC Perpustakaan">
                </a> -->
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
