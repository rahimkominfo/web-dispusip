<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?><?= esc($title) ?> - PPID Sinjai<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Breadcrumb -->
<nav aria-label="Breadcrumb" class="mb-6 font-label-md text-label-md text-on-surface-variant flex items-center gap-2 flex-wrap">
    <a class="hover:text-primary transition-colors flex items-center gap-1.5" href="<?= base_url('/') ?>">
        <i class="fa-solid fa-house text-xs"></i>
        <span>Beranda</span>
    </a>
    <i class="fa-solid fa-chevron-right text-[12px] opacity-60"></i>
    <span class="text-on-surface-variant">Layanan Informasi</span>
    <i class="fa-solid fa-chevron-right text-[12px] opacity-60"></i>
    <span aria-current="page" class="text-on-surface font-semibold"><?= esc($title) ?></span>
</nav>

<!-- Sub Navigation Tabs for PPID -->
<div class="mb-8 flex flex-wrap gap-2 border-b border-outline-variant pb-4">
    <a href="<?= base_url('ppid/berkala') ?>" 
       class="px-4 py-2.5 rounded-xl font-medium text-sm transition-all flex items-center gap-2 <?= (uri_string() === 'ppid/berkala') ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-high text-on-surface-variant hover:bg-surface-container-highest hover:text-on-surface' ?>">
        <i class="fa-solid fa-calendar-check"></i>
        <span>Informasi Berkala</span>
    </a>
    <a href="<?= base_url('ppid/setiap_saat') ?>" 
       class="px-4 py-2.5 rounded-xl font-medium text-sm transition-all flex items-center gap-2 <?= (uri_string() === 'ppid/setiap_saat') ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-high text-on-surface-variant hover:bg-surface-container-highest hover:text-on-surface' ?>">
        <i class="fa-solid fa-clock"></i>
        <span>Informasi Setiap Saat</span>
    </a>
    <a href="<?= base_url('ppid/serta_merta') ?>" 
       class="px-4 py-2.5 rounded-xl font-medium text-sm transition-all flex items-center gap-2 <?= (uri_string() === 'ppid/serta_merta') ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-high text-on-surface-variant hover:bg-surface-container-highest hover:text-on-surface' ?>">
        <i class="fa-solid fa-bolt"></i>
        <span>Informasi Serta Merta</span>
    </a>
    <a href="<?= base_url('ppid/dikecualikan') ?>" 
       class="px-4 py-2.5 rounded-xl font-medium text-sm transition-all flex items-center gap-2 <?= (uri_string() === 'ppid/dikecualikan') ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-high text-on-surface-variant hover:bg-surface-container-highest hover:text-on-surface' ?>">
        <i class="fa-solid fa-user-shield"></i>
        <span>Informasi Dikecualikan</span>
    </a>
</div>

<!-- Main Container Card -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-2xl overflow-hidden shadow-sm mb-12" id="ppid-wrapper">
    <!-- Header Banner & Toolbar -->
    <div class="p-6 md:p-8 bg-gradient-to-r from-primary/10 via-surface-container-lowest to-surface-container-lowest border-b border-outline-variant flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-2">
            <div class="flex items-center gap-3 flex-wrap">
                <span class="px-3 py-1 text-xs font-semibold uppercase tracking-wider rounded-full bg-primary/10 text-primary border border-primary/20 flex items-center gap-1.5">
                    <i class="fa-solid fa-shield-halved"></i> PPID Kabupaten Sinjai
                </span>
                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Terintegrasi
                </span>
            </div>
            <h1 class="font-display text-2xl md:text-3xl font-bold text-on-surface tracking-tight">
                <?= esc($title) ?>
            </h1>
            <p class="text-on-surface-variant font-body-md text-sm md:text-base max-w-3xl">
                Layanan Keterbukaan Informasi Publik Pejabat Pengelola Informasi dan Dokumentasi (PPID) Dinas Perpustakaan dan Kearsipan Kabupaten Sinjai.
            </p>
        </div>

        <!-- Action Buttons Bar -->
        <div class="flex items-center gap-2 shrink-0 flex-wrap">
            <button id="btn-refresh-iframe" type="button" title="Muat Ulang Layanan"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-outline-variant bg-surface hover:bg-surface-container-high text-on-surface text-sm font-medium transition-all shadow-sm active:scale-95 focus:outline-none focus:ring-2 focus:ring-primary/40">
                <i class="fa-solid fa-rotate-right transition-transform duration-500" id="icon-refresh"></i>
                <span class="hidden sm:inline">Refresh</span>
            </button>

            <button id="btn-fullscreen-iframe" type="button" title="Layar Penuh"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-outline-variant bg-surface hover:bg-surface-container-high text-on-surface text-sm font-medium transition-all shadow-sm active:scale-95 focus:outline-none focus:ring-2 focus:ring-primary/40">
                <i class="fa-solid fa-expand" id="icon-fullscreen"></i>
                <span class="hidden sm:inline" id="text-fullscreen">Layar Penuh</span>
            </button>
        </div>
    </div>

    <!-- Iframe Container with Loading Overlay -->
    <div class="relative w-full bg-slate-900 overflow-hidden" id="iframe-box" style="height: 1000px;">
        <!-- Loading Spinner Overlay -->
        <div id="ppid-loading" class="absolute inset-0 z-20 bg-surface/90 backdrop-blur-sm flex flex-col items-center justify-center gap-4 transition-opacity duration-500">
            <div class="relative w-16 h-16 flex items-center justify-center">
                <div class="absolute inset-0 rounded-full border-4 border-primary/20 border-t-primary animate-spin"></div>
                <i class="fa-solid fa-file-invoice text-primary text-xl"></i>
            </div>
            <div class="text-center space-y-1">
                <p class="font-medium text-on-surface text-base">Memuat Layanan <?= esc($title) ?>...</p>
                <p class="text-xs text-on-surface-variant">Menghubungkan ke Portal PPID Kabupaten Sinjai</p>
            </div>
        </div>

        <!-- Embedded PPID Iframe -->
        <iframe 
            id="ppid-iframe"
            src="<?= esc($embedUrl) ?>" 
            title="<?= esc($title) ?> - PPID Sinjai"
            class="w-full border-0 transition-opacity duration-300 opacity-0"
            style="height: 1000px;"
            height="1000"
            allowfullscreen
            loading="lazy"
            onload="onPpidLoaded()"
            onerror="onPpidError()">
        </iframe>
    </div>

    <!-- Info Footer Card -->
    <div class="p-4 md:p-6 bg-surface-container border-t border-outline-variant flex items-center gap-3 text-xs md:text-sm text-on-surface-variant">
        <i class="fa-solid fa-circle-info text-primary shrink-0 text-base"></i>
        <span>Layanan Informasi Publik PPID terintegrasi secara otomatis dengan Portal Resmi PPID Pemerintah Kabupaten Sinjai.</span>
    </div>
