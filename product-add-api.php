<?php

require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required-for-api.php';

header('Content-Type: application/json');
// 設定輸出的格式
$output = [
  'success' => false,
  'code' => 0, // 除錯用
  'errors' => [],
  'postData' => $_POST, // 除錯用
];



// 沒有表單資料
if (empty($_POST)) {
  $output['errors'] = ['all' => '沒有表單資料'];
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}

$isPass = true;

$product_category_id = $_POST['product_category_id'];
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$product_pic = $_POST['product_pic'];
$brand_category_id = $_POST['brand_category_id'];

$isPass = true; // 預設是通過的


if ($isPass) {
  $sql = "INSERT INTO `product_total` (
    `product_category_id`, `product_name`, `product_price`,`product_pic`, `brand_category_id`,`created_at`,`updated_at`
    
    ) VALUES (
      ?, ?, ?, ?, ?, NOW(), NOW())";

  $stmt = $pdo->prepare($sql);

  $stmt->execute([
    $product_category_id,
    $product_name,
    $product_price,
    $product_pic,
    $brand_category_id,
  ]);

  if ($stmt->rowCount()) {
    $output['success'] = true;
  }
}




echo json_encode($output, JSON_UNESCAPED_UNICODE);
