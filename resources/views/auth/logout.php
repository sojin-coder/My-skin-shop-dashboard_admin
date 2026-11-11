<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out — Electro Admin</title>
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

        /* Decorative Circles */
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

        /* Logout Box */
        .logout-box {
            background: #fff;
            padding: 50px 45px 40px;
            border-radius: 20px;
            max-width: 440px;
            width: 100%;
            text-align: center;
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

        /* Success Icon */
        .logout-icon {
            width: 95px;
            height: 95px;
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 45px;
            margin: 0 auto 25px;
            color: #16a34a;
            animation: pulse 2s infinite;
            box-shadow: 0 10px 30px rgba(22, 163, 74, 0.25);
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }
        }

        /* Title */
        .logout-box h1 {
            color: #1e3a8a;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        /* Message */
        .logout-box p {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 25px;
            line-height: 1.7;
        }

        .logout-box p strong {
            color: #1e3a8a;
            font-weight: 700;
        }

        /* Countdown */
        .countdown {
            background: #eff6ff;
            border: 2px dashed #bfdbfe;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 25px;
            color: #1e40af;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .countdown span {
            color: #dc2626;
            font-size: 20px;
            font-weight: 700;
            min-width: 24px;
            display: inline-block;
        }

        /* Buttons */
        .btn-group {
            display: flex;
            gap: 12px;
        }

        .btn {
            flex: 1;
            padding: 14px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: #fff;
            box-shadow: 0 8px 22px rgba(37, 99, 235, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(37, 99, 235, 0.5);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 2px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            transform: translateY(-3px);
        }

        /* Footer */
        .logout-footer {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #94a3b8;
            font-size: 12px;
        }

        .logout-footer strong {
            color: #1e3a8a;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .logout-box {
                padding: 40px 25px 30px;
                border-radius: 16px;
            }

            .logout-icon {
                width: 80px;
                height: 80px;
                font-size: 38px;
            }

            .logout-box h1 {
                font-size: 20px;
            }

            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <div class="logout-box">

        <!-- SUCCESS ICON -->
        <div class="logout-icon">
            <i class="fa-solid fa-circle-check"></i>
        </div>

        <!-- TITLE -->
        <h1>ចាកចេញបានជោគជ័យ!</h1>

        <!-- MESSAGE -->
        <p>
            អ្នកបានចាកចេញពីគណនីដោយសុវត្ថិភាព។<br>
            សូមអរគុណដែលបានប្រើប្រាស់ <strong>Electro Admin</strong>។
        </p>

        <!-- COUNTDOWN -->
        <div class="countdown">
            <i class="fa-solid fa-clock"></i>
            កំពុងបញ្ជូនទៅ Login ក្នុង <span id="timer">5</span> វិនាទី...
        </div>

        <!-- BUTTONS -->
        <div class="btn-group">
            <a href="<?= BASE_URL ?>/login" class="btn btn-primary">
                <i class="fa-solid fa-right-to-bracket"></i> Login ឥឡូវ
            </a>
            <a href="<?= BASE_URL ?>/" class="btn btn-secondary">
                <i class="fa-solid fa-house"></i> Home
            </a>
        </div>

        <!-- FOOTER -->
        <div class="logout-footer">
            © 2026 <strong>ElectroAdmin</strong> — v1.0.0
        </div>

    </div>

    <script>
        // ═══════════════════════════════════════════════
        // COUNTDOWN AUTO-REDIRECT
        // ═══════════════════════════════════════════════
        let seconds = 5;
        const timerEl = document.getElementById('timer');

        const interval = setInterval(() => {
            seconds--;
            timerEl.textContent = seconds;

            if (seconds <= 0) {
                clearInterval(interval);
                window.location.href = '<?= BASE_URL ?>/login';
            }
        }, 1000);

        // ═══════════════════════════════════════════════
        // CLEAR BROWSER HISTORY (ការពារ Back button)
        // ═══════════════════════════════════════════════
        window.history.pushState(null, '', window.location.href);
        window.onpopstate = function () {
            window.history.pushState(null, '', window.location.href);
        };
    </script>

</body>

</html>