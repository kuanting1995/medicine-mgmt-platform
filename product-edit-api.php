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

$product_id = intval($_POST['product_id']);
$product_category_id = $_POST['product_category_id'];
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$product_pic = $_POST['product_pic'];
$brand_category_id = $_POST['brand_category_id'];


$isPass = true; // 預設是通過的
// TODO: 欄位檢查



if ($isPass) {
  $sql = "UPDATE `product_total` SET
    `product_category_id`=?,
    `product_name`=?,
    `product_price`=?,
    `product_pic`=?, 
    `brand_category_id`=? 
    WHERE `product_id`=?";

  $stmt = $pdo->prepare($sql);

  $stmt->execute([
    $product_category_id,
    $product_name,
    $product_price,
    $product_pic,
    $brand_category_id,
    $product_id,
  ]);

  if ($stmt->rowCount()) {
    $output['success'] = true;
  } else {
    $output['msg'] = '資料沒有變更';
  }
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
