
<?php
// ═══════════════════════════════════════════════
// AUTH ROUTES
// ═══════════════════════════════════════════════
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);

$router->get('/logout', [AuthController::class, 'logout']);



$router->get("/", [WelcomeController::class, 'welcome']);

//=============================
//===Product 
//=============================
$router->get("/products", [ProductController::class, 'index']);
$router->get('/products/create', [ProductController::class, 'create']);
$router->post('/products/store', [ProductController::class, 'store']);
$router->get('/products/show', [ProductController::class, 'show']);
$router->get('/products/edit', [ProductController::class, 'edit']);
$router->post('/products/update', [ProductController::class, 'update']);
$router->post('/products/destroy', [ProductController::class, 'destroy']);
//=============================
//=== Categorie 
//=============================
$router->get('/categorie', [CategorieController::class, 'index']);
$router->get('/categorie/create', [CategorieController::class, 'create']);
$router->post('/categorie/store', [CategorieController::class, 'store']);
$router->get('/categorie/show', [CategorieController::class, 'show']);
$router->get('/categorie/edit', [CategorieController::class, 'edit']);
$router->post('/categorie/update', [CategorieController::class, 'update']);
$router->post('/categorie/destroy', [CategorieController::class, 'destroy']);
//=============================
//===Order 
//=============================
$router->get('/orders', [OrderController::class, 'index']);
$router->get('/orders/create', [OrderController::class, 'create']);
$router->post('/orders/store', [OrderController::class, 'store']);
$router->get('/orders/show', [OrderController::class, 'show']);
$router->get('/orders/edit', [OrderController::class, 'edit']);
$router->post('/orders/update', [OrderController::class, 'update']);
$router->post('/orders/destroy', [OrderController::class, 'destroy']);
//=============================
//===Customer 
//=============================
$router->get('/customers', [CustomerController::class, 'index']);
$router->get('/customers/create', [CustomerController::class, 'create']);
$router->post('/customers/store', [CustomerController::class, 'store']);
$router->get('/customers/show', [CustomerController::class, 'show']);
$router->get('/customers/edit', [CustomerController::class, 'edit']);
$router->post('/customers/update', [CustomerController::class, 'update']);
$router->post('/customers/destroy', [CustomerController::class, 'destroy']);
//=============================
//===Feedback 
//=============================
$router->get('/feedbacks', [FeedbackController::class, 'index']);
$router->get('/feedbacks/create', [FeedbackController::class, 'create']);
$router->post('/feedbacks/store', [FeedbackController::class, 'store']);
$router->get('/feedbacks/show', [FeedbackController::class, 'show']);
$router->get('/feedbacks/edit', [FeedbackController::class, 'edit']);
$router->post('/feedbacks/update', [FeedbackController::class, 'update']);
$router->post('/feedbacks/destroy', [FeedbackController::class, 'destroy']);
//=============================
//===promotion 
//=============================
$router->get('/promotions', [PromotionController::class, 'index']);
$router->get('/promotions/create', [PromotionController::class, 'create']);
$router->post('/promotions/store', [PromotionController::class, 'store']);
$router->get('/promotions/show', [PromotionController::class, 'show']);
$router->get('/promotions/edit', [PromotionController::class, 'edit']);
$router->post('/promotions/update', [PromotionController::class, 'update']);
$router->post('/promotions/destroy', [PromotionController::class, 'destroy']);
//=============================
//=== Setting
//=============================
$router->get('/settings', [SettingController::class, 'index']);
$router->get('/setting/edit', [SettingController::class, 'edit']);
$router->post('/setting/update', [SettingController::class, 'update']);

// Feedback Routes

