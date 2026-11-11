<?php
$settingsByKey = $settingsByKey ?? []; // ប្រើតម្លៃដែល Controller ផ្ញើមក
$shopName = $settingsByKey['shop_name']['setting_value'] ?? 'Skincare';
$shopLogo = $settingsByKey['shop_logo']['setting_value'] ?? '';


function getSettingValue(array $settings, string $key): string
{
    return (string) ($settings[$key]['setting_value'] ?? '');
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}


?>

<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Electro Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kantumruy Pro', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Decorative circles */
        body::before,
        body::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            pointer-events: none;
        }

        body::before {
            width: 500px;
            height: 500px;
            top: -200px;
            right: -150px;
        }

        body::after {
            width: 350px;
            height: 350px;
            bottom: -150px;
            left: -100px;
        }

        /* Login Box */
        .login-box {
            background: #fff;
            width: 100%;
            max-width: 420px;
            padding: 45px 40px;
            border-radius: 20px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.35);
            position: relative;
            z-index: 10;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Logo */
        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-logo .icon-box {
            width: 75px;
            height: 75px;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            margin: 0 auto 15px;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.35);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        /* .login-logo h1 {
            color: #1e3a8a;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .login-logo h1 span {
            color: #2563eb;
        }

        .login-logo p {
            color: #94a3b8;
            font-size: 13px;
        }

       
        .login-title {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-title h2 {
            color: #1e3a8a;
            font-size: 18px;
            font-weight: 600;
        } */
        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 24px 10px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.35);
            margin-bottom: 24px;
        }

        .logo-icon {
            background: #d92afc;
            width: 40px;
            height: 40px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            box-shadow: 0 8px 16px -4px rgba(218, 217, 228, 0.4);
            flex-shrink: 0;
        }

        .logo-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
        }

        .logo-text {
            font-weight: 700;
            font-size: 18px;
            letter-spacing: -0.3px;
            color: white;
            white-space: nowrap;
        }

        .logo-text span {
            color: #fd6eb6;
        }

        /* Alert */
        .alert {
            padding: 13px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.4s;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-6px);
            }

            75% {
                transform: translateX(6px);
            }
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #16a34a;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            color: #1e3a8a;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-group .input-wrap {
            position: relative;
        }

        .form-group .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
            pointer-events: none;
            transition: color 0.2s;
        }

        .form-group input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            font-family: inherit;
            color: #334155;
            background: #f8fafc;
            transition: all 0.25s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #2563eb;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .form-group input:focus+.input-icon {
            color: #2563eb;
        }

        .form-group input::placeholder {
            color: #cbd5e1;
        }

        /* Password Toggle */
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 16px;
            cursor: pointer;
            padding: 4px;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: #2563eb;
        }

        /* Remember & Forgot */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 13px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            cursor: pointer;
            user-select: none;
        }

        .remember-label input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #2563eb;
            cursor: pointer;
        }

        .forgot-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        /* Login Button */
        .btn-login {
            width: 100%;
            padding: 15px;
            /* background: linear-gradient(135deg, #2563eb, #1e40af); */
            background: #8200DC;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 22px rgba(37, 99, 235, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(37, 99, 235, 0.5);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 25px 0 20px;
            color: #94a3b8;
            font-size: 12px;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            margin-top: 20px;
        }

        .login-footer strong {
            color: #1e3a8a;
        }

        /* Demo Credentials */
        .demo-info {
            background: #eff6ff;
            border: 1px dashed #bfdbfe;
            border-radius: 10px;
            padding: 12px 15px;
            margin-top: 20px;
            font-size: 12px;
            color: #1e40af;
            text-align: center;
        }

        .demo-info strong {
            color: #1e3a8a;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-box {
                padding: 35px 25px;
                border-radius: 16px;
            }

            .login-logo h1 {
                font-size: 20px;
            }

            .login-logo .icon-box {
                width: 65px;
                height: 65px;
                font-size: 32px;
            }
        }
    </style>
</head>

<body>

    <div class="login-box">

        <!-- LOGO -->
        <div class="logo-area">

                <?php
            $shopName = getSettingValue($settingsByKey, 'shop_name');
            $shopLogo = getSettingValue($settingsByKey, 'shop_logo');
            ?>
        
            <?php if (!empty($shopLogo)): ?>
                <img src="<?= e($shopLogo) ?>" alt="<?= e($shopName) ?>" class="logo-img">
            <?php else: ?>
                <span class="logo-icon">⚡</span>
            <?php endif; ?>
        
            <h2>
                <?= e($shopName ?: 'Skincare') ?>
            </h2>
        
        
        </div>

        <!-- TITLE -->
        <div class="login-title">
            <h2>🔐 Login Admin page</h2><br>
        </div>

        <!-- ALERTS -->
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <!-- LOGIN FORM -->
        <form method="POST" action="<?= BASE_URL ?>/login" autocomplete="off">

            <!-- Username -->
            <div class="form-group">
                <label>Name</label>
                <div class="input-wrap">
                    <input type="text" name="username" placeholder="បញ្ចូលឈ្មោះអ្នកប្រើ"
                        value="<?= htmlspecialchars($_SESSION['old_username'] ?? '') ?>" required autofocus>
                    <i class="fa-solid fa-user input-icon"></i>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label>Password</label>
                <div class="input-wrap">
                    <input type="password" name="password" id="passwordInput" placeholder="បញ្ចូលលេខសម្ងាត់" required>
                    <i class="fa-solid fa-lock input-icon"></i>
                    <button type="button" class="toggle-password" id="togglePassword">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Remember & Forgot -->
            <!-- <div class="form-options">
                <label class="remember-label">
                    <input type="checkbox" name="remember">
                    <span>ចងចាំខ្ញុំ</span>
                </label>
                <a href="#" class="forgot-link">ភ្លេចលេខសម្ងាត់?</a>
            </div> -->

            <!-- Submit -->
            <button type="submit" class="btn-login">
                <i class="fa-solid fa-right-to-bracket"></i>
                Login
            </button>

        </form>

        <!-- DIVIDER -->
        <div class="divider">ការពារដោយសុវត្ថិភាព</div>

        <!-- FOOTER -->
        <div class="login-footer">
            <strong>© 2026 Beauty Admin</strong> — v1.0.0
        </div>

        <!-- DEMO CREDENTIALS (លុបចេញពេល Production) -->
        <!-- <div class="demo-info">
            <i class="fa-solid fa-circle-info"></i>
            <strong>Demo:</strong> admin / admin123
        </div> -->

    </div>

    <script>
        // ═══════════════════════════════════════════════
        // TOGGLE PASSWORD VISIBILITY
        // ═══════════════════════════════════════════════
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');

        if (toggleBtn && passwordInput) {
            toggleBtn.addEventListener('click', function () {
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;

                const icon = this.querySelector('i');
                icon.className = type === 'password'
                    ? 'fa-solid fa-eye'
                    : 'fa-solid fa-eye-slash';
            });
        }
    </script>

</body>

</html>