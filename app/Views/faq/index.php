<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Breadcrumb -->
<nav aria-label="Breadcrumb" class="mb-6 font-label-md text-label-md text-on-surface-variant flex items-center gap-2 flex-wrap">
    <a class="hover:text-primary transition-colors flex items-center gap-1.5" href="<?= base_url('/') ?>">
        <i class="fa-solid fa-house text-xs"></i>
        <span>Beranda</span>
    </a>
    <i class="fa-solid fa-chevron-right text-[12px] opacity-60"></i>
    <span aria-current="page" class="text-on-surface font-semibold">FAQ</span>
</nav>

<!-- Main Container Card -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-2xl overflow-hidden shadow-sm mb-12" id="faq-wrapper">
    <!-- Header Banner & Toolbar -->
    <div class="p-6 md:p-8 bg-gradient-to-r from-primary/10 via-surface-container-lowest to-surface-container-lowest border-b border-outline-variant flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-2">
            <div class="flex items-center gap-3 flex-wrap">
                <span class="px-3 py-1 text-xs font-semibold uppercase tracking-wider rounded-full bg-primary/10 text-primary border border-primary/20 flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-question"></i> Pusat Bantuan & Informasi
                </span>
                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> KB Sinjai
                </span>
            </div>
            <h1 class="font-display text-2xl md:text-3xl font-bold text-on-surface tracking-tight">
                Pertanyaan yang Sering Diajukan (FAQ)
            </h1>
            <p class="text-on-surface-variant font-body-md text-sm md:text-base max-w-3xl">
                Temukan jawaban lengkap dan informasi penting seputar layanan Dinas Perpustakaan dan Kearsipan Kabupaten Sinjai melalui Knowledge Base resmi.
            </p>
        </div>

        <!-- Action Buttons Bar -->
        <div class="flex items-center gap-2 shrink-0 flex-wrap">
            <button id="btn-refresh-faq" type="button" title="Muat Ulang Halaman FAQ"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-outline-variant bg-surface hover:bg-surface-container-high text-on-surface text-sm font-medium transition-all shadow-sm active:scale-95 focus:outline-none focus:ring-2 focus:ring-primary/40">
                <i class="fa-solid fa-rotate-right transition-transform duration-500" id="icon-refresh-faq"></i>
                <span class="hidden sm:inline">Refresh</span>
            </button>

            <button id="btn-fullscreen-faq" type="button" title="Layar Penuh"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-outline-variant bg-surface hover:bg-surface-container-high text-on-surface text-sm font-medium transition-all shadow-sm active:scale-95 focus:outline-none focus:ring-2 focus:ring-primary/40">
                <i class="fa-solid fa-expand" id="icon-fullscreen-faq"></i>
                <span class="hidden sm:inline" id="text-fullscreen-faq">Layar Penuh</span>
            </button>
        </div>
    </div>

    <!-- Iframe Container with Loading Overlay -->
    <div class="relative w-full bg-surface-container-lowest overflow-hidden transition-all duration-300 min-h-[600px]" id="faq-iframe-box" style="height: 1000px;">
        <!-- Loading Spinner Overlay -->
        <div id="faq-loading" class="absolute inset-0 z-20 bg-surface/90 backdrop-blur-sm flex flex-col items-center justify-center gap-4 transition-opacity duration-500">
            <div class="relative w-16 h-16 flex items-center justify-center">
                <div class="absolute inset-0 rounded-full border-4 border-primary/20 border-t-primary animate-spin"></div>
                <i class="fa-solid fa-circle-question text-primary text-xl"></i>
            </div>
            <div class="text-center space-y-1">
                <p class="font-medium text-on-surface text-base">Memuat Halaman FAQ...</p>
                <p class="text-xs text-on-surface-variant">Menghubungkan ke Knowledge Base Kabupaten Sinjai</p>
            </div>
        </div>

        <!-- Embedded FAQ Iframe -->
        <iframe 
            id="faq-iframe"
            src="<?= esc($faqUrl) ?>" 
            title="FAQ Knowledge Base Kabupaten Sinjai"
            class="w-full h-full border-0 transition-opacity duration-300 opacity-0"
            allowfullscreen
            loading="lazy"
            onload="onFaqLoaded()"
            onerror="onFaqError()">
        </iframe>
    </div>

    <!-- Info Footer Card -->
    <div class="p-4 md:p-6 bg-surface-container border-t border-outline-variant flex items-center gap-3 text-xs md:text-sm text-on-surface-variant">
        <i class="fa-solid fa-circle-info text-primary shrink-0 text-base"></i>
        <span>Daftar Pertanyaan dan Jawaban bersumber dari Knowledge Base Resmi Kabupaten Sinjai (kb.sinjaikab.go.id).</span>
    </div>
