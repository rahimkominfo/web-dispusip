<?= $this->extend('layouts/public') ?>

<?= $this->section('title') ?><?= esc($article['judul']) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Breadcrumb -->
<nav aria-label="Breadcrumb" class="mb-8 font-label-md text-label-md text-on-surface-variant flex items-center gap-2 flex-wrap">
    <a class="hover:text-primary transition-colors" href="<?= base_url('/') ?>">Beranda</a>
    <i class="fa-solid fa-chevron-right text-[16px]"></i>
    <a class="hover:text-primary transition-colors" href="<?= base_url('berita') ?>">Berita</a>
    <?php if ($category): ?>
        <i class="fa-solid fa-chevron-right text-[16px]"></i>
        <a class="hover:text-primary transition-colors" href="<?= base_url('berita?kategori=' . $category['slug']) ?>"><?= esc($category['nama']) ?></a>
    <?php endif; ?>
    <i class="fa-solid fa-chevron-right text-[16px]"></i>
    <span aria-current="page" class="text-on-surface font-medium"><?= esc($article['judul']) ?></span>
</nav>

<div class="flex flex-col lg:flex-row gap-gutter">
    <!-- Left Column (70%) -->
    <article class="lg:w-8/12 flex flex-col gap-6">
        <header class="flex flex-col gap-4">
            <h1 class="font-display text-display text-on-surface"><?= esc($article['judul']) ?></h1>
            <div class="flex flex-wrap items-center gap-4 text-on-surface-variant font-caption text-caption border-b border-outline-variant pb-4">
                <div class="flex items-center gap-1">
                    <i class="fa-solid fa-calendar text-[16px]"></i>
                    <?= format_indo($article['tanggal_publikasi'], 'long') ?>
                </div>
                <div class="flex items-center gap-1">
                    <i class="fa-solid fa-user text-[16px]"></i>
                    By <?= esc($article['author_name'] ?? 'Admin') ?>
                </div>
                <?php if ($category): ?>
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-folder text-[16px]"></i>
                        <?= esc($category['nama']) ?>
                    </div>
                <?php endif; ?>
                <div class="flex items-center gap-1">
                    <i class="fa-solid fa-eye text-[16px]"></i>
                    <?= number_format($article['jumlah_tayang']) ?> Kali Dibaca
                </div>
            </div>
        </header>
        
        <?php if ($article['gambar_utama']): ?>
            <figure class="w-full h-[400px] md:h-[500px] rounded-lg overflow-hidden bg-surface-variant">
                <img alt="<?= esc($article['judul']) ?>" class="w-full h-full object-cover" src="<?= esc($article['gambar_utama']) ?>"/>
            </figure>
        <?php endif; ?>
        
        <div class="prose prose-slate max-w-none font-body-md text-body-md text-on-surface flex flex-col gap-4 leading-relaxed">
            <?= $article['konten'] ?>
        </div>
        
        <?php if (!empty($tags)): ?>
            <div class="flex flex-wrap gap-2 pt-4 border-t border-outline-variant">
                <?php foreach ($tags as $tag): ?>
                    <span class="bg-surface-container-high text-on-surface px-3 py-1 rounded-full font-caption text-caption hover:bg-primary-container hover:text-on-primary-container transition-colors cursor-pointer">#<?= esc($tag['nama']) ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Messages Notifications -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>
        
        <!-- Comments Section -->
        <section class="mt-8 bg-surface-container-lowest p-6 rounded-lg border border-outline-variant">
            <h3 class="font-title-lg text-title-lg text-on-surface mb-6 flex items-center gap-2">
                <i class="fa-solid fa-comments"></i>
                <?= count($parent_comments) + count($replies, COUNT_RECURSIVE) - count($replies) ?> Komentar
            </h3>
            
            <div class="flex flex-col gap-6 mb-8">
                <?php if (!empty($parent_comments)): ?>
                    <?php foreach ($parent_comments as $comment): ?>
                        <!-- Comment -->
                        <div class="flex gap-4 border-b border-outline-variant/30 pb-4 last:border-b-0">
                            <div class="w-10 h-10 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold shrink-0">
                                <?= strtoupper(substr(esc($comment['nama_pengunjung']), 0, 1)) ?>
                            </div>
                            <div class="flex flex-col w-full">
                                <div class="flex justify-between items-baseline mb-1">
                                    <span class="font-label-md text-label-md font-semibold text-on-surface"><?= esc($comment['nama_pengunjung']) ?></span>
                                    <span class="font-caption text-caption text-outline"><?= format_indo($comment['created_at'], 'short_time') ?></span>
                                </div>
                                <p class="font-body-md text-body-md text-on-surface-variant mb-2"><?= esc($comment['isi_komentar']) ?></p>
                                <button onclick="replyTo('<?= esc($comment['komentar_id']) ?>', '<?= esc($comment['nama_pengunjung']) ?>')" class="text-primary font-label-md text-label-md hover:underline self-start">Balas</button>
                                
                                <!-- Nested Replies -->
                                <?php if (isset($replies[$comment['komentar_id']])): ?>
                                    <?php foreach ($replies[$comment['komentar_id']] as $reply): ?>
                                        <div class="flex gap-4 mt-4 bg-surface-container p-4 rounded-lg">
                                            <div class="w-8 h-8 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold shrink-0 text-sm">
                                                <?= strtoupper(substr(esc($reply['nama_pengunjung']), 0, 1)) ?>
                                            </div>
                                            <div class="flex flex-col">
                                                <div class="flex items-baseline mb-1 gap-2">
                                                    <span class="font-label-md text-label-md font-semibold text-on-surface"><?= esc($reply['nama_pengunjung']) ?></span>
                                                    <?php if (strpos(strtolower($reply['nama_pengunjung']), 'admin') !== false || strpos(strtolower($reply['nama_pengunjung']), 'staff') !== false): ?>
                                                        <span class="bg-primary text-on-primary text-[10px] px-1.5 py-0.5 rounded font-bold">STAFF</span>
                                                    <?php endif; ?>
                                                    <span class="font-caption text-caption text-outline ml-auto"><?= format_indo($reply['created_at'], 'short_time') ?></span>
                                                </div>
                                                <p class="font-body-md text-body-md text-on-surface-variant"><?= esc($reply['isi_komentar']) ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-on-surface-variant text-center py-4">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                <?php endif; ?>
            </div>
            
            <!-- Comment Form -->
            <div class="border-t border-outline-variant pt-6" id="form-komentar">
                <h4 class="font-title-lg text-title-lg text-on-surface mb-2">Tinggalkan Komentar</h4>
                <div id="reply-alert" class="hidden bg-surface-container px-4 py-2 rounded mb-4 flex items-center justify-between">
                    <span class="text-sm font-label-md" id="reply-alert-text">Membalas komentar...</span>
                    <button onclick="cancelReply()" class="text-red-600 hover:text-red-800 text-xs font-bold uppercase">Batal</button>
                </div>
                
                <form action="<?= base_url('berita/komentar') ?>" method="POST" class="flex flex-col gap-4">
                    <input type="hidden" name="artikel_id" value="<?= esc($article['artikel_id']) ?>"/>
                    <input type="hidden" name="slug" value="<?= esc($article['slug']) ?>"/>
                    <input type="hidden" name="komentar_induk_id" id="komentar_induk_id" value=""/>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label class="font-label-md text-label-md text-on-surface">Nama Lengkap *</label>
                            <input required name="nama" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow" type="text"/>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="font-label-md text-label-md text-on-surface">Alamat Email (Opsional)</label>
                            <input name="email" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow" type="email"/>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="font-label-md text-label-md text-on-surface">Komentar *</label>
                        <textarea required name="komentar" class="w-full bg-surface-container-lowest border border-outline-variant rounded px-3 py-2 text-on-surface focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 focus:outline-none transition-shadow resize-y" placeholder="Masukkan komentar Anda..." rows="4"></textarea>
                    </div>
                    <button class="bg-primary text-on-primary hover:bg-surface-tint rounded px-6 py-2 font-label-md text-label-md self-start transition-colors" type="submit">Kirim Komentar</button>
                </form>
            </div>
        </section>
    </article>
    
    <!-- Right Column (30%) -->
    <aside class="lg:w-4/12 flex flex-col gap-8">
        <!-- Related News Widget -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg overflow-hidden shadow-sm">
            <div class="bg-surface-container-high px-4 py-3 border-b-2 border-secondary">
                <h3 class="font-title-lg text-title-lg text-on-surface flex items-center gap-2">
                    <i class="fa-solid fa-rss text-secondary"></i>
                    Berita Terkait
                </h3>
            </div>
            <ul class="flex flex-col divide-y divide-outline-variant">
                <?php if (!empty($latest_articles)): ?>
                    <?php foreach (array_slice($latest_articles, 0, 3) as $lat): ?>
                        <li>
                            <a class="flex flex-col p-4 hover:bg-surface-container-low transition-colors group" href="<?= base_url('berita/' . $lat['slug']) ?>">
                                <span class="font-caption text-caption text-outline mb-1">Berita</span>
                                <span class="font-label-md text-label-md text-on-surface group-hover:text-primary transition-colors line-clamp-2"><?= esc($lat['judul']) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Latest News Widget -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg overflow-hidden shadow-sm">
            <div class="bg-surface-container-high px-4 py-3 border-b-2 border-secondary">
                <h3 class="font-title-lg text-title-lg text-on-surface flex items-center gap-2">
                    <i class="fa-solid fa-certificate text-secondary"></i>
                    Berita Terbaru
                </h3>
            </div>
            <ul class="flex flex-col divide-y divide-outline-variant">
                <?php if (!empty($latest_articles)): ?>
                    <?php foreach ($latest_articles as $lat): ?>
                        <li>
                            <a class="flex flex-col p-4 hover:bg-surface-container-low transition-colors group" href="<?= base_url('berita/' . $lat['slug']) ?>">
                                <span class="font-caption text-caption text-outline mb-1">Terbaru</span>
                                <span class="font-label-md text-label-md text-on-surface group-hover:text-primary transition-colors line-clamp-2"><?= esc($lat['judul']) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Popular News Widget -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg overflow-hidden shadow-sm">
            <div class="bg-surface-container-high px-4 py-3 border-b-2 border-secondary">
                <h3 class="font-title-lg text-title-lg text-on-surface flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-secondary"></i>
                    Berita Terpopuler
                </h3>
            </div>
            <ul class="flex flex-col divide-y divide-outline-variant">
                <?php if (!empty($popular_articles)): ?>
                    <?php foreach ($popular_articles as $pop): ?>
                        <li>
                            <a class="flex flex-col p-4 hover:bg-surface-container-low transition-colors group" href="<?= base_url('berita/' . $pop['slug']) ?>">
                                <span class="font-caption text-caption text-outline mb-1">Populer</span>
                                <span class="font-label-md text-label-md text-on-surface group-hover:text-primary transition-colors line-clamp-2"><?= esc($pop['judul']) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </aside>
</div>

<script>
    function replyTo(id, name) {
        document.getElementById('komentar_induk_id').value = id;
        document.getElementById('reply-alert-text').innerText = 'Membalas komentar ' + name;
        document.getElementById('reply-alert').classList.remove('hidden');
        document.getElementById('form-komentar').scrollIntoView({ behavior: 'smooth' });
    }

    function cancelReply() {
        document.getElementById('komentar_induk_id').value = '';
        document.getElementById('reply-alert').classList.add('hidden');
    }
</script>
<?= $this->endSection() ?>
