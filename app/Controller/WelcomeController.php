<?php

class WelcomeController extends Controller
{
    private Product $productModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->productModel = new Product();
    }

    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');

        if ($search !== '') {
            $products = $this->productModel->search($search);
        } else {
            $products = $this->productModel->all();
        }

        $totalProducts = $this->productModel->getTotalProducts();
        $settingModel = new Setting();
        $setting = $settingModel->all();

        $settingsByKey = [];

        foreach ($setting as $item) {
            $settingsByKey[$item['setting_key']] = $item['setting_value'];
        }

        $this->view('welcome', [
            'products' => $products,
            'totalProducts' => $totalProducts,
            'settingsByKey' => $settingsByKey
        ]);
    }

    public function about(): void
    {
        $this->view('about');
    }

    public function welcome(): void
    {
        $this->index();
    }

    public function show(): void
    {
        $id = $_GET['id'] ?? null;

        if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
            die('Invalid Product ID');
        }

        $product = $this->productModel->find((int) $id);

        if (!$product) {
            die('Product not found');
        }

        $this->view('product/show', [
            'product' => $product
        ]);
    }
}