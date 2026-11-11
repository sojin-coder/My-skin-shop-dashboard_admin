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
    <title>Promotions · Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* ខ្ញុំសង្ខេប CSS ដែលចាំបាច់ (អ្នកអាចយក CSS ពី Dashboard ដើមមកដាក់វិញបាន) */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #f4f6fb; display: flex; height: 100vh; overflow: hidden; }
        a { text-decoration: none; }

        /* SIDEBAR */
        .sidebar { width: 300px; background: #8200DC; color: white; display: flex; flex-direction: column; padding: 28px 16px; flex-shrink: 0; }
        .logo-area { display: flex; align-items: center; gap: 12px; padding-bottom: 28px; border-bottom: 2px solid rgba(255,255,255,0.4); margin-bottom: 28px; }
        .nav { flex: 1; display: flex; flex-direction: column; gap: 8px; }
        .nav-item { display: flex; align-items: center; gap: 14px; padding: 12px 16px; border-radius: 16px; color: white; font-weight: 500; }
        .nav-item.active { background: #9b0eff; font-weight: 600; }
        .nav-item:hover:not(.active) { background: rgba(255,255,255,0.15); }

        /* MAIN CONTENT */
        .main-content { flex: 1; display: flex; flex-direction: column; background: #f9faff; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; padding: 24px 36px; background: white; border-bottom: 1px solid #eef1f7; }
        .page-title { font-size: 26px; font-weight: 700; color: #1e1e2f; }
        .user-profile { display: flex; align-items: center; gap: 14px; }
        .avatar { background: linear-gradient(135deg, #6c5ce7, #a29bfe); width: 44px; height: 44px; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; }

        .content-area { flex: 1; padding: 28px 36px; overflow-y: auto; display: flex; flex-direction: column; gap: 24px; }
        
        /* TABLE STYLES */
        .table-container { background: white; border-radius: 20px; padding: 20px; box-shadow: 0 8px 24px -12px rgba(0,0,0,0.1); }
        .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .table-header h2 { color: #8200DC; font-size: 20px; }
        .add-btn { background: #8200DC; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
        
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        th { background: #f9faff; color: #7b8499; padding: 16px; border-bottom: 2px solid #eef1f7; font-weight: 600; text-transform: uppercase; font-size: 12px; }
        td { padding: 16px; border-bottom: 1px solid #f4f6fb; color: #2d3648; vertical-align: middle; }
        
        /* BADGES */
        .badge { padding: 4px 10px; border-radius: 50px; font-size: 12px; font-weight: 600; }
        .badge-active { background: #d1fae5; color: #10b981; }
        .badge-inactive { background: #fee2e2; color: #ef4444; }
        
        .btn-action { padding: 6px 12px; border-radius: 6px; color: white; border: none; cursor: pointer; font-size: 12px; margin-right: 4px; display: inline-flex; align-items: center; gap: 4px; }
        .btn-edit { background: #3b82f6; }
        .btn-delete { background: #ef4444; }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="logo-area">
            <?php $shopName = getSettingValue($settingsByKey, 'shop_name'); ?>
            <h2 style="color:white; font-size:18px;"><?= e($shopName ?: 'Skincare') ?></h2>
        </div>
        <nav class="nav">
            <a href="<?= BASE_URL ?>/" class="nav-item"><i class="fas fa-chart-pie"></i> <span>Main Dashboard</span></a>
            <a href="<?= BASE_URL ?>/products" class="nav-item"><i class="fas fa-box-open"></i> <span>Products</span></a>
            <a href="<?= BASE_URL ?>/orders" class="nav-item"><i class="fas fa-shopping-cart"></i> <span>Orders</span></a>
            <a href="<?= BASE_URL ?>/customers" class="nav-item"><i class="fas fa-users"></i> <span>Customers</span></a>
            <a href="<?= BASE_URL ?>/feedbacks" class="nav-item">
                <i class="fas fa-comments"></i>
                <span>Customer Feedback</span>
            </a>
            <a href="<?= BASE_URL ?>/promotions" class="nav-item active"><i class="fas fa-tags"></i> <span>Promotions</span></a>
            <a href="<?= BASE_URL ?>/categorie" class="nav-item"><i class="fas fa-layer-group"></i> <span>Categories</span></a>
            <a href="<?= BASE_URL ?>/settings" class="nav-item"><i class="fas fa-cog"></i> <span>Settings</span></a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <div class="top-bar">
            <div class="page-title">Main dashboard <span style="font-size:15px; color:#7b8499; font-weight:400;">/ Promotions</span></div>
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
                <div class="table-header">
                    <h2><i class="fas fa-tags"></i> Promotions List</h2>
                    <a href="<?= BASE_URL ?>/promotions/create" class="add-btn"><i class="fas fa-plus"></i> Add Promotion</a>
                </div>

                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Discount</th>
                                <th>Validity</th>
                                <th>Usage Limit</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($promotions)): ?>
                                    <tr>
                                        <td colspan="8" style="text-align: center; padding: 40px; color: #888;">
                                            No promotions found. Click "Add Promotion" to create one.
                                        </td>
                                    </tr>
                            <?php else: ?>
                                    <?php foreach ($promotions as $promo): ?>
                                            <tr>
                                                <td><?= e($promo['id']) ?></td>
                                                <td style="font-weight: 600;"><?= e($promo['name']) ?></td>
                                                <td>
                                                    <span style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-family: monospace; font-size: 13px; border: 1px solid #e2e8f0;">
                                                        <?= e($promo['code']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($promo['discount_type'] === 'percentage'): ?>
                                                            <span style="color: #10b981; font-weight: 600;"><?= e($promo['discount_value']) ?>%</span>
                                                    <?php else: ?>
                                                            <span style="color: #10b981; font-weight: 600;">$<?= number_format($promo['discount_value'], 2) ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div style="font-size: 12px; color: #64748b;">
                                                        <div><i class="fas fa-calendar-alt"></i> Start: <?= date('M d, Y', strtotime($promo['start_date'])) ?></div>
                                                        <div><i class="fas fa-calendar-times"></i> End: <?= date('M d, Y', strtotime($promo['end_date'])) ?></div>
                                                    </div>
                                                </td>
                                                <td><?= e($promo['usage_limit']) == 0 ? 'Unlimited' : e($promo['usage_limit']) . ' times' ?></td>
                                                <td>
                                                    <span class="badge <?= $promo['status'] === 'active' ? 'badge-active' : 'badge-inactive' ?>">
                                                        <?= ucfirst(e($promo['status'])) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="<?= BASE_URL ?>/promotions/edit?id=<?= (int) $promo['id'] ?>" class="btn-action btn-edit">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <form action="<?= BASE_URL ?>/promotions/destroy?id=<?= (int) $promo['id'] ?>" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this promotion?');">
                                                        <button type="submit" class="btn-action btn-delete"><i class="fas fa-trash"></i></button>
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