</div>

<script>
    function onFaqLoaded() {
        const loading = document.getElementById('faq-loading');
        const iframe = document.getElementById('faq-iframe');
        if (loading) {
            loading.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => { loading.style.display = 'none'; }, 500);
        }
        if (iframe) {
            iframe.classList.remove('opacity-0');
        }
    }

    function onFaqError() {
        const loading = document.getElementById('faq-loading');
        if (loading) {
            loading.innerHTML = `
                <div class="text-center p-6 max-w-md bg-surface border border-outline-variant rounded-xl shadow-lg space-y-3">
                    <i class="fa-solid fa-triangle-exclamation text-amber-500 text-3xl"></i>
                    <h3 class="font-bold text-on-surface text-lg">Halaman FAQ Tidak Dapat Dimuat</h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Server Knowledge Base tidak mengizinkan pratinjau embed langsung. Silakan klik tombol di bawah untuk membaca FAQ secara langsung.
                    </p>
                    <a href="<?= esc($faqUrl) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-lg bg-primary text-on-primary font-semibold text-sm transition-colors hover:bg-primary/90">
                        <span>Buka Halaman FAQ Sinjai</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    </a>
                </div>
            `;
        }
    }

    // Dynamic height resize via postMessage if supported by embedded page
    window.addEventListener('message', function(e) {
        if (e.data && e.data.type === 'resize' && e.data.height) {
            const iframeBox = document.getElementById('faq-iframe-box');
            if (iframeBox) {
                iframeBox.style.height = (e.data.height + 20) + 'px';
            }
        }
    });

    // Refresh Iframe
    document.getElementById('btn-refresh-faq')?.addEventListener('click', function() {
        const iframe = document.getElementById('faq-iframe');
        const icon = document.getElementById('icon-refresh-faq');
        const loading = document.getElementById('faq-loading');

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
    document.getElementById('btn-fullscreen-faq')?.addEventListener('click', function() {
        const wrapper = document.getElementById('faq-wrapper');
        const iframeBox = document.getElementById('faq-iframe-box');
        const iconFS = document.getElementById('icon-fullscreen-faq');
        const textFS = document.getElementById('text-fullscreen-faq');

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

    document.addEventListener('fullscreenchange', handleFaqFullscreenChange);
    document.addEventListener('webkitfullscreenchange', handleFaqFullscreenChange);
    document.addEventListener('msfullscreenchange', handleFaqFullscreenChange);

    function handleFaqFullscreenChange() {
        const iframeBox = document.getElementById('faq-iframe-box');
        const iconFS = document.getElementById('icon-fullscreen-faq');
        const textFS = document.getElementById('text-fullscreen-faq');

        if (document.fullscreenElement) {
            if (iconFS) {
                iconFS.classList.remove('fa-expand');
                iconFS.classList.add('fa-compress');
            }
            if (textFS) textFS.textContent = 'Keluar Layar Penuh';
            if (iframeBox) {
                iframeBox.style.height = 'calc(100vh - 120px)';
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
        }
    }
</script>
<?= $this->endSection() ?>
