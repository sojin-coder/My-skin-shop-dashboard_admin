
<?php

class ProductController extends Controller
{
    private Product $productModel;
    private string $uploadDir;
   

    public function __construct()
    {
        $this->productModel = new Product();
        $this->requireLogin();

        $this->uploadDir = dirname(__DIR__, 2) . '/public/assets/uploads/';

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');

        if ($search !== '') {
            $products = $this->productModel->search($search);
        } else {
            $products = $this->productModel->all();
        }

        // Get total products
        $totalProducts = $this->productModel->getTotalProducts();
        $settingModel = new Setting();
        $setting = $settingModel->all();

        $settingsByKey = [];

        foreach ($setting as $item) {
            $settingsByKey[$item['setting_key']] = $item['setting_value'];
        }


        // Send data to View
        $this->view('product/index', [
            'products' => $products,
            'totalProducts' => $totalProducts,
            'settingsByKey' => $settingsByKey
        ]);
    }
    public function welcome(): void
    {
        $totalProducts = $this->productModel->getTotalProducts();

        $this->view('welcome', [
            'totalProducts' => $totalProducts
        ]);
    }

    public function create(): void
    {
        $settingModel = new Setting();
        $setting = $settingModel->all();

        $settingsByKey = [];

        foreach ($setting as $item) {
            $settingsByKey[$item['setting_key']] = $item['setting_value'];
        }
        $this->view('product/create',[
            'settingsByKey' => $settingsByKey
        ]);
    }
    // create product
    public function store(): void
    {
        $imageName = null;

        if (
            isset($_FILES['image']) &&
            $_FILES['image']['error'] === UPLOAD_ERR_OK
        ) {
            $originalName = $_FILES['image']['name'];
            $tmpName = $_FILES['image']['tmp_name'];
            
            $extension = pathinfo($originalName, PATHINFO_EXTENSION); // .png

           
            $imageName = uniqid() . '.' . $extension;
           
            $imagePath = $this->uploadDir . $imageName;

          
            move_uploaded_file($tmpName, $imagePath);
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'price' => (float) ($_POST['price'] ?? 0),
            'stock' => (int) ($_POST['stock'] ?? 0),
            'image' => $imageName,
        ];

        if ($this->productModel->create($data)) {
            $this->redirect('/');
        } else {
            echo "Failed to create product.";
        }
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

    
    public function edit(): void
        {
            $id = $_GET['id'] ?? null;
        
            if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
                die('Invalid Product ID');
            }
        $settingModel = new Setting();
        $setting = $settingModel->all();

        $settingsByKey = [];

        foreach ($setting as $item) {
            $settingsByKey[$item['setting_key']] = $item['setting_value'];
        }
        
            $product = $this->productModel->find((int) $id);
            if(!$product){
                die("Failed to edit Product");
            }
            else{
                $this->view('product/edit', [
                'product' => $product,
                'settingsByKey' => $settingsByKey
            ]);
            }
        
        }

    public function update(): void
    {
        $id = $_POST['id'] ?? 0;     
    
        if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
            die('Invalid Product ID');
        }
    
        // 1. Get old product
        $product = $this->productModel->find((int) $id);
    
        if (!$product) {
            die('Product not found');
        }
    
        // 2. Keep old image
        $imageName = $product['image'];
    
        // 3. Check if user selected a new image
        if (
            isset($_FILES['image']) &&
            $_FILES['image']['error'] === UPLOAD_ERR_OK
        ) {
            $originalName = $_FILES['image']['name'];
            $tmpName = $_FILES['image']['tmp_name'];
    
            // Get extension
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    
            // Generate new unique filename
            $newImageName = uniqid() . '.' . $extension;
    
            // Full upload path
            $imagePath = $this->uploadDir . $newImageName;
    
            // Move uploaded file
            if (move_uploaded_file($tmpName, $imagePath)) {
    
                // Delete old image
                if (
                    !empty($product['image']) &&
                    file_exists($this->uploadDir . $product['image'])
                ) {
                    unlink($this->uploadDir . $product['image']);
                }
    
                // Use new image
                $imageName = $newImageName;
            }
        }
    
        // 4. Prepare data
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'price' => (float) ($_POST['price'] ?? 0),
            'stock' => (int) ($_POST['stock'] ?? 0),
            'image' => $imageName,
        ];
    
        // 5. Update database
        if ($this->productModel->update((int) $id, $data)) {
            $this->redirect('/');
        } else {
            echo "Failed to update product.";
        }
    }

    // delete product
    public function destroy(): void{
        $id = (int)($_GET["id"] ?? 0);
        if ($id <= 0) {$this->redirect('/'); return;}
        $product = $this->productModel->find($id);
        if ($product && !empty($product['image'])){
            $imagePath = $this->uploadDir . $product['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $this->productModel->delete($id);
        $this->redirect('/'); return;
    }

    

   

    
    



}
