<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Home<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Hero Section (Responsive Hero Banners) -->
<section class="w-full h-96 bg-surface-container-high rounded-xl overflow-hidden flex items-center justify-center relative mb-12">
    <!-- Responsive Picture Element -->
    <picture class="absolute inset-0 w-full h-full">
        <!-- Desktop (min-width: 1024px) -->
        <source media="(min-width: 1024px)" srcset="<?= base_url('img/hero-desktop.jpg') ?>">
        <!-- Tablet (min-width: 768px) -->
        <source media="(min-width: 768px)" srcset="<?= base_url('img/hero-tablet.jpg') ?>">
        <!-- Mobile (default) -->
        <img alt="Portal Resmi DISPUSIP Sinjai" class="absolute inset-0 w-full h-full object-cover" src="<?= base_url('img/hero-mobile.jpg') ?>"/>
    </picture>
    
    <!-- Dark Gradient Overlay for Tonal Contrast and Text Readability -->
    <div class="absolute inset-0 bg-gradient-to-r from-primary/95 to-transparent opacity-95 z-10"></div>
    
    <!-- Hero Text Content -->
    <div class="relative z-20 text-left px-gutter md:px-12 max-w-3xl mr-auto flex flex-col items-start justify-center h-full">
        <span class="bg-secondary-fixed text-on-secondary-fixed px-3 py-1.5 rounded-full font-caption text-xs uppercase tracking-wider font-bold mb-4 inline-block shadow-sm">
            Portal Resmi
        </span>
        <h1 class="font-display text-on-primary mb-3 leading-tight text-3xl md:text-4xl lg:text-5xl font-black drop-shadow-sm">
            Dinas Perpustakaan &amp; Kearsipan Kabupaten Sinjai
        </h1>
        <p class="text-on-primary/85 font-body-md text-sm md:text-base max-w-xl leading-relaxed">
            Menyediakan akses informasi digital, layanan perpustakaan umum terpadu, serta pelestarian dan digitalisasi arsip sejarah daerah.
        </p>
    </div>
</section>

