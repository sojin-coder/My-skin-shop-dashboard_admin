<?php
$settingsByKey = $settingsByKey ?? [];
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
    <title>Sign Up — Beauty Admin</title>
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
            /* ផ្លាស់ប្តូរពណ៌ Background ទៅជា #8200DC */
            background: #8200DC;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Decorative Circles */
        body::before,
        body::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
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

        /* Register Box */
        .register-box {
            background: #fff;
            width: 100%;
            max-width: 480px;
            padding: 40px 40px 30px;
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

        /* Logo Area */
        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 24px 10px;
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 24px;
        }

        .logo-icon {
            background: #8200DC;
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            box-shadow: 0 8px 16px -4px rgba(130, 0, 220, 0.4);
            flex-shrink: 0;
        }

        .logo-img {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #8200DC;
        }

        .logo-area h2 {
            color: #1e293b;
            font-size: 20px;
            font-weight: 700;
            margin: 0;
        }

        /* Title */
        .register-title {
            text-align: center;
            margin-bottom: 22px;
        }

        .register-title h2 {
            color: #8200DC;
            font-size: 18px;
            font-weight: 600;
        }

        /* Alert Boxes */
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            animation: shake 0.4s;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        .alert-error ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #16a34a;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 18px;
            position: relative;
        }

        .form-group label {
            display: block;
            color: #3d4a5e;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 7px;
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
            font-size: 15px;
            pointer-events: none;
            transition: color 0.2s;
        }

        .form-group input {
            width: 100%;
            padding: 13px 45px 13px 44px;
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
            border-color: #8200DC;
            /* ពណ៌ Focus ទៅជាពណ៌ស្វាយ */
            background: #fff;
            box-shadow: 0 0 0 4px rgba(130, 0, 220, 0.12);
        }

        .form-group input:focus+.input-icon {
            color: #8200DC;
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
            font-size: 15px;
            cursor: pointer;
            padding: 4px;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: #8200DC;
        }

        /* Password Strength Meter */
        .password-strength {
            margin-top: 8px;
            display: none;
        }

        .password-strength.show {
            display: block;
        }

        .strength-bar {
            height: 5px;
            background: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 5px;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .strength-text {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
        }

        /* Submit Button */
        .btn-register {
            width: 100%;
            padding: 14px;
            /* ផ្លាស់ប្តូរពណ៌ប៊ូតុងទៅជា #8200DC */
            background: #8200DC;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 22px rgba(130, 0, 220, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-register:hover {
            background: #6a01b6;
            /* ពណ៌កាន់តែចាស់បន្តិចពេល Hover */
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(130, 0, 220, 0.5);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0 18px;
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
        .register-footer {
            text-align: center;
            color: #94a3b8;
            font-size: 11px;
            margin-top: 15px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .register-box {
                padding: 30px 22px 25px;
                border-radius: 16px;
            }
        }
    </style>
</head>

<body>

    <div class="register-box">

        <!-- LOGO -->
        <div class="logo-area">
            <?php
            $shopName = getSettingValue($settingsByKey, 'shop_name');
            $shopLogo = getSettingValue($settingsByKey, 'shop_logo');
            ?>

            <?php if (!empty($shopLogo)): ?>
                <!-- ប្រសិនបើអ្នកទុករូបភាពក្នុង Folder uploads សូមប្រើ BASE_URL . '/uploads/' . $shopLogo -->
                <img src="<?= BASE_URL ?>/uploads/<?= e($shopLogo) ?>" alt="<?= e($shopName) ?>" class="logo-img">
            <?php else: ?>
                <span class="logo-icon">⚡</span>
            <?php endif; ?>

            <h2><?= e($shopName ?: 'Skincare') ?></h2>
        </div>

        <!-- TITLE -->
        <div class="register-title">
            <h2><i class="fa-solid fa-user-plus"></i> Create Account</h2>
        </div>

        <!-- ERRORS -->
        <?php if (!empty($_SESSION['errors'])): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <ul>
                    <?php foreach ($_SESSION['errors'] as $err): ?>
                        <li>• <?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <!-- SUCCESS -->
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <!-- REGISTER FORM -->
        <form method="POST" action="<?= BASE_URL ?>/register" autocomplete="off">

            <!-- Username -->
            <div class="form-group">
                <label>Name <span style="color:#dc2626">*</span></label>
                <div class="input-wrap">
                    <input type="text" name="username" placeholder="ឧ. admin"
                        value="<?= htmlspecialchars($_SESSION['old']['username'] ?? '') ?>" required minlength="3"
                        autofocus>
                    <i class="fa-solid fa-user input-icon"></i>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label>Email <span style="color:#dc2626">*</span></label>
                <div class="input-wrap">
                    <input type="email" name="email" placeholder="admin@beauty.com"
                        value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>" required>
                    <i class="fa-solid fa-envelope input-icon"></i>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label>Password <span style="color:#dc2626">*</span></label>
                <div class="input-wrap">
                    <input type="password" name="password" id="passwordInput" placeholder="យ៉ាងហោច 6 តួអក្សរ" required
                        minlength="6">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <button type="button" class="toggle-password" data-target="passwordInput">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>

                <!-- Strength Meter -->
                <div class="password-strength" id="strengthMeter">
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                    <span class="strength-text" id="strengthText"></span>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label>Confirm Password <span style="color:#dc2626">*</span></label>
                <div class="input-wrap">
                    <input type="password" name="confirm_password" id="confirmInput" placeholder="Enter Password"
                        required minlength="6">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <button type="button" class="toggle-password" data-target="confirmInput">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-register">
                <i class="fa-solid fa-user-plus"></i>
                Register
            </button>

        </form>

        <!-- DIVIDER -->
        <div class="divider">ឬ</div>

        <!-- FOOTER -->
        <div class="register-footer">
            © 2026 Beauty Admin — v1.0.0
        </div>

    </div>

    <script>
        // TOGGLE PASSWORD VISIBILITY
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', function () {
                const targetId = this.dataset.target;
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'fa-solid fa-eye-slash';
                } else {
                    input.type = 'password';
                    icon.className = 'fa-solid fa-eye';
                }
            });
        });

        // PASSWORD STRENGTH METER
        const passwordInput = document.getElementById('passwordInput');
        const strengthMeter = document.getElementById('strengthMeter');
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');

        if (passwordInput) {
            passwordInput.addEventListener('input', function () {
                const val = this.value;

                if (val.length === 0) {
                    strengthMeter.classList.remove('show');
                    return;
                }

                strengthMeter.classList.add('show');

                let strength = 0;
                if (val.length >= 6) strength++;
                if (val.length >= 10) strength++;
                if (/[a-z]/.test(val)) strength++;
                if (/[A-Z]/.test(val)) strength++;
                if (/[0-9]/.test(val)) strength++;
                if (/[^a-zA-Z0-9]/.test(val)) strength++;

                let percent = 0;
                let color = '';
                let label = '';

                if (strength <= 2) {
                    percent = 33;
                    color = '#dc2626';
                    label = '🔴 ខ្សោយ';
                } else if (strength <= 4) {
                    percent = 66;
                    color = '#f59e0b';
                    label = '🟡 មធ្យម';
                } else {
                    percent = 100;
                    color = '#16a34a';
                    label = '🟢 ខ្លាំង';
                }

                strengthFill.style.width = percent + '%';
                strengthFill.style.background = color;
                strengthText.textContent = label;
                strengthText.style.color = color;
            });
        }

        // CONFIRM PASSWORD MATCH
        const confirmInput = document.getElementById('confirmInput');

        if (confirmInput && passwordInput) {
            confirmInput.addEventListener('input', function () {
                if (this.value === '') {
                    this.style.borderColor = '#e2e8f0';
                    return;
                }
                if (this.value === passwordInput.value) {
                    this.style.borderColor = '#16a34a';
                } else {
                    this.style.borderColor = '#dc2626';
                }
            });
        }
    </script>

</body>

</html>