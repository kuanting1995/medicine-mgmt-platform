<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin_required.php';


$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
if (empty($product_id)) {
  header('Location: product_total.php'); // 轉向到列表頁
  exit;
}

$pdo->query("DELETE FROM `product_total` WHERE 	product_id=$product_id");

if (empty($_SERVER['HTTP_REFERER'])) {
  header('Location: product_total.php');
} else {
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}
