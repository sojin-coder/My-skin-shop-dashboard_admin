<?php

class AuthController extends Controller
{
    // ═══════════════════════════════════════════════
    // LOGIN
    // ═══════════════════════════════════════════════
    public function showLogin()
    {
        if (!empty($_SESSION['admin_id'])) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        $this->view('auth/login', ['title' => 'Login']);
    }
    public function index()
    {
        $settingModel = new Setting();
        $settings = $settingModel->all();
        $settingsByKey = [];
        foreach ($settings as $item) {
            $settingsByKey[$item['setting_key']] = $item;
        }
        $this->view('auth/login', [
            'settingsByKey' => $settingsByKey
        ]);
    }

    public function login()
    {
        $settingModel = new Setting();
        $settings = $settingModel->all();
        $settingsByKey = [];
        foreach ($settings as $item) {
            $settingsByKey[$item['setting_key']] = $item;
        }
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        if ($username === '' || $password === '') {
            $_SESSION['error'] = 'សូមបញ្ចូលឈ្មោះអ្នកប្រើ និងលេខសម្ងាត់!';
            $_SESSION['old_username'] = $username;
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        
        $db = Database::connection();
        $stmt = $db->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['username'];
            $_SESSION['admin_email'] = $admin['email'] ?? '';

            if ($remember) {
                setcookie('admin_remember', $admin['id'], time() + (86400 * 30), '/');
            }

            $_SESSION['success'] = 'welcome, ' . $admin['username'] . '!';
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        $_SESSION['error'] = 'Usename and Password incorret!';
        $_SESSION['old_username'] = $username;
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    // ═══════════════════════════════════════════════
    // ⭐ SIGN UP — ថ្មី
    // ═══════════════════════════════════════════════
    public function showRegister()
    {
        if (!empty($_SESSION['admin_id'])) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        $this->view('auth/register', ['title' => 'Sign Up']);
    }

    public function register()
    {
        // ទាញទិន្នន័យពី Form
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        // ═══════════════════════════════════════════
        // VALIDATION
        // ═══════════════════════════════════════════

        $errors = [];

        // Username
        if ($username === '') {
            $errors[] = 'សូមបញ្ចូលឈ្មោះអ្នកប្រើ!';
        } elseif (strlen($username) < 3) {
            $errors[] = 'ឈ្មោះអ្នកប្រើត្រូវមានយ៉ាងហោច 3 តួអក្សរ!';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $errors[] = 'ឈ្មោះអ្នកប្រើអាចមានតែ a-z, 0-9 និង _ ប៉ុណ្ណោះ!';
        }

        // Email
        if ($email === '') {
            $errors[] = 'សូមបញ្ចូលអ៊ីមែល!';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'អ៊ីមែលមិនត្រឹមត្រូវ!';
        }

        // Password
        if ($password === '') {
            $errors[] = 'សូមបញ្ចូលលេខសម្ងាត់!';
        } elseif (strlen($password) < 6) {
            $errors[] = 'លេខសម្ងាត់ត្រូវមានយ៉ាងហោច 6 តួអក្សរ!';
        }

        // Confirm Password
        if ($password !== $confirm) {
            $errors[] = 'លេខសម្ងាត់ទាំងពីរមិនដូចគ្នា!';
        }

        // Check ឈ្មោះស្ទួន
        if (empty($errors)) {
            $db = Database::connection();
            $stmt = $db->prepare("SELECT id FROM admins WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            $exists = $stmt->fetch();

            if ($exists) {
                $errors[] = 'ឈ្មោះអ្នកប្រើ ឬអ៊ីមែលនេះមានរួចហើយ!';
            }
        }

        // បើមាន error → Redirect ត្រឡប់ទៅ Form
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = [
                'username' => $username,
                'email' => $email,
            ];
            header('Location: ' . BASE_URL . '/register');
            exit;
        }

        // ═══════════════════════════════════════════
        // INSERT ទៅ Database
        // ═══════════════════════════════════════════
        try {
                        $db = Database::connection();
                        $stmt = $db->prepare("
                INSERT INTO admins (username, email, password)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([
                $username,
                $email,
                password_hash($password, PASSWORD_DEFAULT)
            ]);

            $_SESSION['success'] = 'បង្កើតគណនីបានជោគជ័យ! សូម Login ។';
            header('Location: ' . BASE_URL . '/login');
            exit;

        } catch (Exception $e) {
            $_SESSION['errors'] = ['មានបញ្ហាក្នុងការបង្កើតគណនី: ' . $e->getMessage()];
            header('Location: ' . BASE_URL . '/register');
            exit;
        }
    }

    // ═══════════════════════════════════════════════
    // LOGOUT
    // ═══════════════════════════════════════════════
    public function logout()
    {
        // ទាញឈ្មោះ admin មុន destroy
        $adminName = $_SESSION['admin_name'] ?? 'Admin';

        // លុប Session
        session_unset();
        session_destroy();

        // លុប Remember Cookie
        if (isset($_COOKIE['admin_remember'])) {
            setcookie('admin_remember', '', time() - 3600, '/');
        }

        // Redirect ទៅ Logout Page
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    // ⭐ បង្ហាញ Logout Page
    public function showLogout()
    {
        $this->view('auth/logout', [
            'title' => 'Logged Out'
        ]);
    }
}