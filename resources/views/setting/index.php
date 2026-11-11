<?php
$settingsByKey = $settingsByKey ?? []; // ប្រើតម្លៃដែល Controller ផ្ញើមក

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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Dashboard · Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* ========== RESET & BASE ========== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        body {
            background: #f4f6fb;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        a {
            text-decoration: none;
        }

        /* ========== DASHBOARD SHELL ========== */
        .dashboard {
            display: flex;
            width: 100%;
            max-width: 100%;
            height: 850px;
            max-height: 100vh;
            overflow: hidden;
            transition: all 0.2s;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            width: 300px;
            background: #8200DC;
            color: #eaeef2;
            display: flex;
            flex-direction: column;
            padding: 28px 16px;
            flex-shrink: 0;
            transition: all 0.2s;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 12px 28px 12px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.47);
            margin-bottom: 28px;
        }

        .logo-icon {
            /* background: #ee0278; */
            background: #d92afc;
            width: 40px;
            height: 40px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
            box-shadow: 0 8px 16px -4px rgba(218, 217, 228, 0.4);
        }

        .logo-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
        }

        .logo-text {
            font-weight: 700;
            font-size: 20px;
            letter-spacing: -0.3px;
            color: white;
        }

        .logo-text span {
            color: #fd6eb6;
        }

        .nav {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            border-radius: 16px;
            font-weight: 500;
            font-size: 15px;
            /* color: #b9c2d0; */
            color: white;
            transition: all 0.15s;
            cursor: pointer;
        }

        .nav-item i {
            font-size: 18px;
            width: 22px;
            text-align: center;
            color: white;
            transition: all 0.15s;
        }

        .nav-item.active {
            background: #9b0eff;
            color: white;
            font-weight: 600;
        }

        .nav-item.active i {
            color: white;
        }

        .nav-item:not(.active):hover {
            background: rgba(255, 255, 255, 0.15);
            color: #e0e5ec;
        }

        .bottom-nav {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .website-item,
        .logout-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            border-radius: 16px;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.15s;
            cursor: pointer;
        }

        .website-item {
            color: #b9c2d0;
        }

        .website-item i {
            font-size: 18px;
            width: 22px;
            text-align: center;
            color: #8b95a9;
        }

        .website-item:hover {
            background: rgba(255, 255, 255, 0.03);
            color: #e0e5ec;
        }

        .logout-item {
            color: #f31717;
            background: #eee;

        }

        .logout-item i {
            font-size: 18px;
            width: 22px;
            text-align: center;
            color: #fd1d1d;
        }

        .logout-item:hover {
            background: rgba(255, 107, 107, 0.1);
            color: #fd3636;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #f9faff;
            overflow: hidden;
        }

        /* SETTINGS GRID */
        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 22px;
        }

        /* SETTING CARD */
        .setting-card {
            background: #fff;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(30, 58, 138, 0.08);
            border-left: 5px solid #2563eb;
            transition: all 0.25s ease;
        }

        .setting-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(30, 58, 138, 0.15);
        }

        .setting-card .setting-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #dbeafe;
            color: #1e40af;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 16px;
        }

        .setting-card .setting-label {
            display: block;
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 6px;
        }

        .setting-card .setting-key {
            font-size: 11px;
            color: #94a3b8;
            font-family: 'Courier New', monospace;
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 14px;
        }

        .setting-card .setting-field {
            margin-bottom: 16px;
        }

        .setting-card .setting-field input {
            width: 100%;
            padding: 11px 14px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            color: #1e293b;
            background: #f8fafc;
            font-family: inherit;
        }

        .setting-card .setting-field input[readonly] {
            cursor: not-allowed;
            color: #64748b;
        }

        .setting-card .setting-meta {
            font-size: 12px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 16px;
            padding-top: 12px;
            border-top: 1px dashed #e2e8f0;
        }

        .setting-card .btn-save {
            width: 100%;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            background: #dbeafe;
            color: #1e40af;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-family: inherit;
            text-decoration: none;
        }

        .setting-card .btn-save:hover {
            background: #2563eb;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 36px;
            background: white;
            border-bottom: 1px solid #eef1f7;
        }

        .page-title {
            font-size: 26px;
            font-weight: 700;
            color: #1e1e2f;
            letter-spacing: -0.4px;
        }

        .page-title span {
            font-weight: 400;
            font-size: 15px;
            color: #7b8499;
            margin-left: 10px;
            letter-spacing: 0;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .avatar {
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
            box-shadow: 0 6px 12px -4px rgba(108, 92, 231, 0.3);
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 15px;
            color: #1e1e2f;
        }

        .user-role {
            font-size: 13px;
            color: #8b95a9;
        }

        .content-area {
            flex: 1;
            padding: 28px 36px 32px 36px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        .content-area::-webkit-scrollbar {
            width: 6px;
        }

        .content-area::-webkit-scrollbar-track {
            background: transparent;
        }

        .content-area::-webkit-scrollbar-thumb {
            background: #d0d7e5;
            border-radius: 10px;
        }

        /* ========== STATS ========== */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 24px;
            padding: 22px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 8px 20px -8px rgba(0, 0, 0, 0.06);
            border: 1px solid #f0f2f9;
        }

        .stat-left h3 {
            font-size: 14px;
            font-weight: 500;
            color: #7b8499;
            letter-spacing: 0.3px;
            margin-bottom: 8px;
        }

        .stat-number {
            font-size: 34px;
            font-weight: 700;
            color: #1e1e2f;
            line-height: 1.2;
            letter-spacing: -0.5px;
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            background: #f2f0ff;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8200DC;
            font-size: 26px;
        }

        /* ========== CATEGORY PILLS ========== */
        .category-strip {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            align-items: center;
        }

        .cat-pill {
            background: white;
            border: 1px solid #eef1f7;
            padding: 8px 20px;
            border-radius: 100px;
            font-size: 14px;
            font-weight: 500;
            color: #3d4a5e;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            transition: all 0.1s;
            cursor: pointer;
        }

        .cat-pill i {
            font-size: 12px;
            color: #6c5ce7;
        }

        .cat-pill.active {
            background: #6c5ce7;
            border-color: #6c5ce7;
            color: white;
        }

        .cat-pill.active i {
            color: white;
        }

        /* ========== TABLE CONTAINER ========== */
        .table-container {
            background: white;
            border-radius: 28px;
            padding: 8px;
            box-shadow: 0 8px 24px -12px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f2f9;
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            padding: 20px 24px 16px 24px;
        }

        .table-header h2 {
            font-size: 18px;
            font-weight: 600;
            /* color: #1e1e2f; */
            color: #8200DC;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-header h2 i {
            color: #8200DC;
            font-size: 18px;
        }

        .add-btn {
            /* background: #6c5ce7; */
            background: #8200DC;
            border: none;
            color: white;
            padding: 10px 22px;
            border-radius: 40px;
            font-weight: 500;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 8px 16px -6px rgba(108, 92, 231, 0.4);
            cursor: pointer;
            transition: all 0.15s;
        }

        .add-btn a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .add-btn:hover {
            background: #6a01b6;
            box-shadow: 0 10px 20px -6px rgba(108, 92, 231, 0.5);
        }

        .search_input {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f4f6fb;
            border: 1px solid #eef1f7;
            border-radius: 40px;
            padding: 4px 4px 4px 18px;
        }

        .search_input input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 14px;
            color: #3d4a5e;
            min-width: 220px;
            padding: 8px 0;
        }

        .search_input input::placeholder {
            color: #a0a8b9;
        }

        .search_input button {
            background: #8200DC;
            color: white;
            border: none;
            border-radius: 40px;
            padding: 8px 20px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s;
        }

        .search_input button:hover {
            background: #7401c7;
        }

        /* ========== MODERN PRODUCT TABLE ========== */

        /* បន្ថែម Table Responsive សម្រាប់ Scrollbar */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* កែសម្រួល Scrollbar ឱ្យស្អាត */
        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f9faff;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .table-container table {
            width: 100%;
            min-width: 900px;
            /* កំណត់ទំហំអប្បបរមា ដើម្បីកុំឱ្យវាបង្រួម */
            border-collapse: separate;
            border-spacing: 0;
            font-size: 14px;
            margin-top: 10px;
        }

        .table-container thead th {
            background: #f9faff;
            color: #7b8499;
            text-align: left;
            padding: 16px 20px;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #eef1f7;
            border-top: 1px solid #eef1f7;
            white-space: nowrap;
            /* កុំឱ្យអក្សរធ្លាក់បន្ទាត់ */
        }

        .table-container tbody td {
            padding: 16px 20px;
            border-bottom: 1px solid #f4f6fb;
            color: #2d3648;
            font-weight: 500;
            vertical-align: middle;
        }

        .table-container tbody tr:last-child td {
            border-bottom: none;
        }

        .table-container tbody tr:hover {
            background: #fafbff;
        }

        .table-container img {
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #eef1f7;
            display: block;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        }

        /* កំណត់ទំហំជួរឈរ (Column Widths) */
        .table-container th:nth-child(1) {
            width: 60px;
        }

        /* ID */
        .table-container th:nth-child(2) {
            width: 100px;
        }

        /* Image */
        .table-container th:nth-child(3) {
            width: 180px;
        }

        /* Name */
        .table-container th:nth-child(4) {
            width: 250px;
        }

        /* Description */
        .table-container th:nth-child(5) {
            width: 100px;
        }

        /* Price */
        .table-container th:nth-child(6) {
            width: 80px;
        }

        /* Stock */
        .table-container th:nth-child(7) {
            width: 220px;
        }

        /* Action */

        .table-container td:nth-child(4) {
            color: #64748b;
            font-weight: 400;
            line-height: 1.5;
        }

        /* Action Buttons */
        .btn-edit,
        .btn-view {
            display: inline-block;
            padding: 8px 16px;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            transition: opacity 0.15s;
            border: none;
            cursor: pointer;
            text-align: center;
        }

        .btn-edit {
            background: #3b82f6;
        }

        .btn-edit:hover {
            background: #2563eb;
        }

        .btn-view {
            background: #10b981;
        }

        .btn-view:hover {
            background: #0d9b6c;
        }

        .table-container td form {
            display: inline-block;
            margin-left: 6px;
        }

        .table-container td form button {
            padding: 8px 16px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s;
        }

        .table-container td form button:hover {
            background: #dc2626;
        }

        /* ========== SETTINGS PREVIEW ========== */
        .settings-preview {
            display: flex;
            justify-content: space-between;
            background: white;
            border-radius: 20px;
            padding: 18px 28px;
            border: 1px solid #f0f2f9;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 8px;
        }

        .settings-preview span {
            font-weight: 500;
            color: #3d4a5e;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .settings-preview span i {
            color: #6c5ce7;
        }

        .settings-preview .right {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }

        .settings-preview .right span {
            font-weight: 400;
            color: #7b8499;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1100px) {
            .sidebar {
                width: 220px;
            }

            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 850px) {
            .dashboard {
                flex-direction: column;
                height: auto;
                max-height: none;
            }

            .sidebar {
                width: 100%;
                flex-direction: row;
                flex-wrap: wrap;
                padding: 16px;
                gap: 10px;
                align-items: center;
            }

            .logo-area {
                padding: 0 8px 0 0;
                margin-bottom: 0;
                border-bottom: none;
            }

            .nav {
                flex-direction: row;
                flex-wrap: wrap;
                flex: 1;
            }

            .nav-item {
                padding: 8px 14px;
            }

            .bottom-nav {
                flex-direction: row;
                margin-top: 0;
                padding-top: 0;
                border-top: none;
                margin-left: auto;
            }

            .website-item,
            .logout-item {
                padding: 8px 14px;
            }

            .content-area {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard">
        <!-- SIDEBAR -->
        <aside class="sidebar">
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


            <nav class="nav">
                <!-- Main Dashboard -->
                <a href="<?= BASE_URL ?>/" class="nav-item ">
                    <i class="fas fa-chart-pie"></i>
                    <span>Main Dashboard</span>
                </a>

                <!-- Products -->
                <a href="<?= BASE_URL ?>/products" class="nav-item">
                    <i class="fas fa-box-open"></i>
                    <span>Products</span>
                </a>

                <!-- Orders -->
                <a href="<?= BASE_URL ?>/orders" class="nav-item">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>

                <!-- Customers -->
                <a href="<?= BASE_URL ?>/customers" class="nav-item">
                    <i class="fas fa-users"></i>
                    <span>Customers</span>
                </a>
                <a href="<?= BASE_URL ?>/feedbacks" class="nav-item">
                    <i class="fas fa-comments"></i>
                    <span>Customer Feedback</span>
                </a>

                <!-- Promotions -->
                <a href="<?= BASE_URL ?>/promotions" class="nav-item">
                    <i class="fas fa-tags"></i>
                    <span>Promotions</span>
                </a>

                <!-- Categories -->
                <a href="<?= BASE_URL ?>/categorie" class="nav-item">
                    <i class="fas fa-layer-group"></i>
                    <span>Categories</span>
                </a>

                <!-- Settings -->
                <a href="<?= BASE_URL ?>/settings" class="nav-item active">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </nav>


            <div class="bottom-nav">
                <div class="website-item">
                    <i class="fas fa-globe"></i>
                    <span>View website</span>
                </div>
                <div class="logout-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <!-- top bar -->
            <div class="top-bar">
                <div class="page-title">
                    Main dashboard <span>/ Setting overview</span>
                </div>
                <div class="user-profile">
                    <div class="avatar">AD</div>
                    <div class="user-info">
                        <div class="user-name">Alex Designer</div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
            </div>

            <!-- content -->
            <div class="content-area">
                <div class="settings-grid">

                    <!-- 1. shop_name -->
                    <?php $row = $settingsByKey['shop_name'] ?? null; ?>
                    <div class="setting-card blue">
                        <div class="setting-icon"><i class="fa-solid fa-store"></i></div>
                        <span class="setting-label">Shop Name</span>
                        <span class="setting-key">shop_name</span>
                        <div class="setting-field">
                            <input type="text" value="<?= e(getSettingValue($settingsByKey, 'shop_name')) ?>" readonly>
                        </div>
                        <div class="setting-meta">
                            <i class="fa-regular fa-clock"></i>
                            <span>Updated:
                                <?= e($row['updated_at'] ?? 'Not updated yet') ?>
                            </span>
                        </div>
                        <?php if ($row): ?>
                            <a href="/skicare_dashboard/setting/edit?id=<?= (int) $row['id'] ?>" class="btn-save">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- 2. telegram_link -->
                    <?php $row = $settingsByKey['telegram_link'] ?? null; ?>
                    <div class="setting-card cyan">
                        <div class="setting-icon"><i class="fa-brands fa-telegram"></i></div>
                        <span class="setting-label">Telegram Link</span>
                        <span class="setting-key">telegram_link</span>
                        <div class="setting-field">
                            <input type="text" value="<?= e(getSettingValue($settingsByKey, 'telegram_link')) ?>"
                                readonly>
                        </div>
                        <div class="setting-meta">
                            <i class="fa-regular fa-clock"></i>
                            <span>Updated:
                                <?= e($row['updated_at'] ?? 'Not updated yet') ?>
                            </span>
                        </div>
                        <?php if ($row): ?>
                            <a href="/skicare_dashboard/setting/edit?id=<?= (int) $row['id'] ?>" class="btn-save">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- 3. contact_email -->
                    <?php $row = $settingsByKey['contact_email'] ?? null; ?>
                    <div class="setting-card orange">
                        <div class="setting-icon"><i class="fa-solid fa-envelope"></i></div>
                        <span class="setting-label">Contact Email</span>
                        <span class="setting-key">contact_email</span>
                        <div class="setting-field">
                            <input type="text" value="<?= e(getSettingValue($settingsByKey, 'contact_email')) ?>"
                                readonly>
                        </div>
                        <div class="setting-meta">
                            <i class="fa-regular fa-clock"></i>
                            <span>Updated:
                                <?= e($row['updated_at'] ?? 'Not updated yet') ?>
                            </span>
                        </div>
                        <?php if ($row): ?>
                            <a href="/skicare_dashboard/setting/edit?id=<?= (int) $row['id'] ?>" class="btn-save">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- 4. shop_logo -->
                    <?php $row = $settingsByKey['shop_logo'] ?? null; ?>
                    <div class="setting-card purple">
                        <div class="setting-icon"><i class="fa-solid fa-image"></i></div>
                        <span class="setting-label">Shop Logo URL</span>
                        <span class="setting-key">shop_logo</span>
                        <div class="setting-field">
                            <input type="text" value="<?= e(getSettingValue($settingsByKey, 'shop_logo')) ?>" readonly>
                        </div>
                        <div class="setting-meta">
                            <i class="fa-regular fa-clock"></i>
                            <span>Updated:
                                <?= e($row['updated_at'] ?? 'Not updated yet') ?>
                            </span>
                        </div>
                        <?php if ($row): ?>
                            <a href="/skicare_dashboard/setting/edit?id=<?= (int) $row['id'] ?>" class="btn-save">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- 5. currency -->
                    <?php $row = $settingsByKey['currency'] ?? null; ?>
                    <div class="setting-card green">
                        <div class="setting-icon"><i class="fa-solid fa-dollar-sign"></i></div>
                        <span class="setting-label">Currency</span>
                        <span class="setting-key">currency</span>
                        <div class="setting-field">
                            <input type="text" value="<?= e(getSettingValue($settingsByKey, 'currency')) ?>" readonly>
                        </div>
                        <div class="setting-meta">
                            <i class="fa-regular fa-clock"></i>
                            <span>Updated:
                                <?= e($row['updated_at'] ?? 'Not updated yet') ?>
                            </span>
                        </div>
                        <?php if ($row): ?>
                            <a href="/skicare_dashboard/setting/edit?id=<?= (int) $row['id'] ?>" class="btn-save">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- 6. show_featured_products -->
                    <?php
                    $row = $settingsByKey['show_featured_products'] ?? null;
                    $featured = getSettingValue($settingsByKey, 'show_featured_products');
                    ?>
                    <div class="setting-card yellow">
                        <div class="setting-icon"><i class="fa-solid fa-star"></i></div>
                        <span class="setting-label">Show Featured Products</span>
                        <span class="setting-key">show_featured_products</span>
                        <div class="setting-field">
                            <input type="text" value="<?= $featured === '1' ? 'Enabled (1)' : 'Disabled (0)' ?>"
                                readonly>
                        </div>
                        <div class="setting-meta">
                            <i class="fa-regular fa-clock"></i>
                            <span>Updated:
                                <?= e($row['updated_at'] ?? 'Not updated yet') ?>
                            </span>
                        </div>
                        <?php if ($row): ?>
                            <a href="/skicare_dashboard/setting/edit?id=<?= (int) $row['id'] ?>" class="btn-save">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- 7. show_new_arrivals -->
                    <?php
                    $row = $settingsByKey['show_new_arrivals'] ?? null;
                    $newArrivals = getSettingValue($settingsByKey, 'show_new_arrivals');
                    ?>
                    <div class="setting-card pink">
                        <div class="setting-icon"><i class="fa-solid fa-clock"></i></div>
                        <span class="setting-label">Show New Arrivals</span>
                        <span class="setting-key">show_new_arrivals</span>
                        <div class="setting-field">
                            <input type="text" value="<?= $newArrivals === '1' ? 'Enabled (1)' : 'Disabled (0)' ?>"
                                readonly>
                        </div>
                        <div class="setting-meta">
                            <i class="fa-regular fa-clock"></i>
                            <span>Updated:
                                <?= e($row['updated_at'] ?? 'Not updated yet') ?>
                            </span>
                        </div>
                        <?php if ($row): ?>
                            <a href="/skicare_dashboard/setting/edit?id=<?= (int) $row['id'] ?>" class="btn-save">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </main>
    </div>
</body>

</html>