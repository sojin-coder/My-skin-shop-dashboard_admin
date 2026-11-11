<?php
function e($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$settingsByKey = $settingsByKey ?? [];

function getSettingValue(array $settings, string $key): string {
    $val = $settings[$key] ?? '';
    if (is_array($val)) return (string) ($val['setting_value'] ?? '');
    return (string) $val;
}

// ការពារកុំឱ្យ Error បើគ្មានទិន្នន័យ
if (!isset($customer) || !is_array($customer)) {
    die('Invalid customer data.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer · Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* ========== RESET & BASE ========== */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', 'Segoe UI', sans-serif; }
        body { background: #f4f6fb; display: flex; justify-content: center; align-items: center; color: #333; }
        a { text-decoration: none; }

        /* ========== DASHBOARD SHELL ========== */
        .dashboard { display: flex; width: 100%; max-width: 100%; height: 850px; max-height: 100vh; overflow: hidden; }

        /* ========== SIDEBAR ========== */
        .sidebar { width: 300px; background: #8200DC; color: #eaeef2; display: flex; flex-direction: column; padding: 28px 16px; flex-shrink: 0; }
        .logo-area { display: flex; align-items: center; gap: 12px; padding: 0 12px 28px 12px; border-bottom: 2px solid rgba(255, 255, 255, 0.47); margin-bottom: 28px; }
        .logo-icon { background: #d92afc; width: 40px; height: 40px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; color: white; }
        .logo-img { width: 70px; height: 70px; border-radius: 50%; }
        .nav { flex: 1; display: flex; flex-direction: column; gap: 8px; }
        .nav-item { display: flex; align-items: center; gap: 14px; padding: 12px 16px; border-radius: 16px; font-weight: 500; font-size: 15px; color: white; transition: all 0.15s; }
        .nav-item i { font-size: 18px; width: 22px; text-align: center; color: white; }
        .nav-item.active { background: #9b0eff; font-weight: 600; }
        .nav-item:not(.active):hover { background: rgba(255, 255, 255, 0.15); }
        .bottom-nav { margin-top: 28px; padding-top: 20px; border-top: 1px solid rgba(255, 255, 255, 0.08); display: flex; flex-direction: column; gap: 8px; }
        .website-item, .logout-item { display: flex; align-items: center; gap: 14px; padding: 12px 16px; border-radius: 16px; font-weight: 500; font-size: 15px; }
        .website-item { color: #b9c2d0; }
        .logout-item { color: #f31717; background: #eee; }

        /* ========== MAIN CONTENT ========== */
        .main-content { flex: 1; display: flex; flex-direction: column; background: #f9faff; overflow: hidden; }

        /* ========== TOP BAR ========== */
        .top-bar { display: flex; justify-content: space-between; align-items: center; padding: 24px 36px; background: white; border-bottom: 1px solid #eef1f7; }
        .page-title { font-size: 26px; font-weight: 700; color: #1e1e2f; }
        .page-title span { font-weight: 400; font-size: 15px; color: #7b8499; margin-left: 10px; }
        .user-profile { display: flex; align-items: center; gap: 14px; }
        .avatar { background: linear-gradient(135deg, #6c5ce7, #a29bfe); width: 44px; height: 44px; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 18px; }
        .user-info { display: flex; flex-direction: column; }
        .user-name { font-weight: 600; font-size: 15px; color: #1e1e2f; }
        .user-role { font-size: 13px; color: #8b95a9; }

        /* ========== CONTENT AREA ========== */
        .content-area { flex: 1; padding: 28px 36px 32px 36px; overflow-y: auto; display: flex; flex-direction: column; gap: 28px; align-items: center; }
        
        /* ========== EDIT CARD ========== */
        .edit-card { background: white; border-radius: 24px; padding: 40px; width: 100%; max-width: 680px; box-shadow: 0 12px 40px -12px rgba(130, 0, 220, 0.15); border: 1px solid #f0f2f9; margin-bottom: 20px; }
        .edit-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; padding-bottom: 20px; border-bottom: 2px solid #f4f6fb; }
        .edit-header h2 { font-size: 22px; font-weight: 700; color: #8200DC; display: flex; align-items: center; gap: 10px; }
        .badge-id { background: #f2f0ff; color: #8200DC; padding: 6px 14px; border-radius: 100px; font-size: 13px; font-weight: 600; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; color: #3d4a5e; margin-bottom: 8px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 14px; color: #1e293b; background: #f8fafc; font-family: inherit; transition: all 0.15s; outline: none; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #8200DC; background: #fff; box-shadow: 0 0 0 4px rgba(130, 0, 220, 0.1); }
        .form-group textarea { resize: vertical; min-height: 80px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-actions { display: flex; gap: 12px; margin-top: 32px; padding-top: 24px; border-top: 1px dashed #e2e8f0; }
        .btn { padding: 14px 24px; border-radius: 12px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: none; font-family: inherit; }
        .btn-primary { background: #8200DC; color: white; flex: 1; box-shadow: 0 8px 16px -6px rgba(130, 0, 220, 0.4); }
        .btn-primary:hover { background: #6a01b6; transform: translateY(-2px); }
        .btn-secondary { background: #f1f5f9; color: #3d4a5e; }
        .btn-secondary:hover { background: #e2e8f0; }

        @media (max-width: 600px) {
            .edit-card { padding: 24px; }
            .form-row { grid-template-columns: 1fr; }
            .form-actions { flex-direction: column; }
            .sidebar { width: 220px; }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="logo-area">
                <?php $shopName = getSettingValue($settingsByKey, 'shop_name'); $shopLogo = getSettingValue($settingsByKey, 'shop_logo'); ?>
                <?php if (!empty($shopLogo)): ?>
                    <img src="<?= e($shopLogo) ?>" alt="<?= e($shopName) ?>" class="logo-img">
                <?php else: ?>
                    <span class="logo-icon">⚡</span>
                <?php endif; ?>
                <h2 style="color:white; font-size:18px;"><?= e($shopName ?: 'Skincare') ?></h2>
            </div>

            <nav class="nav">
                <a href="<?= BASE_URL ?>/" class="nav-item"><i class="fas fa-chart-pie"></i> <span>Main Dashboard</span></a>
                <a href="<?= BASE_URL ?>/products" class="nav-item"><i class="fas fa-box-open"></i> <span>Products</span></a>
                <a href="<?= BASE_URL ?>/orders" class="nav-item"><i class="fas fa-shopping-cart"></i> <span>Orders</span></a>
                <a href="<?= BASE_URL ?>/customers" class="nav-item active"><i class="fas fa-users"></i> <span>Customers</span></a>
                <a href="<?= BASE_URL ?>/feedbacks" class="nav-item">
                    <i class="fas fa-comments"></i>
                    <span>Customer Feedback</span>
                </a>
                <a href="<?= BASE_URL ?>/promotions" class="nav-item"><i class="fas fa-tags"></i> <span>Promotions</span></a>
                <a href="<?= BASE_URL ?>/categorie" class="nav-item"><i class="fas fa-layer-group"></i> <span>Categories</span></a>
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
                <div class="page-title">Main dashboard <span>/ Edit Customer</span></div>
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
                    <div class="edit-header">
                        <a href="<?= BASE_URL ?>/customers">← Back to List</a>
                        <h2><i class="fa-solid fa-user-pen"></i> Edit Customer</h2>
                        <span class="badge-id">#<?= e($customer['id'] ?? '') ?></span>

                    </div>

                    <!-- ពិនិត្យមើល Action ឱ្យត្រូវនឹង Route របស់អ្នក -->
                    <form action="<?= BASE_URL ?>/customers/update" method="POST">
                        
                        <input type="hidden" name="id" value="<?= (int) ($customer['id'] ?? 0) ?>">

                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fa-solid fa-user" style="color:#2563eb;"></i> Full Name</label>
                                <input type="text" name="name" value="<?= e($customer['name'] ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fa-solid fa-envelope" style="color:#2563eb;"></i> Email Address</label>
                                <input type="email" name="email" value="<?= e($customer['email'] ?? '') ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fa-solid fa-phone" style="color:#f59e0b;"></i> Phone Number</label>
                                <input type="text" name="phone" value="<?= e($customer['phone'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label><i class="fa-solid fa-lock" style="color:#dc2626;"></i> New Password (Leave blank to keep current)</label>
                                <input type="password" name="password" placeholder="••••••••">
                            </div>
                        </div>

                        <div class="form-group">
                            <label><i class="fa-solid fa-location-dot" style="color:#ef4444;"></i> Address</label>
                            <textarea name="address" rows="3"><?= e($customer['address'] ?? '') ?></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fa-solid fa-toggle-on" style="color:#10b981;"></i> Status</label>
                                <select name="status" required>
                                    <option value="active" <?= ($customer['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= ($customer['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fa-solid fa-calendar" style="color:#8b5cf6;"></i> Joined Date</label>
                                <input type="text" value="<?= e(date('M d, Y', strtotime($customer['created_at'] ?? 'now'))) ?>" readonly style="background:#f1f5f9; cursor:not-allowed;">
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-floppy-disk"></i> Save Changes
                            </button>
                            <a href="<?= BASE_URL ?>/customers" class="btn btn-secondary">
                                <i class="fa-solid fa-xmark"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>