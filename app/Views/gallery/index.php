<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?>Galeri Kegiatan<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Header Section -->
<div class="mb-12 md:mb-16 text-center max-w-3xl mx-auto pt-8">
    <span class="bg-primary/10 text-primary px-4 py-1.5 rounded-full font-caption text-xs uppercase tracking-widest font-bold mb-4 inline-block shadow-sm">
        Dokumentasi
    </span>
    <h1 class="font-display text-4xl md:text-5xl font-black text-on-background mb-4 text-primary leading-tight">
        Galeri Kegiatan
    </h1>
    <p class="text-on-surface-variant font-body-lg text-lg leading-relaxed max-w-2xl mx-auto">
        Kumpulan album foto dokumentasi kegiatan, acara, dan momen penting di lingkungan Dinas Perpustakaan dan Kearsipan Kabupaten Sinjai.
    </p>
</div>

<!-- Galleries Grid -->
<?php if (!empty($galleries)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        <?php foreach ($galleries as $gallery): ?>
            <div class="group relative rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 cursor-pointer aspect-video bg-surface-container-lowest border border-outline-variant hover:border-primary/40 transform hover:-translate-y-1.5" onclick="openGalleryModal(<?= htmlspecialchars(json_encode($gallery['photos']), ENT_QUOTES, 'UTF-8') ?>, '<?= esc($gallery['judul'], 'js') ?>')">
                
                <img src="<?= esc($gallery['sampul_url']) ?>" alt="<?= esc($gallery['judul']) ?>" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">
                
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent opacity-90 group-hover:opacity-100 flex flex-col justify-end p-5 transition-opacity">
                    <div class="mt-auto"></div>
                    <h3 class="text-white font-title-lg font-bold line-clamp-2 leading-tight mb-1" style="text-shadow: 1px 1px 5px rgba(0,0,0,1);"><?= esc($gallery['judul']) ?></h3>
                    <?php if (!empty($gallery['deskripsi'])): ?>
                        <p class="text-gray-100 text-sm line-clamp-2 mb-2 leading-relaxed" style="text-shadow: 1px 1px 4px rgba(0,0,0,1);"><?= esc($gallery['deskripsi']) ?></p>
                    <?php endif; ?>
                    <p class="text-primary-container text-xs flex items-center gap-1.5 font-bold uppercase tracking-wider pt-1" style="text-shadow: 1px 1px 3px rgba(0,0,0,1);">
                        <i class="fa-solid fa-images text-[16px]"></i> <?= count($gallery['photos']) ?> Foto Tersedia
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <!-- Empty State -->
    <div class="w-full max-w-2xl mx-auto text-center py-20 bg-surface-container-lowest rounded-[2rem] border-2 border-dashed border-outline-variant">
        <div class="w-24 h-24 bg-surface-container rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
            <i class="fa-solid fa-folder-open text-[48px] text-outline"></i>
        </div>
        <h3 class="font-headline-sm text-headline-sm text-on-surface mb-3 font-bold">Belum ada Galeri</h3>
        <p class="font-body-lg text-on-surface-variant text-lg">
            Saat ini belum ada album galeri kegiatan yang dipublikasikan.
        </p>
    </div>
<?php endif; ?>

<!-- Gallery Modal -->
<div id="galleryModal" class="fixed inset-0 z-[100] hidden bg-black/95 flex flex-col items-center justify-center opacity-0 transition-opacity duration-300">
    <!-- Close Button -->
    <button onclick="closeGalleryModal()" class="absolute top-4 right-4 z-[110] w-12 h-12 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-colors">
        <i class="fa-solid fa-times text-3xl"></i>
    </button>
    
    <!-- Modal Header -->
    <div class="absolute top-4 left-4 right-20 z-[110]">
        <h3 id="galleryModalTitle" class="text-white font-title-lg font-bold drop-shadow-md"></h3>
        <p id="galleryModalCounter" class="text-white/80 text-sm mt-1"></p>
    </div>

    <!-- Image Container -->
    <div class="relative w-full max-w-6xl h-[80vh] flex items-center justify-center px-4 md:px-20 mt-12 md:mt-0">
        <img id="galleryModalImage" src="" alt="Gallery Image" class="max-w-full max-h-full object-contain shadow-2xl transition-all duration-300 transform scale-95 opacity-0">
        
        <!-- Navigation -->
        <button id="galleryPrevBtn" class="absolute left-2 md:left-6 top-1/2 -translate-y-1/2 w-10 h-10 md:w-14 md:h-14 bg-black/60 hover:bg-primary text-white rounded-full flex items-center justify-center transition-all disabled:opacity-30 disabled:pointer-events-none">
            <i class="fa-solid fa-chevron-left text-2xl md:text-4xl"></i>
        </button>
        <button id="galleryNextBtn" class="absolute right-2 md:right-6 top-1/2 -translate-y-1/2 w-10 h-10 md:w-14 md:h-14 bg-black/60 hover:bg-primary text-white rounded-full flex items-center justify-center transition-all disabled:opacity-30 disabled:pointer-events-none">
            <i class="fa-solid fa-chevron-right text-2xl md:text-4xl"></i>
        </button>
    </div>
    
    <!-- Caption -->
    <div id="galleryModalCaption" class="absolute bottom-6 left-0 right-0 text-center px-6 text-white font-body-lg drop-shadow-md"></div>
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
