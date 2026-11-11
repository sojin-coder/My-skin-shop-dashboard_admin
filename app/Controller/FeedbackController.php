<?php

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->requireLogin();
    }
    // ១. បង្ហាញបញ្ជី Feedback
    public function index()
    {
        $feedbackModel = new Feedback();
        $feedbacks = $feedbackModel->allWithCustomer();

        // ទាញយក settings សម្រាប់ Sidebar
        $settingModel = new Setting();
        $settings = $settingModel->all();
        $settingsByKey = [];
        foreach ($settings as $item) {
            $settingsByKey[$item['setting_key']] = $item;
        }

        $this->view('feedbacks/index', [
            'feedbacks' => $feedbacks,
            'settingsByKey' => $settingsByKey
        ]);
    }

    // ២. បង្ហាញ Form កែសម្រួល Status
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '/feedbacks');
            exit;
        }

        $feedbackModel = new Feedback();
        $feedback = $feedbackModel->find($id);

        if (!$feedback) {
            header('Location: ' . BASE_URL . '/feedbacks');
            exit;
        }

        $settingModel = new Setting();
        $settings = $settingModel->all();
        $settingsByKey = [];
        foreach ($settings as $item) {
            $settingsByKey[$item['setting_key']] = $item;
        }

        $this->view('feedbacks/edit', [
            'feedback' => $feedback,
            'settingsByKey' => $settingsByKey
        ]);
    }

    // ៣. រក្សាទុកការកែសម្រួល Status
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/feedbacks');
            exit;
        }

        $id = (int) $_POST['id'];
        $status = $_POST['status'];

        $feedbackModel = new Feedback();
        $feedbackModel->updateStatus($id, $status);

        header('Location: ' . BASE_URL . '/feedbacks');
        exit;
    }

    // ៤. លុប Feedback
    public function destroy()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $feedbackModel = new Feedback();
            $feedbackModel->delete($id);
        }
        header('Location: ' . BASE_URL . '/feedbacks');
        exit;
    }
    // ក្នុង ReviewController.php ឬ FeedbackController.php

    public function storeFromUser()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        // ពិនិត្យមើលថាតើ User បាន Login ឬអត់
        if (empty($_SESSION['customer_id'])) {
            $_SESSION['error'] = 'Please login to write a review.';
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $data = [
            'customer_id' => $_SESSION['customer_id'],
            'product_id' => (int) $_POST['product_id'],
            'subject' => trim($_POST['subject']),
            'message' => trim($_POST['message']),
            'rating' => (int) $_POST['rating'],
            'status' => 'pending', // រង់ចាំ Admin ពិនិត្យ
        ];

        $db = Database::connection();
        $stmt = $db->prepare("
        INSERT INTO reviews (customer_id, product_id, subject, message, rating, status, created_at, updated_at) 
        VALUES (:customer_id, :product_id, :subject, :message, :rating, :status, NOW(), NOW())
    ");

        $stmt->execute($data);

        $_SESSION['success'] = 'Thank you! Your review has been submitted and is pending approval.';
        header('Location: ' . BASE_URL . '/products/show?id=' . $data['product_id']);
        exit;
    }
}