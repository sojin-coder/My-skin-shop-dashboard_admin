<?php
// ពិនិត្យមើលថាទិន្នន័យមកពី Controller ត្រឹមត្រូវ
if (!isset($setting) || !is_array($setting)) {
    die('Invalid setting data. Please check your Model find() method.');
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
    <title>Edit Setting · Skincare Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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
            min-height: 100vh;
            color: #333;
            padding: 40px 20px;
        }

        a {
            text-decoration: none;
        }

        .edit-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 620px;
            box-shadow: 0 12px 40px -12px rgba(130, 0, 220, 0.15);
            border: 1px solid #f0f2f9;
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
            margin-bottom: 24px;
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

        .form-group input[type="text"] {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            color: #1e293b;
            background: #f8fafc;
            font-family: inherit;
            transition: all 0.15s;
            outline: none;
        }

        .form-group input[type="text"]:focus {
            border-color: #8200DC;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(130, 0, 220, 0.1);
        }

        .form-group input[readonly] {
            cursor: not-allowed;
            color: #64748b;
            background: #f1f5f9;
        }

        .form-meta {
            font-size: 12px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 10px;
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
            box-shadow: 0 12px 20px -6px rgba(130, 0, 220, 0.5);
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
            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <div class="edit-card">
        <div class="edit-header">
            <h2><i class="fa-solid fa-pen-to-square"></i> Edit Setting</h2>
            <span class="badge-id">ID: #<?= (int) ($setting['id'] ?? 0) ?></span>
        </div>

        <!-- Action ត្រូវតែជា BASE_URL + /setting/update -->
        <form action="<?= BASE_URL ?>/setting/update" method="POST">
            
            <!-- Hidden inputs -->
            <input type="hidden" name="id" value="<?= (int) ($setting['id'] ?? 0) ?>">
            <input type="hidden" name="setting_key" value="<?= e($setting['setting_key'] ?? '') ?>">

            <!-- Setting Key (readonly) -->
            <div class="form-group">
                <label>
                    <i class="fa-solid fa-tag" style="color:#2563eb;"></i>
                    Setting Key
                </label>
                <input type="text" value="<?= e($setting['setting_key'] ?? '') ?>" readonly>
            </div>

            <!-- Setting Value -->
            <div class="form-group">
                <label>
                    <i class="fa-solid fa-pen" style="color:#16a34a;"></i>
                    Setting Value <span style="color:#dc2626;">*</span>
                </label>
                <input 
                    type="text" 
                    name="setting_value" 
                    value="<?= e($setting['setting_value'] ?? '') ?>"
                    placeholder="Enter new value..." 
                    required 
                    autofocus
                >
                <div class="form-meta">
                    <i class="fa-regular fa-clock"></i>
                    <span>Updated: <?= e($setting['updated_at'] ?? 'Not updated yet') ?></span>
                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Save Changes
                </button>
                <a href="<?= BASE_URL ?>/settings" class="btn btn-secondary">
                    <i class="fa-solid fa-xmark"></i> Cancel
                </a>
            </div>

        </form>
    </div>

</body>

</html>