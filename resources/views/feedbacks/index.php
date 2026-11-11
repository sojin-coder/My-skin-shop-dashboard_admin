<?php
$settingsByKey = $settingsByKey ?? [];
function getSettingValue(array $settings, string $key): string
{
    $val = $settings[$key] ?? '';
    if (is_array($val))
        return (string) ($val['setting_value'] ?? '');
    return (string) $val;
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
    <title>Feedbacks · Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* ========== CSS សង្ខេប (អ្នកអាចយក CSS ពេញពី Dashboard ដើមមកដាក់) ========== */
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

        /* SIDEBAR */
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
            color: white;
            font-weight: 500;
            transition: 0.15s;
        }

        .nav-item.active {
            background: #9b0eff;
            font-weight: 600;
        }

        .nav-item:hover:not(.active) {
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
        }

        .website-item {
            color: #b9c2d0;
        }

        .logout-item {
            color: #f31717;
            background: #eee;
        }

        /* MAIN CONTENT */
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
        }

        .page-title span {
            font-size: 15px;
            color: #7b8499;
            font-weight: 400;
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
        }

        .content-area {
            flex: 1;
            padding: 28px 36px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 24px;
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

        /* TABLE */
        .table-container {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 8px 24px -12px rgba(0, 0, 0, 0.1);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-header h2 {
            color: #8200DC;
            font-size: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        th {
            background: #f9faff;
            color: #7b8499;
            padding: 16px;
            border-bottom: 2px solid #eef1f7;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #f4f6fb;
            color: #2d3648;
            vertical-align: middle;
        }

        /* BADGES & STARS */
        .badge {
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .badge-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .badge-reviewed {
            background: #dbeafe;
            color: #2563eb;
        }

        .badge-resolved {
            background: #d1fae5;
            color: #10b981;
        }

        .stars {
            color: #f59e0b;
            font-size: 12px;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-edit {
            background: #3b82f6;
        }

        .btn-delete {
            background: #ef4444;
        }
    </style>
</head>

<body>
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
            <a href="<?= BASE_URL ?>/" class="nav-item"><i class="fas fa-chart-pie"></i> <span>Main Dashboard</span></a>
            <a href="<?= BASE_URL ?>/products" class="nav-item"><i class="fas fa-box-open"></i>
                <span>Products</span></a>
            <a href="<?= BASE_URL ?>/orders" class="nav-item"><i class="fas fa-shopping-cart"></i>
                <span>Orders</span></a>
            <a href="<?= BASE_URL ?>/customers" class="nav-item"><i class="fas fa-users"></i> <span>Customers</span></a>
            <a href="<?= BASE_URL ?>/feedbacks" class="nav-item active"><i class="fas fa-comment-dots"></i>
                <span>Feedbacks</span></a>
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
            <div class="page-title">Main dashboard <span>/ Feedbacks</span></div>
            <div class="user-profile">
                <div class="avatar">AD</div>
                <div>
                    <div style="font-weight:600; font-size:15px;">Alex Designer</div>
                    <div style="font-size:13px; color:#8b95a9;">Administrator</div>
                </div>
            </div>
        </div>

        <div class="content-area">
            <div class="table-container">
                <!-- <button class="add-btn">
                    <a href="<?= BASE_URL ?>/feedbacks/create">+ Add categorie</a>
                </button> -->
                <div class="table-header">
                    <h2><i class="fas fa-comment-dots"></i> Customer Feedbacks</h2>
                </div>

                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Subject</th>
                                 <th>Product</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($feedbacks)): ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 40px; color: #888;">
                                        No feedbacks found.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($feedbacks as $fb): ?>
                                    <tr>
                                        <td>#
                                            <?= e($fb['id']) ?>
                                        </td>
                                        <td>
                                            <div style="font-weight: 600; color: #1e1e2f;">
                                                <?= e($fb['customer_name'] ?? 'Unknown') ?>
                                            </div>
                                            <div style="font-size: 12px; color: #64748b;">
                                                <?= e($fb['customer_email'] ?? '') ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="font-weight: 500;">
                                                <?= e($fb['subject']) ?>
                                            </div>
                                            <div
                                                style="font-size: 12px; color: #64748b; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                <?= e($fb['message']) ?>
                                            </div>
                                        </td>
                                        
                                        
                                        <td>
                                            <span
                                                style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                                <?= e($fb['product_name'] ?? 'General Feedback') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="stars">
                                                <?php
                                                $rating = (int) $fb['rating'];
                                                for ($i = 1; $i <= 5; $i++) {
                                                    echo $i <= $rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star" style="color:#cbd5e1;"></i>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                            $status = $fb['status'] ?? 'pending';
                                            $badgeClass = 'badge-' . $status;
                                            ?>
                                            <span class="badge <?= $badgeClass ?>">
                                                <?= ucfirst($status) ?>
                                            </span>
                                        </td>
                                        <td style="font-size: 13px;">
                                            <?= date('M d, Y', strtotime($fb['created_at'])) ?>
                                        </td>
                                        <td>

                                            <form action="<?= BASE_URL ?>/feedbacks/destroy?id=<?= (int) $fb['id'] ?>"
                                                method="POST" style="display:inline-block;"
                                                onsubmit="return confirm('Delete this feedback?');">
                                                <button type="submit" class="btn-action btn-delete"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>

</html>