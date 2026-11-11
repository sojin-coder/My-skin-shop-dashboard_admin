<?php
$settingsByKey = $settingsByKey ?? [];
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
function getSettingValue(array $settings, string $key): string
{
    $val = $settings[$key] ?? '';
    if (is_array($val))
        return (string) ($val['setting_value'] ?? '');
    return (string) $val;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Promotion · Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* (អ្នកអាចចម្លង CSS ពីទំព័រ Create Customer មកដាក់ទីនេះបាន ព្រោះវាដូចគ្នា) */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f4f6fb;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        a {
            text-decoration: none;
        }

        .sidebar {
            width: 300px;
            background: #8200DC;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 28px 16px;
            flex-shrink: 0;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 28px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.4);
            margin-bottom: 28px;
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
            color: white;
            font-weight: 500;
        }

        .nav-item.active {
            background: #9b0eff;
            font-weight: 600;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #f9faff;
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
        }

        .content-area {
            flex: 1;
            padding: 28px 36px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .edit-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 680px;
            box-shadow: 0 12px 40px -12px rgba(130, 0, 220, 0.15);
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
        .form-group select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            background: #f8fafc;
            outline: none;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #8200DC;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(130, 0, 220, 0.1);
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
        }

        .btn-primary {
            background: #8200DC;
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            background: #6a01b6;
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #3d4a5e;
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="logo-area">
            <?php $shopName = getSettingValue($settingsByKey, 'shop_name'); ?>
            <h2 style="color:white; font-size:18px;">
                <?= e($shopName ?: 'Skincare') ?>
            </h2>
        </div>
        <nav class="nav">
            <a href="<?= BASE_URL ?>/" class="nav-item"><i class="fas fa-chart-pie"></i> <span>Main Dashboard</span></a>
            <a href="<?= BASE_URL ?>/products" class="nav-item"><i class="fas fa-box-open"></i>
                <span>Products</span></a>
            <a href="<?= BASE_URL ?>/orders" class="nav-item"><i class="fas fa-shopping-cart"></i>
                <span>Orders</span></a>
            <a href="<?= BASE_URL ?>/customers" class="nav-item"><i class="fas fa-users"></i> <span>Customers</span></a>
            <a href="<?= BASE_URL ?>/feedbacks" class="nav-item">
                <i class="fas fa-comments"></i>
                <span>Customer Feedback</span>
            </a>
            <a href="<?= BASE_URL ?>/promotions" class="nav-item active"><i class="fas fa-tags"></i>
                <span>Promotions</span></a>
            <a href="<?= BASE_URL ?>/categorie" class="nav-item"><i class="fas fa-layer-group"></i>
                <span>Categories</span></a>
            <a href="<?= BASE_URL ?>/settings" class="nav-item"><i class="fas fa-cog"></i> <span>Settings</span></a>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="page-title">Main dashboard <span style="font-size:15px; color:#7b8499; font-weight:400;">/ Add
                    Promotion</span></div>
            <div class="user-profile">
                <div class="avatar">AD</div>
            </div>
        </div>

        <div class="content-area">
            <div class="edit-card">
                <div class="edit-header">
                    <h2><i class="fa-solid fa-tags"></i> Create Promotion</h2>
                </div>
                <a href="<?= BASE_URL ?>/promotions">← Back to List</a>

                <form action="<?= BASE_URL ?>/promotions/store" method="POST">

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fa-solid fa-tag" style="color:#2563eb;"></i> Promotion Name</label>
                            <input type="text" name="name" required placeholder="e.g. Summer Sale">
                        </div>
                        <div class="form-group">
                            <label><i class="fa-solid fa-barcode" style="color:#2563eb;"></i> Coupon Code</label>
                            <input type="text" name="code" required placeholder="e.g. SUMMER2023"
                                style="text-transform: uppercase;">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fa-solid fa-percent" style="color:#10b981;"></i> Discount Type</label>
                            <select name="discount_type" required>
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed Amount ($)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><i class="fa-solid fa-money-bill-wave" style="color:#10b981;"></i> Discount
                                Value</label>
                            <input type="number" name="discount_value" step="0.01" required
                                placeholder="e.g. 10 or 5.00">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fa-solid fa-calendar-plus" style="color:#f59e0b;"></i> Start Date</label>
                            <input type="datetime-local" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fa-solid fa-calendar-minus" style="color:#ef4444;"></i> End Date</label>
                            <input type="datetime-local" name="end_date" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fa-solid fa-users" style="color:#8b5cf6;"></i> Usage Limit (0 =
                                Unlimited)</label>
                            <input type="number" name="usage_limit" value="0" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fa-solid fa-toggle-on" style="color:#10b981;"></i> Status</label>
                            <select name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Save
                            Promotion</button>
                        <a href="<?= BASE_URL ?>/promotions" class="btn btn-secondary"><i class="fa-solid fa-xmark"></i>
                            Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>