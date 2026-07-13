<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login Admin - DISPUSIP Sinjai</title>
    
    <!-- CSS Portal & Admin -->
    <link href="<?= base_url('css/app.css') ?>" rel="stylesheet"/>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Public+Sans:wght@400;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Public Sans', sans-serif;
            background: radial-gradient(circle at 10% 20%, rgb(0, 32, 70) 0%, rgb(0, 15, 35) 90.2%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        }
        .glow-effect:focus-within {
            box-shadow: 0 0 15px rgba(119, 90, 25, 0.25);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 overflow-x-hidden">

<div class="w-full max-w-md">
    <!-- Card Container -->
    <div class="glass-card rounded-2xl overflow-hidden p-8 transition-all duration-300 transform hover:scale-[1.01]">
        
        <!-- Header -->
        <div class="flex flex-col items-center mb-8 text-center">
            <div class="w-20 h-20 mb-4 bg-white rounded-full p-2.5 shadow-md flex items-center justify-center transition-transform duration-300 hover:rotate-6">
                <img alt="Logo DISPUSIP SINJAI" class="h-full w-auto object-contain" src="<?= base_url('img/logo.png') ?>"/>
            </div>
            <h1 class="text-2xl font-black text-primary tracking-tight">DISPUSIP SINJAI</h1>
            <p class="text-xs text-on-surface-variant font-medium mt-1 uppercase tracking-widest">Portal Administrasi</p>
        </div>

        <!-- Notification Alerts -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-50 border-l-4 border-error text-error p-4 rounded-lg mb-6 flex items-start gap-3 shadow-sm animate-fade-in" role="alert" id="alert-error">
                <span class="material-symbols-outlined text-error shrink-0">error</span>
                <div class="text-sm font-semibold">
                    <?= session()->getFlashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 flex items-start gap-3 shadow-sm animate-fade-in" role="alert" id="alert-success">
                <span class="material-symbols-outlined text-green-600 shrink-0">check_circle</span>
                <div class="text-sm font-semibold">
                    <?= session()->getFlashdata('success') ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form action="<?= base_url('login') ?>" method="POST" class="space-y-5">
            <?= csrf_field() ?>

            <!-- Username Input -->
            <div class="space-y-1.5">
                <label for="username" class="text-sm font-bold text-primary tracking-wide block">Username atau Email</label>
                <div class="relative glow-effect rounded-lg">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">person</span>
                    <input 
                        type="text" 
                        name="username" 
                        id="username" 
                        value="<?= old('username') ?>"
                        placeholder="Masukkan username atau email" 
                        class="w-full pl-11 pr-4 py-3 rounded-lg border border-outline bg-white text-on-background placeholder:text-outline/70 focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all font-medium"
                        required
                    />
                </div>
            </div>

            <!-- Password Input -->
            <div class="space-y-1.5">
                <div class="flex justify-between items-center">
                    <label for="password" class="text-sm font-bold text-primary tracking-wide block">Password</label>
                </div>
                <div class="relative glow-effect rounded-lg">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">lock</span>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        placeholder="Masukkan password" 
                        class="w-full pl-11 pr-11 py-3 rounded-lg border border-outline bg-white text-on-background placeholder:text-outline/70 focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all font-medium"
                        required
                    />
                    <button 
                        type="button" 
                        id="toggle-password" 
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-primary transition-colors flex items-center justify-center p-1 rounded-md"
                        title="Tampilkan password"
                    >
                        <span class="material-symbols-outlined" id="eye-icon">visibility</span>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full bg-primary hover:bg-primary-container text-white hover:text-on-primary font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer flex items-center justify-center gap-2 text-base mt-2"
                id="btn-submit"
            >
                Masuk Halaman Admin
                <span class="material-symbols-outlined text-lg">login</span>
            </button>
        </form>

        <!-- Back to Portal Link -->
        <div class="mt-8 pt-6 border-t border-outline-variant text-center">
            <a 
                href="<?= base_url('/') ?>" 
                class="inline-flex items-center gap-1.5 text-sm font-bold text-secondary hover:text-primary transition-colors duration-200"
                id="link-portal"
            >
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali ke Portal Publik
            </a>
        </div>
    </div>
</div>

<script>
    // Password visibility toggle logic
    const passwordInput = document.getElementById('password');
    const togglePasswordBtn = document.getElementById('toggle-password');
    const eyeIcon = document.getElementById('eye-icon');

    togglePasswordBtn.addEventListener('click', () => {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        if (type === 'text') {
            eyeIcon.textContent = 'visibility_off';
            togglePasswordBtn.setAttribute('title', 'Sembunyikan password');
        } else {
            eyeIcon.textContent = 'visibility';
            togglePasswordBtn.setAttribute('title', 'Tampilkan password');
        }
    });
</script>

</body>
</html>