<!-- Main Layout (70/30) -->
<div class="flex flex-col md:flex-row gap-gutter">
    <!-- Main Content (70%) -->
    <div class="w-full md:w-2/3 flex flex-col gap-8">
        <h2 class="font-headline-lg text-headline-lg border-b border-outline-variant pb-4 text-primary">Berita Terkini</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php if (!empty($latest_articles)): ?>
                <?php foreach ($latest_articles as $artikel): ?>
                    <article class="bg-surface-container-lowest border border-outline-variant rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col">
                        <div class="h-48 overflow-hidden relative">
                            <?php if ($artikel['gambar_utama']): ?>
                                <img class="w-full h-full object-cover" src="<?= esc($artikel['gambar_utama']) ?>" alt="<?= esc($artikel['judul']) ?>">
                            <?php else: ?>
                                <div class="w-full h-full bg-surface-container-high flex items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl text-outline">image</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="text-caption text-outline font-caption mb-2 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                <?= date('d M Y', strtotime($artikel['tanggal_publikasi'])) ?>
                            </div>
                            <h3 class="font-title-lg text-title-lg text-primary mb-2 line-clamp-2 hover:text-surface-tint">
                                <a href="<?= base_url('berita/' . $artikel['slug']) ?>"><?= esc($artikel['judul']) ?></a>
                            </h3>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-4 line-clamp-3">
                                <?= esc($artikel['abstrak'] ?? strip_tags($artikel['konten'])) ?>
                            </p>
                            <a class="mt-auto inline-flex items-center gap-1 font-semibold text-surface-tint hover:text-primary transition-colors" href="<?= base_url('berita/' . $artikel['slug']) ?>">
                                Selengkapnya <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-2 text-center py-12 text-on-surface-variant">
                    <span class="material-symbols-outlined text-4xl mb-2">article</span>
                    <p>Belum ada berita yang diterbitkan.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Banner / Flyer Section -->
        <section class="mt-4">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-6">
                <div class="flex-1">
                    <h2 class="font-headline-lg text-headline-lg border-b-2 border-primary inline-block pb-2">Banner &amp; Flyer</h2>
                </div>
                <div class="flex items-center gap-3">
                    <a href="<?= base_url('flyers') ?>" class="bg-primary text-on-primary px-6 py-2.5 rounded-full font-label-lg text-label-lg hover:bg-primary-container hover:text-on-primary-container transition-all shadow-sm flex items-center gap-2 group">
                        Lihat Semua
                        <span class="material-symbols-outlined text-lg transition-transform group-hover:translate-x-1">arrow_forward</span>
                    </a>
                    <div class="flex items-center gap-2">
                        <button id="prev-flyer" class="w-11 h-11 rounded-full border border-outline-variant text-primary hover:bg-primary hover:text-on-primary hover:border-primary transition-all flex items-center justify-center disabled:opacity-30 disabled:pointer-events-none">
                            <span class="material-symbols-outlined">chevron_left</span>
                        </button>
                        <button id="next-flyer" class="w-11 h-11 rounded-full border border-outline-variant text-primary hover:bg-primary hover:text-on-primary hover:border-primary transition-all flex items-center justify-center disabled:opacity-30 disabled:pointer-events-none">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <style>
                .scrollbar-hide::-webkit-scrollbar { display: none; }
                .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
            </style>

            <div id="flyer-carousel" class="flex overflow-x-auto scroll-smooth snap-x snap-mandatory gap-6 pb-6 -mx-4 px-4 md:mx-0 md:px-0 scrollbar-hide">
                <?php if (!empty($flyers)): ?>
                    <?php foreach ($flyers as $flyer): ?>
                        <div class="snap-center shrink-0 w-[85%] sm:w-[70%] md:w-[60%] lg:w-[50%] flex flex-col justify-between">
                            <div class="rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow border border-outline-variant bg-surface-container-lowest flex-grow flex flex-col relative aspect-[4/3] group cursor-pointer">
                                <img src="<?= esc($flyer['gambar_url']) ?>" alt="<?= esc($flyer['judul']) ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                    <h3 class="text-white font-title-md font-semibold text-shadow-sm line-clamp-2"><?= esc($flyer['judul']) ?></h3>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="w-full text-center py-16 bg-surface-container-lowest rounded-2xl border-2 border-dashed border-outline-variant">
                        <span class="material-symbols-outlined text-[56px] text-outline mb-3">web_stories</span>
                        <p class="font-body-lg text-body-lg text-on-surface-variant">Belum ada media promosi yang dipublikasikan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Galeri Section -->
        <section class="mt-12">
            <div class="flex justify-between items-center border-b-2 border-primary pb-2 mb-6">
                <h2 class="font-headline-lg text-headline-lg text-primary m-0">Galeri Kegiatan</h2>
                <a href="<?= base_url('gallery') ?>" class="text-sm font-label-md text-primary hover:text-secondary-fixed transition-colors flex items-center gap-1">
                    Lihat Semua <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <?php if (!empty($galleries)): ?>
                    <?php foreach ($galleries as $gallery): ?>
                        <div class="group relative rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer aspect-video bg-surface-container-lowest" onclick="openGalleryModal(<?= htmlspecialchars(json_encode($gallery['photos']), ENT_QUOTES, 'UTF-8') ?>, '<?= esc($gallery['judul'], 'js') ?>')">
                            <img src="<?= esc($gallery['sampul_url']) ?>" alt="<?= esc($gallery['judul']) ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent opacity-90 group-hover:opacity-100 flex flex-col justify-end p-4 transition-opacity">
                                <h3 class="text-white font-title-sm font-bold text-shadow-sm line-clamp-2 leading-tight"><?= esc($gallery['judul']) ?></h3>
                                <p class="text-white/80 text-xs mt-1.5 flex items-center gap-1.5 font-semibold"><span class="material-symbols-outlined text-[14px]">photo_library</span> <?= count($gallery['photos']) ?> Foto</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-2 text-center py-10 bg-surface-container-lowest rounded-xl border border-dashed border-outline-variant">
                        <span class="material-symbols-outlined text-[40px] text-outline mb-2">collections</span>
                        <p class="font-body-md text-on-surface-variant">Belum ada album galeri.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

    </div>
    
    <!-- Sidebar (30%) -->
    <aside class="w-full md:w-1/3 flex flex-col gap-8">
        <div class="bg-surface-container-low p-6 rounded-lg border border-outline-variant shadow-sm border-t-4 border-t-secondary flex flex-col items-center text-center">
            <h3 class="font-title-lg text-title-lg text-primary mb-4 font-bold w-full text-left border-b border-outline-variant pb-2">
                Bupati Sinjai
            </h3>
            <div class="w-48 h-60 overflow-hidden rounded-lg mb-4 shadow-sm border border-outline-variant">
                <img src="<?= base_url('img/Ratnawati_Arif_Bupati_Sinjai.jpg') ?>" alt="Dra. Hj. Ratnawati Arif, M.Si" class="w-full h-full object-cover object-top" onerror="this.src='<?= base_url('img/logo.png') ?>'; this.className='w-full h-full object-contain p-4 bg-white';">
            </div>
            <p class="text-primary font-bold font-title-lg text-base">
                Dra. Hj. Ratnawati Arif, M.Si
            </p>
            <p class="text-on-surface-variant text-xs mt-1 uppercase tracking-wider font-semibold">
                Bupati Kabupaten Sinjai
            </p>
        </div>

        <div class="bg-surface-container-low p-6 rounded-lg border border-outline-variant shadow-sm border-t-4 border-t-primary flex flex-col items-center text-center">
            <h3 class="font-title-lg text-title-lg text-primary mb-4 font-bold w-full text-left border-b border-outline-variant pb-2">
                Sambutan Kepala Dispusip Sinjai
            </h3>
            <div class="w-48 h-60 overflow-hidden rounded-lg mb-4 shadow-sm border border-outline-variant">
                <img src="<?= base_url('img/kepala_dinas.jpeg') ?>" alt="Drs. ANDI MUHAMMAD IDNAN,M.Si" class="w-full h-full object-cover object-top" onerror="this.src='<?= base_url('img/logo.png') ?>'; this.className='w-full h-full object-contain p-4 bg-white';">
            </div>
            <p class="text-primary font-bold font-title-lg text-base">
                Drs. ANDI MUHAMMAD IDNAN, M.Si
            </p>
            <p class="text-on-surface-variant text-xs mt-1 uppercase tracking-wider font-semibold mb-4">
                Kepala Dinas Perpustakaan &amp; Kearsipan Sinjai
            </p>
            <div class="text-on-surface-variant text-sm text-justify font-body-md leading-relaxed border-t border-outline-variant pt-4">
                Situs ini sebagai salah satu media informasi dalam pelayanan publik Dispusip Sinjai dan juga sebagai upaya transparansi. Harapan kami tentu saja situs ini bisa dijadikan sumber rujukan informasi berkaitan Perpustakaan dan Kearsipan serta bermanfaat bagi masyarakat. Informasi yang disediakan dalam situs ini antara lain Profil Lembaga, Layanan Perpustakaan dan Kearsipan, serta informasi lain terkait kegiatan yang dilakukan Dispusip Sinjai.
            </div>
        </div>

        <div class="bg-surface-container-low p-6 rounded-lg border border-outline-variant shadow-sm border-t-4 border-t-secondary flex flex-col items-center w-full">
            <h3 class="font-title-lg text-title-lg text-primary mb-3 font-bold w-full text-left border-b border-outline-variant pb-2 flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">phone_in_talk</span>
                Nomor Telepon Penting
            </h3>
            
            <div class="bg-secondary-fixed text-on-secondary-fixed px-3 py-1.5 rounded-lg text-xs font-bold w-full text-center mb-3">
                Kode Area Sinjai : 0482
            </div>
            
            <div class="w-full divide-y divide-outline-variant/40">
                <div class="flex justify-between py-2 text-sm">
                    <span class="font-bold text-primary">Polisi</span>
                    <span class="text-on-surface-variant font-mono font-semibold">21110</span>
                </div>
                <div class="flex justify-between py-2 text-sm">
                    <span class="font-bold text-primary">PMK</span>
                    <span class="text-on-surface-variant font-mono font-semibold">2425438</span>
                </div>
                <div class="flex justify-between py-2 text-sm">
                    <span class="font-bold text-primary">RSUD</span>
                    <span class="text-on-surface-variant font-mono font-semibold">21132</span>
                </div>
                <div class="flex justify-between py-2 text-sm">
                    <span class="font-bold text-primary">Emergency 118</span>
                    <span class="text-on-surface-variant font-mono font-semibold">23116</span>
                </div>
                <div class="flex justify-between py-2 text-sm">
                    <span class="font-bold text-primary">RadioSB</span>
                    <span class="text-on-surface-variant font-mono font-semibold">22066</span>
                </div>
                <div class="flex justify-between py-2 text-sm">
                    <span class="font-bold text-primary">SinjaiTV</span>
                    <span class="text-on-surface-variant font-mono font-semibold">22888</span>
                </div>
                <div class="flex justify-between py-2 text-sm">
                    <span class="font-bold text-primary">AWS</span>
                    <span class="text-on-surface-variant font-mono font-semibold">21432</span>
                </div>
                <div class="flex justify-between py-2 text-sm">
                    <span class="font-bold text-primary">PLN</span>
                    <span class="text-on-surface-variant font-mono font-semibold">21018</span>
                </div>
                <div class="flex justify-between py-2 text-sm">
                    <span class="font-bold text-primary">PDAM</span>
                    <span class="text-on-surface-variant font-mono font-semibold">21200</span>
                </div>
                <div class="flex justify-between py-2 text-sm">
                    <span class="font-bold text-primary">Telkom</span>
                    <span class="text-on-surface-variant font-mono font-semibold">2424200</span>
                </div>
                <div class="flex justify-between py-2 text-sm">
                    <span class="font-bold text-primary">PolPP</span>
                    <span class="text-on-surface-variant font-mono font-semibold">23305</span>
                </div>
                <div class="flex justify-between py-2 text-sm">
                    <span class="font-bold text-primary">Kodim</span>
                    <span class="text-on-surface-variant font-mono font-semibold">21025 / 21026</span>
                </div>
            </div>
        </div>
    </aside>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.getElementById('flyer-carousel');
        const prevBtn = document.getElementById('prev-flyer');
        const nextBtn = document.getElementById('next-flyer');
        
        if (carousel && prevBtn && nextBtn) {
            let scrollAmount = carousel.clientWidth * 0.8; // scroll 80% of width
            let autoplayInterval;
            
            const startAutoplay = () => {
                // Clear any existing interval to prevent duplicates
                clearInterval(autoplayInterval);
                autoplayInterval = setInterval(() => {
                    if (carousel.scrollLeft >= (carousel.scrollWidth - carousel.clientWidth - 1)) {
                        // Rewind to start if at the end
                        carousel.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        // Scroll next
                        carousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                    }
                }, 4000); // 4 detik
            };

            const stopAutoplay = () => {
                clearInterval(autoplayInterval);
            };
            
            prevBtn.addEventListener('click', () => {
                stopAutoplay();
                carousel.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                startAutoplay();
            });
            
            nextBtn.addEventListener('click', () => {
                stopAutoplay();
                carousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                startAutoplay();
            });
            
            // Pause autoplay when user interacts or hovers over the carousel
            carousel.addEventListener('mouseenter', stopAutoplay);
            carousel.addEventListener('mouseleave', startAutoplay);
            carousel.addEventListener('touchstart', stopAutoplay);
            carousel.addEventListener('touchend', startAutoplay);
            
            // Handle disabled state based on scroll position
            const updateButtons = () => {
                scrollAmount = carousel.clientWidth * 0.8; // update scroll amount on resize
                prevBtn.disabled = carousel.scrollLeft <= 0;
                // Add 1px buffer to account for decimal scaling in some browsers
                nextBtn.disabled = carousel.scrollLeft >= (carousel.scrollWidth - carousel.clientWidth - 1);
            };
            
            carousel.addEventListener('scroll', updateButtons);
            window.addEventListener('resize', updateButtons);
            
            // Initial check and start autoplay
            setTimeout(updateButtons, 100);
            startAutoplay();
        }
    });
