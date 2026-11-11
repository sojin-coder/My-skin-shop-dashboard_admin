<?php

$settingsByKey = $settingsByKey ?? [];

function getSettingValue(array $settings, string $key): string
{
    return (string) ($settings[$key] ?? '');
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

        .logo-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
        }

        .logo-icon {
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

        a {
            display: inline-block;
            color: #3b82f6;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 24px;
            transition: color 0.2s ease;
        }

        a:hover {
            color: #2563eb;
            text-decoration: none;
        }

        form div {
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
            color: #1e293b;
            background-color: #ffffff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        textarea {
            resize: vertical;
            min-height: 90px;
        }

        input[type="file"] {
            padding: 8px;
            background-color: #f8fafc;
            cursor: pointer;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #8200DC;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-top: 8px;
        }

        button[type="submit"]:hover {
            background-color: #a427fd;
        }

        br {
            display: none;
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

        .container {
            width: 100%;
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        h1 {
            margin-bottom: 20px;
            color: #1a252f;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #3b82f6;
            text-decoration: none;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #475569;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .current-image {
            margin-bottom: 10px;
        }

        .current-image img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #8200DC;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
        }

        button:hover {
            background: #950af8;
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
                <a href="<?= BASE_URL ?>/categorie" class="nav-item active">
                    <i class="fas fa-layer-group"></i>
                    <span>Categories</span>
                </a>

                <!-- Settings -->
                <a href="<?= BASE_URL ?>/settings" class="nav-item">
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
                    Categorie <span>/ categorie overview</span>
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
                <div class="container">
                    <h1>Add New Categories</h1>
                    <a href="<?= BASE_URL ?>/categorie">← Back to List</a>

                    <form action="<?= BASE_URL ?>/categorie/store" method="POST" enctype="multipart/form-data">
                        <div>
                            <label>Name:</label>
                            <input type="text" name="name" required>
                        </div>


                        <div>
                            <label>Description:</label>
                            <textarea name="description" rows="4" cols="30"></textarea>
                        </div>

                        <div>
                            <label>status:</label>
                            <input type="text" name="status" required>
                        </div>



                        <button type="submit" class="btn-save">Save</button>
                    </form>
                </div>

                <!-- settings preview -->
                <div class="settings-preview">
                    <span><i class="fas fa-sliders-h"></i> Store settings</span>
                    <div class="right">
                        <span><i class="fas fa-palette"></i> Theme: Light</span>
                        <span><i class="fas fa-language"></i> EN</span>
                        <span><i class="fas fa-globe"></i> Website online</span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>


</html>