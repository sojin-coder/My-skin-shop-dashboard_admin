<?php
class PromotionController extends Controller
{
    public function __construct()
    {
        $this->requireLogin();
    }
    public function index()
    {
        $promoModel = new Promotion();
        $promotions = $promoModel->all();

        // ទាញយក settings សម្រាប់ Sidebar
        $settingModel = new Setting();
        $settings = $settingModel->all();
        $settingsByKey = [];
        foreach ($settings as $item) {
            $settingsByKey[$item['setting_key']] = $item;
        }

        $this->view('promotion/index', [
            'promotions' => $promotions,
            'settingsByKey' => $settingsByKey
        ]);
    }

    public function create()
    {
        $settingModel = new Setting();
        $settings = $settingModel->all();
        $settingsByKey = [];
        foreach ($settings as $item) {
            $settingsByKey[$item['setting_key']] = $item;
        }

        $this->view('promotion/create', [
            'settingsByKey' => $settingsByKey
        ]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/promotions');
            exit;
        }

        $data = [
            'name' => $_POST['name'],
            'code' => $_POST['code'],
            'discount_type' => $_POST['discount_type'],
            'discount_value' => $_POST['discount_value'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'usage_limit' => $_POST['usage_limit'],
            'status' => $_POST['status'],
        ];

        $promoModel = new Promotion();
        $promoModel->create($data);

        header('Location: ' . BASE_URL . '/promotions');
        exit;
    }
    // ១. បង្ហាញ Form កែសម្រួល
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '/promotions');
            exit;
        }

        $promoModel = new Promotion();
        $promotion = $promoModel->find($id);

        if (!$promotion) {
            header('Location: ' . BASE_URL . '/promotions');
            exit;
        }

        // ទាញយក settings សម្រាប់ Sidebar
        $settingModel = new Setting();
        $settings = $settingModel->all();
        $settingsByKey = [];
        foreach ($settings as $item) {
            $settingsByKey[$item['setting_key']] = $item;
        }

        $this->view('promotion/edit', [
            'promotion' => $promotion,
            'settingsByKey' => $settingsByKey
        ]);
    }

    // ២. រក្សាទុកការកែសម្រួល
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/promotions');
            exit;
        }

        $id = (int) $_POST['id'];

        $data = [
            'name' => $_POST['name'],
            'code' => $_POST['code'],
            'discount_type' => $_POST['discount_type'],
            'discount_value' => $_POST['discount_value'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'usage_limit' => $_POST['usage_limit'],
            'status' => $_POST['status'],
        ];

        $promoModel = new Promotion();
        $promoModel->update($id, $data);

        header('Location: ' . BASE_URL . '/promotions');
        exit;
    }

    // ៣. លុបទិន្នន័យ
    public function destroy()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $promoModel = new Promotion();
            $promoModel->delete($id);
        }

        header('Location: ' . BASE_URL . '/promotions');
        exit;
    }
}