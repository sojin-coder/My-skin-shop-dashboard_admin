<?php

class SettingController extends Controller
{
    public function __construct()
    {
        $this->requireLogin();
    }
    public function index()
    {
        $settingModel = new Setting();
        $setting = $settingModel->all();

        
        $settingsByKey = [];
        foreach ($setting as $item) {
            $settingsByKey[$item['setting_key']] = $item; // ដាក់ $item ទាំងមូល
        }

        $productModel = new Product();
        $products = $productModel->all();

        $this->view('setting/index', [
            'settingsByKey' => $settingsByKey,
            'products' => $products
        ]);
    }
    public function edit()
    {
        // ១. ពិនិត្យមើលថាតើមាន id ផ្ញើមកឬអត់
        $id = $_GET['id'] ?? null;

        if (!$id) {
            // ប្រសិនបើគ្មាន id ទេ ត្រឡប់ទៅទំព័រ setting វិញ
            header('Location: ' . BASE_URL . '/settings');
            exit;
        }

        // ២. ទាញទិន្នន័យ Setting តាម id
        $settingModel = new Setting();
        $setting = $settingModel->find($id); // *សូមមើលចំណាំខាងក្រោម

        if (!$setting) {
            // ប្រសិនបើរកមិនឃើញទិន្នន័យ
            header('Location: ' . BASE_URL . '/settings');
            exit;
        }

        // ៣. ផ្ញើទិន្នន័យទៅ View សម្រាប់បង្ហាញ Form
        $this->view('setting/edit', [
            'setting' => $setting
        ]);
    }

    // ========== Method សម្រាប់ Save ការកែប្រែ (បន្ថែមពេលក្រោយ) ==========
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/settings');
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);
        $value = $_POST['setting_value'] ?? '';

        if ($id > 0) {
            $settingModel = new Setting();
            $settingModel->updateValue($id, $value);
        }

        header('Location: ' . BASE_URL . '/settings');
        exit;
    }
}