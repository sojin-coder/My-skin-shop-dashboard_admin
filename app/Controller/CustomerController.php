<?php

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->requireLogin();
    }
    public function index()
    {
        $customerModel = new Customer();
        $customers = $customerModel->all(); // ទាញយកទិន្នន័យពី DB

        // ទាញយក settings សម្រាប់ Sidebar
        $settingModel = new Setting();
        $settings = $settingModel->all();
        $settingsByKey = [];
        foreach ($settings as $item) {
            $settingsByKey[$item['setting_key']] = $item;
        }

        $this->view('customer/index', [
            'customers' => $customers,
            'settingsByKey' => $settingsByKey,
        ]);
    }
        // ១. បង្ហាញ Form បន្ថែមអតិថិជន
    public function create()
    {
        // ទាញយក settings សម្រាប់ Sidebar
        $settingModel = new Setting();
        $settings = $settingModel->all();
        $settingsByKey = [];
        foreach ($settings as $item) {
            $settingsByKey[$item['setting_key']] = $item;
        }

        $this->view('customer/create', [
            'settingsByKey' => $settingsByKey
        ]);
    }

    // ២. រក្សាទុកទិន្នន័យពី Form ចូល Database
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/customers');
            exit;
        }

        $data = [
            'name'     => $_POST['name'],
            'email'    => $_POST['email'],
            'phone'    => $_POST['phone'] ?? null,
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT), // Hash លេខសម្ងាត់
            'address'  => $_POST['address'] ?? null,
            'status'   => $_POST['status'] ?? 'active',
        ];

        $customerModel = new Customer();
        $customerModel->create($data); // ត្រូវប្រាកដថា Model មាន Method នេះ

        header('Location: ' . BASE_URL . '/customers');
        exit;
    }
    public function edit()
    {
        // ទាញយក ID ពី URL
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: ' . BASE_URL . '/customers');
            exit;
        }

        // ទាញយកទិន្នន័យអតិថិជនពី Database
        $customerModel = new Customer();
        $customer = $customerModel->find($id);

        if (!$customer) {
            header('Location: ' . BASE_URL . '/customers');
            exit;
        }

        // ទាញយក settings សម្រាប់ Sidebar
        $settingModel = new Setting();
        $settings = $settingModel->all();
        $settingsByKey = [];
        foreach ($settings as $item) {
            $settingsByKey[$item['setting_key']] = $item;
        }

        // បញ្ជូនទៅ View
        $this->view('customer/edit', [
            'customer' => $customer,
            'settingsByKey' => $settingsByKey
        ]);
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/customers');
            exit;
        }

        $id = (int) $_POST['id'];

        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'] ?? null,
            'password' => $_POST['password'] ?? null, // បើទទេ មិនផ្លាស់ប្តូរ
            'address' => $_POST['address'] ?? null,
            'status' => $_POST['status'] ?? 'active',
        ];

        $customerModel = new Customer();
        $customerModel->update($id, $data);

        header('Location: ' . BASE_URL . '/customers');
        exit;
    }
}