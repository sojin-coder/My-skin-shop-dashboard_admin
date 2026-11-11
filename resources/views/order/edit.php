<?php
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$settingsByKey = $settingsByKey ?? [];

function getSettingValue(array $settings, string $key): string
{
    $val = $settings[$key] ?? '';
    if (is_array($val)) {
        return (string) ($val['setting_value'] ?? '');
    }
    return (string) $val;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order · Dashboard</title>
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
            background: #d92afc;
            width: 40px;
            height: 40px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
        }

        .logo-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
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
        }

        .nav-item.active {
            background: #9b0eff;
            font-weight: 600;
        }

        .nav-item:not(.active):hover {
            background: rgba(255, 255, 255, 0.15);
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
            cursor: pointer;
        }

        .website-item {
            color: #b9c2d0;
        }

        .logout-item {
            color: #f31717;
            background: #eee;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #f9faff;
            overflow: hidden;
        }

        /* ========== TOP BAR ========== */
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

        /* ========== CONTENT AREA ========== */
        .content-area {
            flex: 1;
            padding: 28px 36px 32px 36px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 28px;
            align-items: center;
        }

        .content-area::-webkit-scrollbar {
            width: 6px;
        }

        .content-area::-webkit-scrollbar-thumb {
            background: #d0d7e5;
            border-radius: 10px;
        }

        /* ========== EDIT CARD ========== */
        .edit-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 680px;
            box-shadow: 0 12px 40px -12px rgba(130, 0, 220, 0.15);
            border: 1px solid #f0f2f9;
            margin-bottom: 20px;
        }

        .edit-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f4f6fb;
        }

        .edit-header h2 {
            font-size: 22px;
            font-weight: 700;
            color: #8200DC;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .badge-id {
            background: #f2f0ff;
            color: #8200DC;
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #3d4a5e;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            color: #1e293b;
            background: #f8fafc;
            font-family: inherit;
            transition: all 0.15s;
            outline: none;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #8200DC;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(130, 0, 220, 0.1);
        }

        .form-group input[readonly] {
            cursor: not-allowed;
            color: #64748b;
            background: #f1f5f9;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px dashed #e2e8f0;
        }

        .btn {
            padding: 14px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
            font-family: inherit;
        }

        .btn-primary {
            background: #8200DC;
            color: white;
            flex: 1;
            box-shadow: 0 8px 16px -6px rgba(130, 0, 220, 0.4);
        }

        .btn-primary:hover {
            background: #6a01b6;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #3d4a5e;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        @media (max-width: 600px) {
            .edit-card {
                padding: 24px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .sidebar {
                width: 220px;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="logo-area">
                <?php $shopName = getSettingValue($settingsByKey, 'shop_name');
                $shopLogo = getSettingValue($settingsByKey, 'shop_logo'); ?>
                <?php if (!empty($shopLogo)): ?>
                    <img src="<?= e($shopLogo) ?>" alt="<?= e($shopName) ?>" class="logo-img">
                <?php else: ?>
                    <span class="logo-icon">⚡</span>
                <?php endif; ?>
                <h2 style="color:white; font-size:18px;">
                    <?= e($shopName ?: 'Skincare') ?>
                </h2>
            </div>

            <nav class="nav">
                <a href="<?= BASE_URL ?>/" class="nav-item"><i class="fas fa-chart-pie"></i> <span>Main
                        Dashboard</span></a>
                <a href="<?= BASE_URL ?>/products" class="nav-item"><i class="fas fa-box-open"></i>
                    <span>Products</span></a>
                <a href="<?= BASE_URL ?>/orders" class="nav-item active"><i class="fas fa-shopping-cart"></i>
                    <span>Orders</span></a>
                <a href="<?= BASE_URL ?>/customers" class="nav-item"><i class="fas fa-users"></i>
                    <span>Customers</span></a>
                    <a href="<?= BASE_URL ?>/feedbacks" class="nav-item">
                        <i class="fas fa-comments"></i>
                        <span>Customer Feedback</span>
                    </a>
                <a href="<?= BASE_URL ?>/promotions" class="nav-item"><i class="fas fa-tags"></i>
                    <span>Promotions</span></a>
                <a href="<?= BASE_URL ?>/categorie" class="nav-item"><i class="fas fa-layer-group"></i>
                    <span>Categories</span></a>
                <a href="<?= BASE_URL ?>/settings" class="nav-item"><i class="fas fa-cog"></i> <span>Settings</span></a>
            </nav>

            <div class="bottom-nav">
                <div class="website-item"><i class="fas fa-globe"></i> <span>View website</span></div>
                <div class="logout-item"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <div class="top-bar">
                <div class="page-title">Main dashboard <span>/ Edit Order</span></div>
                <div class="user-profile">
                    <div class="avatar">AD</div>
                    <div class="user-info">
                        <div class="user-name">Alex Designer</div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
            </div>

            <div class="content-area">
                <div class="edit-card">
                    <a href="<?= BASE_URL ?>/orders">← Back to List</a>
                    <div class="edit-header">
                        <h2><i class="fa-solid fa-pen-to-square"></i> Edit Order</h2>
                        <span class="badge-id">#
                            <?= e($order['order_number'] ?? '') ?>
                        </span>
                    </div>

                    <form action="<?= BASE_URL ?>/orders/update" method="POST">
                        <input type="hidden" name="id" value="<?= (int) ($order['id'] ?? 0) ?>">

                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fa-solid fa-hashtag" style="color:#2563eb;"></i> Order Number</label>
                                <input type="text" value="<?= e($order['order_number'] ?? '') ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label><i class="fa-solid fa-user" style="color:#2563eb;"></i> Customer ID</label>
                                <input type="text" value="<?= e($order['customer_id'] ?? '') ?>" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fa-solid fa-money-bill" style="color:#16a34a;"></i> Total Amount
                                    ($)</label>
                                <input type="number" name="total_amount" step="0.01"
                                    value="<?= e($order['total_amount'] ?? '0.00') ?>" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fa-solid fa-tag" style="color:#dc2626;"></i> Discount Amount
                                    ($)</label>
                                <input type="number" name="discount_amount" step="0.01"
                                    value="<?= e($order['discount_amount'] ?? '0.00') ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label><i class="fa-solid fa-file-invoice-dollar" style="color:#16a34a;"></i> Final Amount
                                ($)</label>
                            <input type="number" name="final_amount" step="0.01"
                                value="<?= e($order['final_amount'] ?? '0.00') ?>" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fa-solid fa-truck-fast" style="color:#f59e0b;"></i> Order
                                    Status</label>
                                <select name="status" required>
                                    <?php
                                    $statuses = ['pending', 'confirmed', 'shipping', 'completed', 'cancelled'];
                                    $currentStatus = $order['status'] ?? 'pending';
                                    foreach ($statuses as $st): ?>
                                        <option value="<?= $st ?>" <?= $currentStatus === $st ? 'selected' : '' ?>>
                                            <?= ucfirst($st) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fa-solid fa-credit-card" style="color:#3b82f6;"></i> Payment
                                    Status</label>
                                <select name="payment_status" required>
                                    <?php
                                    $payStatuses = ['unpaid', 'paid', 'refunded'];
                                    $currentPay = $order['payment_status'] ?? 'unpaid';
                                    foreach ($payStatuses as $ps): ?>
                                        <option value="<?= $ps ?>" <?= $currentPay === $ps ? 'selected' : '' ?>>
                                            <?= ucfirst($ps) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><i class="fa-solid fa-location-dot" style="color:#ef4444;"></i> Shipping
                                Address</label>
                            <textarea name="shipping_address" rows="3"
                                required><?= e($order['shipping_address'] ?? '') ?></textarea>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Save
                                Changes</button>
                            <a href="<?= BASE_URL ?>/orders" class="btn btn-secondary"><i class="fa-solid fa-xmark"></i>
                                Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>