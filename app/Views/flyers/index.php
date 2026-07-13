<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Koleksi Banner & Flyer<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Header Section -->
<div class="mb-12 md:mb-16 text-center max-w-3xl mx-auto pt-8">
    <span class="bg-primary/10 text-primary px-4 py-1.5 rounded-full font-caption text-xs uppercase tracking-widest font-bold mb-4 inline-block shadow-sm">
        Media Promosi
    </span>
    <h1 class="font-display text-4xl md:text-5xl font-black text-on-background mb-4 text-primary leading-tight">
        Banner &amp; Flyer
    </h1>
    <p class="text-on-surface-variant font-body-lg text-lg leading-relaxed max-w-2xl mx-auto">
        Jelajahi kumpulan media promosi, pengumuman resmi, dan informasi visual visual terbaru dari Dinas Perpustakaan dan Kearsipan Kabupaten Sinjai.
    </p>
</div>

<!-- Flyers Grid -->
<?php if (!empty($flyers)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
        <?php foreach ($flyers as $index => $flyer): ?>
            <article class="group bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-outline-variant hover:border-primary/40 flex flex-col transform hover:-translate-y-1.5 relative">
                
                <!-- Image Container with Aspect Ratio -->
                <div class="relative w-full aspect-[4/3] overflow-hidden bg-surface-container">
                    <img 
                        src="<?= esc($flyer['gambar_url']) ?>" 
                        alt="<?= esc($flyer['judul']) ?>" 
                        loading="lazy"
                        class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                    >
                    
                    <!-- Overlay for better text readability on hover -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>

                <!-- Content Area -->
                <div class="p-6 md:p-8 flex flex-col flex-grow relative bg-white z-10 transition-colors duration-300">
                    <?php if (!empty($flyer['label'])): ?>
                        <div class="mb-4">
                            <span class="inline-block bg-secondary-fixed text-on-secondary-fixed text-[10px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-md shadow-sm">
                                <?= esc($flyer['label']) ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    
                    <h2 class="font-title-lg text-title-lg font-bold text-on-surface mb-3 line-clamp-2 group-hover:text-primary transition-colors leading-snug">
                        <?= esc($flyer['judul']) ?>
                    </h2>
                    
                    <!-- Actions -->
                    <div class="mt-auto pt-5 flex justify-between items-center border-t border-outline-variant/30">
                        <a href="<?= esc($flyer['gambar_url']) ?>" target="_blank" class="inline-flex items-center gap-1.5 text-sm font-label-lg text-primary hover:text-primary/80 transition-colors">
                            <span class="material-symbols-outlined text-[20px]">zoom_in</span> 
                            <span>Perbesar</span>
                        </a>
                        <a href="<?= esc($flyer['gambar_url']) ?>" download class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:bg-primary hover:text-on-primary transition-all duration-300 hover:scale-110 shadow-sm" title="Unduh Flyer">
                            <span class="material-symbols-outlined text-[20px]">download</span>
                        </a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <!-- Empty State -->
    <div class="w-full max-w-2xl mx-auto text-center py-20 bg-surface-container-lowest rounded-[2rem] border-2 border-dashed border-outline-variant">
        <div class="w-24 h-24 bg-surface-container rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
            <span class="material-symbols-outlined text-[48px] text-outline">photo_library</span>
        </div>
        <h3 class="font-headline-sm text-headline-sm text-on-surface mb-3 font-bold">Belum ada Flyer</h3>
        <p class="font-body-lg text-on-surface-variant text-lg">
            Saat ini belum ada media promosi atau flyer yang dipublikasikan.
        </p>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
