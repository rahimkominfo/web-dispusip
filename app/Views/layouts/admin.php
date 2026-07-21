<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= $this->renderSection('title') ?> - DISPUSIP Admin Dashboard</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/logo.png') ?>"/>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('img/logo.png') ?>"/>
    
    <!-- Local Compiled Tailwind and FontAwesome CSS -->
    <link href="<?= base_url('css/app.css') ?>" rel="stylesheet"/>
    
    <!-- CKEditor 5 CSS -->
    <link href="<?= base_url('vendor/ckeditor5/browser/ckeditor5.css') ?>" rel="stylesheet"/>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&amp;family=Public+Sans:wght@400;600;700;900&amp;display=swap" rel="stylesheet"/>
    
    <style <?= csp_style_nonce() ?>>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-md text-body-md flex min-h-screen">
<?php
$activeClass = "flex items-center gap-3 text-primary font-bold border-l-4 border-secondary-fixed bg-surface-container-high px-4 py-3 font-label-md text-label-md transition-all duration-150 rounded-r-lg";
$inactiveClass = "flex items-center gap-3 text-on-surface-variant px-4 py-3 hover:bg-surface-container hover:bg-surface-container-high transition-all duration-150 font-label-md text-label-md rounded-lg";
?>
<!-- SideNavBar -->
<nav class="docked left-0 h-full w-64 border-r border-outline-variant flat no shadows fixed left-0 top-0 bottom-0 w-64 flex flex-col bg-surface-container-low z-40 hidden md:flex">
    <div class="h-[64px] flex items-center px-gutter gap-3 border-b border-outline-variant bg-surface-container-low shrink-0">
        <img alt="Logo DISPUSIP SINJAI" class="h-10 w-auto object-contain" src="<?= base_url('img/logo.png') ?>"/>
        <span class="font-bold text-primary text-base md:text-lg tracking-tight">DISPUSIP SINJAI</span>
    </div>
    <div class="px-gutter py-6 flex-grow overflow-y-auto">
        <ul class="space-y-2">
            <li>
                <a class="<?= url_is('admin') ? $activeClass : $inactiveClass ?>" href="<?= base_url('admin') ?>">
                    <i class="fa-solid fa-gauge"></i>
                    Dashboard
                </a>
            </li>
            <li class="pt-4 pb-2 px-4 font-label-md text-label-md font-bold text-on-surface-variant uppercase tracking-wider">Manajemen Konten</li>
            <li>
                <a class="<?= url_is('admin/news*') ? $activeClass : $inactiveClass ?>" href="<?= base_url('admin/news') ?>">
                    <i class="fa-solid fa-file-lines"></i>
                    Berita
                </a>
            </li>
            <li>
                <a class="<?= url_is('admin/categories*') ? $activeClass : $inactiveClass ?>" href="<?= base_url('admin/categories') ?>">
                    <i class="fa-solid fa-list"></i>
                    Kategori
                </a>
            </li>
            <li>
                <a class="<?= url_is('admin/tags*') ? $activeClass : $inactiveClass ?>" href="<?= base_url('admin/tags') ?>">
                    <i class="fa-solid fa-hashtag"></i>
                    Tags
                </a>
            </li>
            <li>
                <a class="<?= url_is('admin/comments*') ? $activeClass : $inactiveClass ?>" href="<?= base_url('admin/comments') ?>">
                    <i class="fa-solid fa-comments"></i>
                    Komentar
                </a>
            </li>
            <li class="pt-4 pb-2 px-4 font-label-md text-label-md font-bold text-on-surface-variant uppercase tracking-wider">Halaman &amp; Tampilan</li>
            <li>
                <a class="<?= url_is('admin/pages*') ? $activeClass : $inactiveClass ?>" href="<?= base_url('admin/pages') ?>">
                    <i class="fa-solid fa-globe"></i>
                    Halaman Statis
                </a>
            </li>
            <li>
                <a class="<?= url_is('admin/menus*') ? $activeClass : $inactiveClass ?>" href="<?= base_url('admin/menus') ?>">
                    <i class="fa-solid fa-bars"></i>
                    Manajemen Menu
                </a>
            </li>
            <li>
                <a class="<?= url_is('admin/flyers*') ? $activeClass : $inactiveClass ?>" href="<?= base_url('admin/flyers') ?>">
                    <i class="fa-solid fa-images"></i>
                    Banner/Flyer
                </a>
            </li>
            <li>
                <a class="<?= url_is('admin/running-text*') ? $activeClass : $inactiveClass ?>" href="<?= base_url('admin/running-text') ?>">
                    <i class="fa-solid fa-ellipsis-h"></i>
                    Running Text
                </a>
            </li>
            <li class="pt-4 pb-2 px-4 font-label-md text-label-md font-bold text-on-surface-variant uppercase tracking-wider">Media &amp; Galeri</li>
            <li>
                <a class="<?= url_is('admin/media*') ? $activeClass : $inactiveClass ?>" href="<?= base_url('admin/media') ?>">
                    <i class="fa-solid fa-photo-film"></i>
                    Media
                </a>
            </li>
            <li>
                <a class="<?= url_is('admin/gallery*') ? $activeClass : $inactiveClass ?>" href="<?= base_url('admin/gallery') ?>">
                    <i class="fa-solid fa-folder-open"></i>
                    Galeri
                </a>
            </li>
            <li>
                <a class="<?= url_is('admin/youtube*') ? $activeClass : $inactiveClass ?>" href="<?= base_url('admin/youtube') ?>">
                    <i class="fa-brands fa-youtube"></i>
                    Youtube
                </a>
            </li>
            <li class="pt-4 pb-2 px-4 font-label-md text-label-md font-bold text-on-surface-variant uppercase tracking-wider">Pengguna &amp; Sistem</li>
            <li>
                <a class="<?= url_is('admin/users*') ? $activeClass : $inactiveClass ?>" href="<?= base_url('admin/users') ?>">
                    <i class="fa-solid fa-user-gear"></i>
                    Manajemen Pengguna
                </a>
            </li>
            <li>
                <a class="<?= url_is('admin/roles*') ? $activeClass : $inactiveClass ?>" href="<?= base_url('admin/roles') ?>">
                    <i class="fa-solid fa-user-shield"></i>
                    Peran
                </a>
            </li>

        </ul>
    </div>
    <div class="px-gutter py-4 border-t border-outline-variant flex flex-col gap-1">
        <a class="flex items-center gap-3 text-on-surface-variant px-4 py-2.5 hover:bg-surface-container hover:bg-surface-container-high transition-all duration-150 font-label-md text-label-md rounded-lg" href="<?= base_url('/') ?>">
            <i class="fa-solid fa-external-link-alt"></i>
            Exit to Portal
        </a>
        <a class="flex items-center gap-3 text-error hover:bg-red-50 hover:text-on-error-container transition-all duration-150 font-label-md text-label-md rounded-lg font-bold" href="<?= base_url('logout') ?>">
            <i class="fa-solid fa-sign-out-alt"></i>
            Keluar / Logout
        </a>
    </div>
