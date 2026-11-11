



<?php 

$baseDir = preg_replace("#/public$#i", "", str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"] ?? "")));
define("BASE_URL", $baseDir === "/" ? "" : $baseDir);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

// ប្រើ realpath() ដើម្បីការពារបញ្ហា Path សញ្ញា slash / \ ខុសគ្នាលើ Windows
require_once dirname(__DIR__) . '/app/Core/Database.php';
require_once dirname(__DIR__) . '/app/Core/Controller.php';
require_once dirname(__DIR__) . '/app/Core/Routes.php';
require_once dirname(__DIR__) . '/app/Controller/WelcomeController.php';
require_once dirname(__DIR__) . '/app/Controller/ProductController.php';
require_once dirname(__DIR__) . '/app/Controller/CategorieController.php';
require_once dirname(__DIR__) . '/app/Controller/SettingController.php';
require_once dirname(__DIR__) . '/app/Controller/OrderController.php';
require_once dirname(__DIR__) . '/app/Controller/CustomerController.php';
require_once dirname(__DIR__) . '/app/Controller/PromotionController.php';
require_once dirname(__DIR__) . '/app/Controller/FeedbackController.php';
require_once dirname(__DIR__) . '/app/Controller/AuthController.php';

require_once __DIR__ . '/../app/Models/Model.php';
require_once __DIR__ . '/../app/Models/Product.php';
require_once __DIR__ . '/../app/Models/Categorie.php';
require_once __DIR__ . '/../app/Models/Setting.php';
require_once __DIR__ . '/../app/Models/Order.php';
require_once __DIR__ . '/../app/Models/Customer.php';
require_once __DIR__ . '/../app/Models/Promotion.php';
require_once __DIR__ . '/../app/Models/Feedback.php';


$router = new Router();

// Require file web.php
require_once dirname(__DIR__) . '/routes/web.php';

// ដំណើរការ Router
$router->dispatch();