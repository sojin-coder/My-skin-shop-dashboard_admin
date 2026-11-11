<?php
class OrderController extends Controller {
    private Order $OrderModel;

    
    public function __construct()
    {
        $this->requireLogin();
        $this->OrderModel = new Order();

    }
    public function index()
    {
        // ១. ទាញយកទិន្នន័យពី Model
        $orderModel = new Order();
        $orders = $orderModel->all(); // ត្រូវប្រាកដថា Model មាន Method all()

        // ២. ទាញយក settings សម្រាប់ Sidebar (បើចាំបាច់)
        $settingModel = new Setting();
        $settings = $settingModel->all();
        $settingsByKey = [];
        foreach ($settings as $item) {
            $settingsByKey[$item['setting_key']] = $item;
        }

        // ៣. ផ្ញើទិន្នន័យទៅ View (ឈ្មោះ 'orders' ត្រូវតែដូចគ្នានឹងក្នុង View)
        $this->view('order/index', [
            'orders' => $orders,
            'settingsByKey' => $settingsByKey
        ]);
    }
    public function create()
    {
        // បង្កើត Object Customer
        $customerModel = new Customer();
        $customers = $customerModel->all(); // <-- ឥឡូវនេះវានឹងដើរ

        // ទាញយក settings
        $settingModel = new Setting();
        $settings = $settingModel->all();
        $settingsByKey = [];
        foreach ($settings as $item) {
            $settingsByKey[$item['setting_key']] = $item;
        }

        $this->view('order/create', [
            'customers' => $customers,
            'settingsByKey' => $settingsByKey,
        ]);
    }
    // create product
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/orders');
            exit;
        }

        $data = [
            'customer_id' => (int) $_POST['customer_id'],
            'order_number' => $_POST['order_number'],
            'total_amount' => $_POST['total_amount'],
            'discount_amount' => $_POST['discount_amount'],
            'final_amount' => $_POST['final_amount'],
            'status' => $_POST['status'],
            'payment_status' => $_POST['payment_status'],
            'shipping_address' => $_POST['shipping_address'],
        ];

        $orderModel = new Order();
        $orderModel->create($data); // ត្រូវប្រាកដថា Model មាន Method នេះ

        header('Location: ' . BASE_URL . '/orders');
        exit;
    }
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '/orders');
            exit;
        }

        $orderModel = new Order();
        $order = $orderModel->find($id);

        if (!$order) {
            header('Location: ' . BASE_URL . '/orders');
            exit;
        }

        $this->view('order/edit', ['order' => $order]);
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/orders');
            exit;
        }

        $id = (int) $_POST['id'];

        // ទាញយកទិន្នន័យពី Form
        $data = [
            'total_amount' => $_POST['total_amount'],
            'discount_amount' => $_POST['discount_amount'],
            'final_amount' => $_POST['final_amount'],
            'status' => $_POST['status'],
            'payment_status' => $_POST['payment_status'],
            'shipping_address' => $_POST['shipping_address'],
        ];

        $orderModel = new Order();
        $orderModel->update($id, $data); // ត្រូវប្រាកដថា Model មាន Method នេះ

        header('Location: ' . BASE_URL . '/orders');
        exit;
    }

}