</script>
<!-- Gallery Modal -->
<div id="galleryModal" class="fixed inset-0 z-[100] hidden bg-black/95 flex flex-col items-center justify-center opacity-0 transition-opacity duration-300">
    <!-- Close Button -->
    <button onclick="closeGalleryModal()" class="absolute top-4 right-4 z-[110] w-12 h-12 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-colors">
        <span class="material-symbols-outlined text-3xl">close</span>
    </button>
    
    <!-- Modal Header -->
    <div class="absolute top-4 left-4 right-20 z-[110]">
        <h3 id="galleryModalTitle" class="text-white font-title-lg font-bold drop-shadow-md"></h3>
        <p id="galleryModalCounter" class="text-white/80 text-sm mt-1"></p>
    </div>

    <!-- Image Container -->
    <div class="relative w-full max-w-5xl h-[80vh] flex items-center justify-center px-4 md:px-16 mt-12 md:mt-0">
        <img id="galleryModalImage" src="" alt="Gallery Image" class="max-w-full max-h-full object-contain shadow-2xl transition-all duration-300 transform scale-95 opacity-0">
        
        <!-- Navigation -->
        <button id="galleryPrevBtn" class="absolute left-2 md:left-4 top-1/2 -translate-y-1/2 w-10 h-10 md:w-14 md:h-14 bg-black/60 hover:bg-primary text-white rounded-full flex items-center justify-center transition-all disabled:opacity-30 disabled:pointer-events-none">
            <span class="material-symbols-outlined text-2xl md:text-4xl">chevron_left</span>
        </button>
        <button id="galleryNextBtn" class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 w-10 h-10 md:w-14 md:h-14 bg-black/60 hover:bg-primary text-white rounded-full flex items-center justify-center transition-all disabled:opacity-30 disabled:pointer-events-none">
            <span class="material-symbols-outlined text-2xl md:text-4xl">chevron_right</span>
        </button>
    </div>
    
    <!-- Caption -->
    <div id="galleryModalCaption" class="absolute bottom-6 left-0 right-0 text-center px-4 text-white font-body-md drop-shadow-md"></div>