</nav>

<!-- Main Content Wrapper -->
<div class="flex-1 flex flex-col md:ml-64 w-full">
    <!-- TopAppBar -->
    <header class="docked full-width top-0 bg-primary shadow-sm fixed top-0 w-full z-50 flex justify-between items-center px-gutter h-[64px] md:w-[calc(100%-16rem)] right-0">
        <div class="flex items-center gap-4">
            <button class="text-on-primary md:hidden p-2">
                <i class="fa-solid fa-bars"></i>
            </button>
            <!-- Brand on Mobile -->
            <a class="flex items-center gap-2 md:hidden" href="#">
                <img alt="Logo DISPUSIP SINJAI" class="h-8 w-auto object-contain" src="<?= base_url('img/logo.png') ?>"/>
                <span class="font-bold text-on-primary text-base tracking-tight">DISPUSIP SINJAI</span>
            </a>
            <!-- Title on Desktop -->
            <h1 class="hidden md:block font-headline-md text-headline-md font-bold text-on-primary">Panel Admin DISPUSIP</h1>
        </div>
        <div class="flex items-center gap-3 text-on-primary">
            <!-- User Info Badge -->
            <span class="hidden sm:inline bg-primary-container text-on-primary-container px-3 py-1.5 rounded-full text-xs font-bold border border-outline/20">
                <?= esc(session()->get('nama_publik') ?? 'Admin') ?>
            </span>
            <button class="p-2 hover:text-secondary-fixed transition-colors duration-200 rounded-full relative">
                <i class="fa-solid fa-bell"></i>
                <span class="absolute top-1 right-1 w-2 h-2 bg-error rounded-full"></span>
            </button>
            <a class="p-2 hover:text-secondary-fixed transition-colors duration-200 rounded-full flex items-center justify-center" href="<?= base_url('/') ?>" title="Exit to Portal">
                <i class="fa-solid fa-external-link-alt"></i>
            </a>
            <a class="p-2 hover:text-red-300 transition-colors duration-200 rounded-full flex items-center justify-center" href="<?= base_url('logout') ?>" title="Keluar / Logout">
                <i class="fa-solid fa-sign-out-alt"></i>
            </a>
        </div>
    </header>

    <!-- Main Canvas -->
    <main class="flex-1 p-gutter pt-[88px] max-w-container-max mx-auto w-full">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="w-full py-gutter px-gutter flex flex-col md:flex-row justify-between items-center bg-primary text-on-primary border-t border-on-primary-fixed-variant mt-12 flat no shadows">
        <div class="font-headline-md text-headline-md text-on-primary mb-4 md:mb-0 text-sm opacity-80">
            © 2026 Panel Admin DISPUSIP. Hak cipta dilindungi.
        </div>
        <div class="flex gap-6 font-label-md text-label-md">
            <a class="text-on-primary-fixed-variant hover:text-secondary-fixed-dim underline transition-all" href="#">Bantuan</a>
            <a class="text-on-primary-fixed-variant hover:text-secondary-fixed-dim underline transition-all" href="#">Dokumentasi</a>
        </div>
    </footer>