</div>

<script>
    function onPpidLoaded() {
        const loading = document.getElementById('ppid-loading');
        const iframe = document.getElementById('ppid-iframe');
        if (loading) {
            loading.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => { loading.style.display = 'none'; }, 500);
        }
        if (iframe) {
            iframe.classList.remove('opacity-0');
        }
    }

    function onPpidError() {
        const loading = document.getElementById('ppid-loading');
        if (loading) {
            loading.innerHTML = `
                <div class="text-center p-6 max-w-md bg-surface border border-outline-variant rounded-xl shadow-lg space-y-3">
                    <i class="fa-solid fa-triangle-exclamation text-amber-500 text-3xl"></i>
                    <h3 class="font-bold text-on-surface text-lg">Layanan Tidak Dapat Dimuat di Dalam Frame</h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Server PPID membatasi penayangan langsung di dalam frame domain luar. Silakan klik tombol di bawah untuk membuka informasi PPID secara langsung.
                    </p>
                    <a href="<?= esc($embedUrl) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-lg bg-primary text-on-primary font-semibold text-sm transition-colors hover:bg-primary/90">
                        <span>Buka Layanan PPID</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    </a>
                </div>
            `;
        }
    }

    // Refresh Iframe
    document.getElementById('btn-refresh-iframe')?.addEventListener('click', function() {
        const iframe = document.getElementById('ppid-iframe');
        const icon = document.getElementById('icon-refresh');
        const loading = document.getElementById('ppid-loading');

        if (icon) icon.classList.add('animate-spin');
        if (loading) {
            loading.style.display = 'flex';
            loading.classList.remove('opacity-0', 'pointer-events-none');
        }
        if (iframe) {
            iframe.classList.add('opacity-0');
            iframe.src = iframe.src;
        }

        setTimeout(() => {
            if (icon) icon.classList.remove('animate-spin');
        }, 1000);
    });

    // Fullscreen Toggle
    document.getElementById('btn-fullscreen-iframe')?.addEventListener('click', function() {
        const wrapper = document.getElementById('ppid-wrapper');
        if (!document.fullscreenElement) {
            if (wrapper.requestFullscreen) {
                wrapper.requestFullscreen();
            } else if (wrapper.webkitRequestFullscreen) {
                wrapper.webkitRequestFullscreen();
            } else if (wrapper.msRequestFullscreen) {
                wrapper.msRequestFullscreen();
            }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    });

    document.addEventListener('fullscreenchange', handleFullscreenChange);
    document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
    document.addEventListener('msfullscreenchange', handleFullscreenChange);

    function handleFullscreenChange() {
        const iframeBox = document.getElementById('iframe-box');
        const iframe = document.getElementById('ppid-iframe');
        const iconFS = document.getElementById('icon-fullscreen');
        const textFS = document.getElementById('text-fullscreen');

        if (document.fullscreenElement) {
            if (iconFS) {
                iconFS.classList.remove('fa-expand');
                iconFS.classList.add('fa-compress');
            }
            if (textFS) textFS.textContent = 'Keluar Layar Penuh';
            if (iframeBox) {
                iframeBox.style.height = 'calc(100vh - 100px)';
            }
            if (iframe) {
                iframe.style.height = '100%';
            }
        } else {
            if (iconFS) {
                iconFS.classList.remove('fa-compress');
                iconFS.classList.add('fa-expand');
            }
            if (textFS) textFS.textContent = 'Layar Penuh';
            if (iframeBox) {
                iframeBox.style.height = '1000px';
            }
            if (iframe) {
                iframe.style.height = '1000px';
            }
        }
    }
</script>
<?= $this->endSection() ?>
