<?php

class CategorieController extends Controller
{
    private Categorie $categorieModel;
    private string $uploadDir;
  
        
     public function __construct(){
        $this->requireLogin();
    
        $this->categorieModel = new Categorie();

        $this->uploadDir = dirname(__DIR__, 2) . '/public/assets/uploads/';

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    // Display all categories
    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');

        if ($search !== '') {
            $categories = $this->categorieModel->search($search);
        } else {
            $categories = $this->categorieModel->all();
        }

        $totalCategories = $this->categorieModel->getTotalCategories();

        $settingModel = new Setting();
        $setting = $settingModel->all();

        $settingsByKey = [];

        foreach ($setting as $item) {
            $settingsByKey[$item['setting_key']] = $item['setting_value'];
        }

        $this->view('categories/index', [
            'categories' => $categories,
            'totalCategories' => $totalCategories,
            'settingsByKey' => $settingsByKey
        ]);
    }

    // Show create form
    public function create(): void
    {
        $settingModel = new Setting();
        $setting = $settingModel->all();

        $settingsByKey = [];

        foreach ($setting as $item) {
            $settingsByKey[$item['setting_key']] = $item['setting_value'];
        }
        $this->view('categories/create',[
            'settingsByKey' => $settingsByKey
        ]);
    }

   
    public function store(): void
    {
      
          
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'status' => trim($_POST['status'] ?? ''),
        ];

        if ($this->categorieModel->create($data)) {
            $this->redirect('/categorie');
        } else {
            echo "Failed to create category.";
        }
    }

    // Show category detail
    public function show(): void
    {
        $id = $_GET['id'] ?? null;

        if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
            die('Invalid Category ID');
        }

        $category = $this->categorieModel->find((int) $id);

        if (!$category) {
            die('Category not found');
        }

        $this->view('categorie/show', [
            'category' => $category
        ]);
    }

    // Show edit form

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '/categories');
            exit;
        }

        $categorieModel = new Categorie();
        $category = $categorieModel->find((int) $id);

        if (!$category) {
            header('Location: ' . BASE_URL . '/categories');
            exit;
        }

        // ទាញយក settings សម្រាប់ Sidebar
        $settingModel = new Setting();
        $settings = $settingModel->all();
        $settingsByKey = [];
        foreach ($settings as $item) {
            $settingsByKey[$item['setting_key']] = $item;
        }

        $this->view('categories/edit', [
            'category' => $category,
            'settingsByKey' => $settingsByKey
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/categories');
            exit;
        }

        $id = (int) $_POST['id'];

        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'image' => $_POST['image'] ?? '',
            'status' => $_POST['status'],
        ];

        $categorieModel = new Categorie();
        $categorieModel->update($id, $data);

        header('Location: ' . BASE_URL . '/categories');
        exit;
    }

    // Delete category
    public function destroy(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            $this->redirect('/categorie');
            return;
        }

        $category = $this->categorieModel->find($id);

        if (!$category) {
            $this->redirect('/categorie');
            return;
        }

        // Delete image
        if (!empty($category['image'])) {
            $imagePath = $this->uploadDir . $category['image'];

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $this->categorieModel->delete($id);

        $this->redirect('/categorie');
    }
}
