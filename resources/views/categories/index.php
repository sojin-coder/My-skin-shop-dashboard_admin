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
            min-height: 100vh;
        }

        a {
            text-decoration: none;
        }

        /* ========== DASHBOARD SHELL ========== */
        .dashboard {
            display: flex;
            width: 100%;
            max-width: 100%;
            height: 100vh;
            max-height: 100vh;
            overflow: hidden;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            width: 300px;
            background: #8200DC;
            color: #eaeef2;
            display: flex;
            flex-direction: column;
            padding: 24px 14px;
            flex-shrink: 0;
            transition: width 0.2s ease;
        }

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

        .nav {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 6px;
            overflow-y: auto;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 14px;
            font-weight: 500;
            font-size: 14.5px;
            color: rgba(255, 255, 255, 0.85);
            transition: all 0.15s ease;
            cursor: pointer;
            white-space: nowrap;
        }

        .nav-item i {
            font-size: 17px;
            width: 22px;
            text-align: center;
            color: rgba(255, 255, 255, 0.85);
            transition: all 0.15s ease;
            flex-shrink: 0;
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
            color: white;
        }

        .nav-item:not(.active):hover i {
            color: white;
        }

        .bottom-nav {
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .website-item,
        .logout-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 14px;
            font-weight: 500;
            font-size: 14.5px;
            transition: all 0.15s ease;
            cursor: pointer;
            white-space: nowrap;
        }

        .website-item {
            color: rgba(255, 255, 255, 0.75);
        }

        .website-item i {
            font-size: 17px;
            width: 22px;
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            flex-shrink: 0;
        }

        .website-item:hover {
            background: rgba(255, 255, 255, 0.12);
            color: white;
        }

        .website-item:hover i {
            color: white;
        }

        .logout-item {
            color: #fd3636;
            background: rgba(255, 255, 255, 0.95);
            margin-top: 4px;
        }

        .logout-item i {
            font-size: 17px;
            width: 22px;
            text-align: center;
            color: #fd1d1d;
            flex-shrink: 0;
        }

        .logout-item:hover {
            background: #ffe5e5;
            color: #d10000;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #f9faff;
            overflow: hidden;
            min-width: 0;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 32px;
            background: white;
            border-bottom: 1px solid #eef1f7;
            flex-shrink: 0;
            gap: 16px;
        }

        .page-title {
            font-size: 22px;
            font-weight: 700;
            color: #1e1e2f;
            letter-spacing: -0.4px;
            line-height: 1.3;
        }

        .page-title span {
            font-weight: 400;
            font-size: 14px;
            color: #7b8499;
            margin-left: 8px;
            letter-spacing: 0;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .avatar {
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
            width: 42px;
            height: 42px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 6px 12px -4px rgba(108, 92, 231, 0.3);
            flex-shrink: 0;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .user-name {
            font-weight: 600;
            font-size: 14.5px;
            color: #1e1e2f;
            white-space: nowrap;
        }

        .user-role {
            font-size: 12.5px;
            color: #8b95a9;
            white-space: nowrap;
        }

        .content-area {
            flex: 1;
            padding: 24px 32px 28px 32px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 24px;
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

        .content-area::-webkit-scrollbar-thumb:hover {
            background: #b0bacd;
        }

        /* ========== TABLE CONTAINER ========== */
        .table-container {
            background: white;
            border-radius: 24px;
            padding: 6px;
            box-shadow: 0 8px 24px -12px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f2f9;
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-height: 0;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
            padding: 18px 20px 14px 20px;
            flex-shrink: 0;
        }

        .table-header h2 {
            font-size: 17px;
            font-weight: 600;
            color: #8200DC;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .table-header h2 i {
            color: #8200DC;
            font-size: 17px;
        }

        .table-header form {
            flex: 1;
            display: flex;
            justify-content: flex-end;
            min-width: 200px;
        }

        .add-btn {
            background: #8200DC;
            border: none;
            color: white;
            padding: 9px 20px;
            border-radius: 40px;
            font-weight: 500;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 8px 16px -6px rgba(108, 92, 231, 0.4);
            cursor: pointer;
            transition: all 0.15s ease;
            white-space: nowrap;
            flex-shrink: 0;
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
            transform: translateY(-1px);
        }

        .search_input {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #f4f6fb;
            border: 1px solid #eef1f7;
            border-radius: 40px;
            padding: 4px 4px 4px 16px;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            width: 100%;
            max-width: 340px;
        }

        .search_input:focus-within {
            border-color: #c9b3ff;
            box-shadow: 0 0 0 3px rgba(130, 0, 220, 0.08);
        }

        .search_input input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 13.5px;
            color: #3d4a5e;
            flex: 1;
            min-width: 0;
            padding: 7px 0;
        }

        .search_input input::placeholder {
            color: #a0a8b9;
        }

        .search_input button {
            background: #8200DC;
            color: white;
            border: none;
            border-radius: 40px;
            padding: 7px 18px;
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .search_input button:hover {
            background: #7401c7;
        }

        /* ========== TABLE RESPONSIVE ========== */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            flex: 1;
            min-height: 0;
        }

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
            min-width: 820px;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 13.5px;
        }

        .table-container thead th {
            background: #f9faff;
            color: #7b8499;
            text-align: left;
            padding: 14px 18px;
            font-weight: 600;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #eef1f7;
            border-top: 1px solid #eef1f7;
            white-space: nowrap;
        }

        .table-container tbody td {
            padding: 14px 18px;
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

        /* Column widths */
        .table-container th:nth-child(1) {
            width: 60px;
        }

        .table-container th:nth-child(2) {
            width: 160px;
        }

        .table-container th:nth-child(3) {
            width: 260px;
        }

        .table-container th:nth-child(4) {
            width: 100px;
        }

        .table-container th:nth-child(5) {
            width: 240px;
        }

        .table-container td:nth-child(3) {
            color: #64748b;
            font-weight: 400;
            line-height: 1.5;
        }

        /* Action Buttons */
        .table-container td:nth-child(5) {
            white-space: nowrap;
        }

        .btn-edit,
        .btn-view {
            display: inline-block;
            padding: 7px 14px;
            color: white;
            text-decoration: none;
            border-radius: 9px;
            font-size: 12.5px;
            font-weight: 500;
            transition: background 0.15s ease, transform 0.15s ease;
            border: none;
            cursor: pointer;
            text-align: center;
        }

        .btn-edit {
            background: #3b82f6;
        }

        .btn-edit:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        .btn-view {
            background: #10b981;
            margin-left: 4px;
        }

        .btn-view:hover {
            background: #0d9b6c;
            transform: translateY(-1px);
        }

        .table-container td form {
            display: inline-block;
            margin-left: 4px;
        }

        .table-container td form button {
            padding: 7px 14px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 9px;
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s ease, transform 0.15s ease;
        }

        .table-container td form button:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        /* ========== SETTINGS PREVIEW ========== */
        .settings-preview {
            display: flex;
            justify-content: space-between;
            background: white;
            border-radius: 18px;
            padding: 16px 24px;
            border: 1px solid #f0f2f9;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            flex-shrink: 0;
        }

        .settings-preview>span {
            font-weight: 500;
            color: #3d4a5e;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .settings-preview>span i {
            color: #6c5ce7;
        }

        .settings-preview .right {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .settings-preview .right span {
            font-weight: 400;
            color: #7b8499;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .settings-preview .right span i {
            color: #a0a8b9;
            font-size: 12px;
        }

        /* ========== EMPTY STATE ========== */
        .table-container tbody td[colspan] {
            text-align: center;
            padding: 48px 20px !important;
            color: #a0a8b9 !important;
            font-weight: 400 !important;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1200px) {
            .sidebar {
                width: 230px;
            }

            .content-area {
                padding: 20px 24px 24px 24px;
            }

            .top-bar {
                padding: 18px 24px;
            }
        }

        @media (max-width: 950px) {
            .sidebar {
                width: 200px;
                padding: 20px 10px;
            }

            .logo-text {
                font-size: 16px;
            }

            .nav-item,
            .website-item,
            .logout-item {
                font-size: 13.5px;
                padding: 10px 12px;
                gap: 10px;
            }

            .table-header {
                flex-direction: column;
                align-items: stretch;
            }

            .table-header form {
                justify-content: stretch;
            }

            .search_input {
                max-width: 100%;
            }

            .add-btn {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            body {
                align-items: flex-start;
            }

            .dashboard {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
            }

            .sidebar {
                width: 100%;
                flex-direction: row;
                flex-wrap: wrap;
                padding: 14px 16px;
                gap: 8px;
                align-items: center;
                border-radius: 0 0 20px 20px;
            }

            .logo-area {
                padding: 0;
                margin-bottom: 0;
                border-bottom: none;
                flex-shrink: 0;
            }

            .logo-icon {
                width: 34px;
                height: 34px;
                font-size: 16px;
                border-radius: 10px;
            }

            .logo-text {
                font-size: 15px;
            }

            .nav {
                flex-direction: row;
                flex-wrap: wrap;
                flex: 1;
                gap: 4px;
                overflow: visible;
            }

            .nav-item {
                padding: 7px 12px;
                border-radius: 10px;
                font-size: 13px;
                gap: 8px;
            }

            .nav-item i {
                font-size: 14px;
                width: 16px;
            }

            .bottom-nav {
                flex-direction: row;
                margin-top: 0;
                padding-top: 0;
                border-top: none;
                gap: 4px;
                width: 100%;
                margin-left: 0;
            }

            .website-item,
            .logout-item {
                padding: 7px 12px;
                border-radius: 10px;
                font-size: 13px;
                gap: 8px;
            }

            .website-item i,
            .logout-item i {
                font-size: 14px;
                width: 16px;
            }

            .main-content {
                overflow: visible;
            }

            .top-bar {
                padding: 16px 20px;
                flex-wrap: wrap;
            }

            .page-title {
                font-size: 19px;
            }

            .page-title span {
                font-size: 12.5px;
                display: block;
                margin-left: 0;
                margin-top: 2px;
            }

            .content-area {
                padding: 16px;
                overflow: visible;
            }

            .table-container {
                border-radius: 18px;
                flex: none;
            }

            .table-header {
                padding: 16px 16px 12px 16px;
                gap: 10px;
            }

            .table-header h2 {
                font-size: 15.5px;
            }

            .settings-preview {
                flex-direction: column;
                align-items: flex-start;
                padding: 14px 18px;
                gap: 10px;
            }

            .settings-preview .right {
                gap: 12px;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                padding: 12px;
            }

            .logo-text {
                display: none;
            }

            .nav-item span,
            .website-item span,
            .logout-item span {
                display: none;
            }

            .nav-item,
            .website-item,
            .logout-item {
                padding: 9px 11px;
                gap: 0;
                justify-content: center;
            }

            .nav-item i,
            .website-item i,
            .logout-item i {
                font-size: 16px;
                width: auto;
            }

            .top-bar {
                padding: 14px 16px;
            }

            .user-info {
                display: none;
            }

            .content-area {
                padding: 12px;
            }

            .table-header h2 {
                font-size: 14px;
            }

            .add-btn {
                padding: 8px 16px;
                font-size: 12.5px;
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
                <a href="<?= BASE_URL ?>/auth/logout" class="logout-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
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
                <!-- product table -->
                <div class="table-container">
                    <div class="table-header">
                        <h2><i class="fas fa-boxes"></i> categorie list</h2>

                        <form action="<?= BASE_URL ?>/" method="GET">
                            <div class="search_input">
                                <input type="text" name="search" placeholder="Search what you want ..."
                                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                                <button type="submit">Search</button>
                            </div>
                        </form>
                        <button class="add-btn">
                            <a href="<?= BASE_URL ?>/categorie/create">+ Add categorie</a>
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (empty($categories)): ?>
                                    <tr>
                                        <td colspan="7" style="text-align: center; padding: 40px; color: #888;">
                                            Categorie not found
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($categories as $category): ?>
                                        <tr>
                                            <td>
                                                <?= htmlspecialchars($category['id']) ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($category['name']) ?>
                                            </td>
                                            <td>
                                                <?= htmlspecialchars($category['description'] ?? '') ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($category['status']) ?>
                                            </td>
                                            <td>
                                                <a href="<?= BASE_URL ?>/categorie/edit?id=<?= $category['id'] ?>"
                                                    class="btn-edit">
                                                    Edit
                                                </a>
                                                
                                                <form action="<?= BASE_URL ?>/categorie/destroy?id=<?= $category['id'] ?>"
                                                    method="POST">
                                                    <button type="submit">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- settings preview -->
                <div class="settings-preview">
                    <span><i class="fas fa-sliders-h"></i> Store settings</span>
                    <div class="right">
                        <span> Date:11/03/2026</span>
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