</div>

<!-- CKEditor 5 UMD Script -->
<script src="<?= base_url('vendor/ckeditor5/browser/ckeditor5.umd.js') ?>"></script>
<script <?= csp_script_nonce() ?>>
    // Coba global ckeditor5 (bawaan CDN) atau CKEDITOR (bawaan local builder)
    const CKEditorGlobal = window.ckeditor5 || window.CKEDITOR || {};
    
    const {
        ClassicEditor,
        Essentials,
        Paragraph,
        Bold,
        Italic,
        Font,
        Alignment,
        Image,
        ImageUpload,
        ImageToolbar,
        ImageCaption,
        ImageStyle,
        ImageResize,
        LinkImage,
        Link,
        Base64UploadAdapter,
        List,
        ListProperties,
        TodoList,
        Table,
        TableToolbar,
        TableProperties,
        TableCellProperties,
        TableCaption,
        TableColumnResize
    } = CKEditorGlobal;

    function initEditor() {
        if (!ClassicEditor) {
            alert("CKEditor script gagal dimuat. Pastikan URL ckeditor5.umd.js benar (cek Inspect Element -> Network).");
            return;
        }

        const editorElement = document.querySelector('#editor') || document.querySelector('.editor');
        if (editorElement) {
            ClassicEditor
                .create(editorElement, {
                    licenseKey: 'GPL',
                    plugins: [ 
                        Essentials, Paragraph, Bold, Italic, Font, Alignment,
                        Image, ImageUpload, ImageToolbar, ImageCaption, ImageStyle, ImageResize, LinkImage, Link, Base64UploadAdapter,
                        List, ListProperties, TodoList,
                        Table, TableToolbar, TableProperties, TableCellProperties, TableCaption, TableColumnResize
                    ],
                    toolbar: [
                        'undo', 'redo', '|', 'bold', 'italic', 'link', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                        'alignment', '|',
                        'insertTable', 'uploadImage'
                    ],
                    image: {
                        toolbar: [
                            'imageTextAlternative', 'toggleImageCaption', '|',
                            'imageStyle:inline', 'imageStyle:block', 'imageStyle:side', '|',
                            'linkImage'
                        ]
                    },
                    table: {
                        contentToolbar: [
                            'tableColumn', 'tableRow', 'mergeTableCells',
                            'tableProperties', 'tableCellProperties', 'toggleTableCaption'
                        ]
                    }
                })
                .then( editor => {
                    window.editor = editor;
                } )
                .catch( error => {
                    console.error("CKEditor initialization error:", error);
                    alert("Gagal memuat CKEditor: " + error.message);
                } );
        }
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initEditor);
    } else {
        initEditor();
    }
</script>

</body>
</html>
