<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Moderasi Komentar Pengunjung<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
        <i class="fa-solid fa-house text-sm"></i>
        <span>Dashboard</span>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <span>Manajemen Konten</span>
        <i class="fa-solid fa-chevron-right text-sm"></i>
        <span class="font-bold text-primary">Comments</span>
    </div>
    <h2 class="font-headline-lg text-headline-lg text-primary">Moderasi Komentar Pengunjung</h2>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<!-- Validation Error Notifications -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong class="font-bold block mb-1">Gagal memproses aksi:</strong>
        <ul class="list-disc pl-5 text-sm">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container font-label-md text-label-md text-on-surface-variant border-b border-outline-variant">
                    <th class="p-4 py-3 font-medium w-16">ID</th>
                    <th class="p-4 py-3 font-medium w-48">Pengunjung</th>
                    <th class="p-4 py-3 font-medium">Isi Komentar</th>
                    <th class="p-4 py-3 font-medium w-48">Artikel Terkait</th>
                    <th class="p-4 py-3 font-medium w-28">Status</th>
                    <th class="p-4 py-3 font-medium w-36">Tanggal</th>
                    <th class="p-4 py-3 font-medium text-right w-44">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant">
                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $item): ?>
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 py-3 text-on-surface-variant"><?= esc($item['komentar_id']) ?></td>
                            <td class="p-4 py-3">
                                <span class="font-semibold text-primary block"><?= esc($item['nama_pengunjung']) ?></span>
                                <span class="text-xs text-on-surface-variant block truncate max-w-[12rem]"><?= esc($item['email_pengunjung'] ?: '-') ?></span>
                            </td>
                            <td class="p-4 py-3">
                                <?php if ($item['komentar_induk_id']): ?>
                                    <div class="text-xs text-on-surface-variant font-medium mb-1 flex items-center gap-1">
                                        <i class="fa-solid fa-reply text-xs"></i>
                                        <span>Membalas komentar ID #<?= esc($item['komentar_induk_id']) ?></span>
                                    </div>
                                <?php endif; ?>
                                <div class="text-on-surface text-sm max-w-md whitespace-normal break-words"><?= nl2br(esc($item['isi_komentar'])) ?></div>
                                
                                <!-- Inline Reply Form Drawer -->
                                <div id="reply-form-<?= $item['komentar_id'] ?>" class="hidden mt-3 p-3 bg-surface-container rounded border border-outline-variant">
                                    <form action="<?= base_url('admin/comments/reply/' . $item['komentar_id']) ?>" method="POST" class="flex flex-col gap-2">
                                        <?= csrf_field() ?>
                                        <label class="text-xs font-bold text-primary flex items-center gap-1">
                                            <i class="fa-solid fa-reply text-sm"></i> Balas Komentar <?= esc($item['nama_pengunjung']) ?>:
                                        </label>
                                        <textarea required name="reply_content" rows="2" class="w-full text-sm bg-surface-container-lowest border border-outline-variant rounded p-2 focus:outline-none focus:ring-1 focus:ring-primary-container" placeholder="Tulis balasan admin..."></textarea>
                                        <div class="flex gap-2 justify-end">
                                            <button type="button" onclick="toggleReply(<?= $item['komentar_id'] ?>)" class="px-3 py-1 text-xs border border-outline rounded hover:bg-surface-container-low transition-colors">Batal</button>
                                            <button type="submit" class="px-3 py-1 text-xs bg-primary text-on-primary rounded hover:bg-surface-tint transition-colors font-semibold">Kirim Balasan</button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                            <td class="p-4 py-3 text-sm font-medium text-on-surface-variant max-w-xs truncate" title="<?= esc($item['artikel_judul']) ?>">
                                <?= esc($item['artikel_judul']) ?>
                            </td>
                            <td class="p-4 py-3">
                                <?php if ($item['status'] === 'Disetujui'): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#E6F4EA] text-[#137333] border border-[#137333]/10">
                                        Disetujui
                                    </span>
                                <?php elseif ($item['status'] === 'Spam'): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#FCE8E6] text-[#C5221F] border border-[#C5221F]/10">
                                        Spam
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#FEF7E0] text-[#B06000] border border-[#B06000]/10">
                                        Menunggu
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 py-3 text-xs text-on-surface-variant"><?= date('d M Y, H:i', strtotime($item['created_at'])) ?></td>
                            <td class="p-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <?php if ($item['status'] !== 'Disetujui'): ?>
                                        <a href="<?= base_url('admin/comments/approve/' . $item['komentar_id']) ?>" class="p-1 text-[#137333] hover:bg-[#E6F4EA] rounded transition-colors" title="Setujui">
                                            <i class="fa-solid fa-check-circle text-[20px]"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($item['status'] !== 'Spam'): ?>
                                        <a href="<?= base_url('admin/comments/spam/' . $item['komentar_id']) ?>" class="p-1 text-[#C5221F] hover:bg-[#FCE8E6] rounded transition-colors" title="Tandai Spam">
                                            <i class="fa-solid fa-triangle-exclamation text-[20px]"></i>
                                        </a>
                                    <?php endif; ?>
                                    <button onclick="toggleReply(<?= $item['komentar_id'] ?>)" class="p-1 text-primary hover:bg-surface-container rounded transition-colors" title="Balas">
                                        <i class="fa-solid fa-reply text-[20px]"></i>
                                    </button>
                                    <a href="<?= base_url('admin/comments/edit/' . $item['komentar_id']) ?>" class="p-1 text-on-surface-variant hover:text-primary transition-colors rounded hover:bg-surface-container" title="Edit">
                                        <i class="fa-solid fa-pen text-[20px]"></i>
                                    </a>
                                    <a href="<?= base_url('admin/comments/delete/' . $item['komentar_id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini beserta seluruh balasannya?')" class="p-1 text-on-surface-variant hover:text-error transition-colors rounded hover:bg-error-container" title="Hapus">
                                        <i class="fa-solid fa-trash text-[20px]"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="p-4 text-center text-on-surface-variant">Belum ada komentar pengunjung.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function toggleReply(id) {
    const el = document.getElementById('reply-form-' + id);
    if (el) {
        el.classList.toggle('hidden');
    }
}
</script>
<?= $this->endSection() ?>