</div>

<script>
    let currentGalleryPhotos = [];
    let currentPhotoIndex = 0;
    
    const galleryModal = document.getElementById('galleryModal');
    const galleryModalImage = document.getElementById('galleryModalImage');
    const galleryModalTitle = document.getElementById('galleryModalTitle');
    const galleryModalCounter = document.getElementById('galleryModalCounter');
    const galleryModalCaption = document.getElementById('galleryModalCaption');
    const galleryPrevBtn = document.getElementById('galleryPrevBtn');
    const galleryNextBtn = document.getElementById('galleryNextBtn');

    function openGalleryModal(photos, title) {
        if (!photos || photos.length === 0) {
            alert('Album galeri ini belum memiliki foto.');
            return;
        }
        currentGalleryPhotos = photos;
        currentPhotoIndex = 0;
        galleryModalTitle.textContent = title;
        
        showPhoto(currentPhotoIndex);
        
        galleryModal.classList.remove('hidden');
        // Trigger reflow
        void galleryModal.offsetWidth;
        galleryModal.classList.remove('opacity-0');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function closeGalleryModal() {
        galleryModal.classList.add('opacity-0');
        setTimeout(() => {
            galleryModal.classList.add('hidden');
            galleryModalImage.src = '';
            document.body.style.overflow = '';
        }, 300);
    }

    function showPhoto(index) {
        if (index < 0 || index >= currentGalleryPhotos.length) return;
        
        const photo = currentGalleryPhotos[index];
        galleryModalImage.classList.replace('scale-100', 'scale-95');
        galleryModalImage.classList.add('opacity-0');
        
        setTimeout(() => {
            galleryModalImage.src = photo.gambar_url;
            galleryModalCaption.textContent = photo.caption || '';
            galleryModalCounter.textContent = (index + 1) + ' dari ' + currentGalleryPhotos.length + ' Foto';
            
            galleryModalImage.classList.replace('scale-95', 'scale-100');
            galleryModalImage.classList.remove('opacity-0');
            
            // Update buttons
            galleryPrevBtn.disabled = index === 0;
            galleryNextBtn.disabled = index === currentGalleryPhotos.length - 1;
        }, 150);
    }

    galleryPrevBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        if (currentPhotoIndex > 0) {
            currentPhotoIndex--;
            showPhoto(currentPhotoIndex);
        }
    });

    galleryNextBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        if (currentPhotoIndex < currentGalleryPhotos.length - 1) {
            currentPhotoIndex++;
            showPhoto(currentPhotoIndex);
        }
    });

    // Close on background click
    galleryModal.addEventListener('click', (e) => {
        if (e.target === galleryModal || e.target.parentElement === galleryModal && e.target !== galleryModalImage) {
            closeGalleryModal();
        }
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (!galleryModal.classList.contains('hidden')) {
            if (e.key === 'Escape') closeGalleryModal();
            if (e.key === 'ArrowLeft') galleryPrevBtn.click();
            if (e.key === 'ArrowRight') galleryNextBtn.click();
        }
    });
</script>
<?= $this->endSection() ?>
