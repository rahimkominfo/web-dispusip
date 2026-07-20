<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Galeri Video<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Header Section -->
<div class="mb-12 md:mb-16 text-center max-w-3xl mx-auto pt-8">
    <span class="bg-primary/10 text-primary px-4 py-1.5 rounded-full font-caption text-xs uppercase tracking-widest font-bold mb-4 inline-block shadow-sm">
        Dokumentasi
    </span>
    <h1 class="font-display text-4xl md:text-5xl font-black text-on-background mb-4 text-primary leading-tight">
        Galeri Video
    </h1>
    <p class="text-on-surface-variant font-body-lg text-lg leading-relaxed max-w-2xl mx-auto">
        Tonton dokumentasi kegiatan dinas, profil, sosialisasi, dan informasi penting lainnya melalui kanal YouTube resmi kami.
    </p>
</div>

<!-- Videos Grid -->
<?php if (!empty($videos)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        <?php foreach ($videos as $video): ?>
            <div class="group relative rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 cursor-pointer aspect-video bg-surface-container-lowest border border-outline-variant hover:border-primary/40 transform hover:-translate-y-1.5" 
                 onclick="playVideo('<?= esc($video['youtube_id'], 'js') ?>', '<?= esc($video['judul'], 'js') ?>', '<?= esc($video['deskripsi'] ?? '', 'js') ?>')">
                
                <!-- YouTube High-Quality Thumbnail -->
                <img src="https://img.youtube.com/vi/<?= esc($video['youtube_id']) ?>/hqdefault.jpg" alt="<?= esc($video['judul']) ?>" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105">
                
                <!-- Overlay Gradient -->
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent opacity-90 group-hover:opacity-100 transition-opacity flex flex-col justify-between p-5">
                    
                    <!-- Top YouTube Badge -->
                    <div class="flex justify-end">
                        <span class="bg-red-600 text-white font-mono text-[10px] font-bold px-2 py-0.5 rounded flex items-center gap-1 shadow">
                            <i class="fa-brands fa-youtube"></i> YOUTUBE
                        </span>
                    </div>

                    <!-- Center Play Button Icon -->
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="w-14 h-14 bg-red-600/90 group-hover:bg-red-600 rounded-full flex items-center justify-center transition-all duration-300 transform group-hover:scale-110 shadow-lg group-hover:shadow-red-600/40">
                            <i class="fa-solid fa-play text-white text-xl ml-1"></i>
                        </div>
                    </div>

                    <!-- Bottom Titles -->
                    <div class="mt-auto">
                        <h3 class="text-white font-title-md font-bold line-clamp-2 leading-tight mb-1" style="text-shadow: 1px 1px 4px rgba(0,0,0,1);">
                            <?= esc($video['judul']) ?>
                        </h3>
                        <?php if (!empty($video['deskripsi'])): ?>
                            <p class="text-gray-200 text-xs line-clamp-2 mb-2 leading-relaxed opacity-95" style="text-shadow: 1px 1px 3px rgba(0,0,0,1);">
                                <?= esc($video['deskripsi']) ?>
                            </p>
                        <?php endif; ?>
                        <p class="text-gray-300 text-[10px] flex items-center gap-1 font-mono uppercase tracking-wider" style="text-shadow: 1px 1px 2px rgba(0,0,0,1);">
                            <i class="fa-regular fa-clock"></i> <?= format_indo($video['created_at'], 'short') ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <!-- Empty State -->
    <div class="w-full max-w-2xl mx-auto text-center py-20 bg-surface-container-lowest rounded-[2rem] border-2 border-dashed border-outline-variant">
        <div class="w-24 h-24 bg-surface-container rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
            <i class="fa-brands fa-youtube text-[48px] text-error"></i>
        </div>
        <h3 class="font-headline-sm text-headline-sm text-on-surface mb-3 font-bold">Belum ada Video</h3>
        <p class="font-body-lg text-on-surface-variant text-lg">
            Saat ini belum ada video YouTube yang dipublikasikan di galeri.
        </p>
    </div>
<?php endif; ?>

<!-- Video Player Modal -->
<div id="videoModal" class="fixed inset-0 z-[100] hidden bg-black/95 flex flex-col items-center justify-center opacity-0 transition-opacity duration-300">
    <!-- Close Button -->
    <button onclick="closeVideoModal()" class="absolute top-4 right-4 z-[110] w-12 h-12 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-colors">
        <i class="fa-solid fa-times text-3xl"></i>
    </button>
    
    <!-- Video Wrapper -->
    <div class="relative w-full max-w-4xl aspect-video px-4 md:px-12 mt-12 md:mt-0">
        <div class="w-full h-full rounded-2xl overflow-hidden shadow-2xl border border-outline-variant bg-black">
            <iframe id="modalIframe" class="w-full h-full" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
    </div>
    
    <!-- Video Meta Details -->
    <div class="max-w-2xl text-center px-6 mt-6">
        <h3 id="modalVideoTitle" class="text-white font-title-lg font-bold drop-shadow-md text-xl"></h3>
        <p id="modalVideoDesc" class="text-white/70 text-sm mt-2 leading-relaxed"></p>
    </div>
</div>

<script>
    const videoModal = document.getElementById('videoModal');
    const modalIframe = document.getElementById('modalIframe');
    const modalVideoTitle = document.getElementById('modalVideoTitle');
    const modalVideoDesc = document.getElementById('modalVideoDesc');

    function playVideo(youtubeId, judul, deskripsi) {
        modalVideoTitle.textContent = judul;
        modalVideoDesc.textContent = deskripsi || '';
        modalIframe.src = `https://www.youtube.com/embed/${youtubeId}?autoplay=1`;
        
        videoModal.classList.remove('hidden');
        // Trigger reflow
        void videoModal.offsetWidth;
        videoModal.classList.remove('opacity-0');
        document.body.style.overflow = 'hidden'; // Disable scroll on background
    }

    function closeVideoModal() {
        videoModal.classList.add('opacity-0');
        setTimeout(() => {
            videoModal.classList.add('hidden');
            modalIframe.src = '';
            document.body.style.overflow = ''; // Enable scroll
        }, 300);
    }

    // Close when clicking modal backdrop
    videoModal.addEventListener('click', (e) => {
        if (e.target === videoModal) {
            closeVideoModal();
        }
    });

    // Close on Escape key press
    document.addEventListener('keydown', (e) => {
        if (!videoModal.classList.contains('hidden') && e.key === 'Escape') {
            closeVideoModal();
        }
    });
</script>
<?= $this->endSection() ?>
