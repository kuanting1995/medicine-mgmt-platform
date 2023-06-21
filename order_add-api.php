<?php

require __DIR__ . '/parts/connect_db.php';


$output = [
  'success' => false,
  'code' => 0, // 除錯用
  'errors' => [],
  'postData' => $_POST, // 除錯用
];
//有沒有表單資料
if (empty($_POST)) {
  $output['errors'] = ['all' => '沒有表單資料'];
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}

$order_day = $_POST['order_day'] ?? '';
$member_id = $_POST['member_id'] ?? '';
$order_state = $_POST['order_state'] ?? '';
$product_id = $_POST['product_id'] ?? '';
$product_number = $_POST['product_number'] ?? '';
$order_money = $_POST['order_money'] ?? '';
$order_memo = $_POST['order_memo'] ?? '';
$order_ship_money = $_POST['order_ship_money'] ?? '';
$code = $_POST['code'] ?? '';
$order_recipient = $_POST['order_recipient'] ?? '';
$order_order_phone = $_POST['order_order_phone'] ?? '';
$order_address_city = $_POST['order_address_city'] ?? '';
$order_address_dist = $_POST['order_address_dist'] ?? '';
$order_address = $_POST['order_address'] ?? '';


$isPass = true; //預設通過

//檢查姓名
if (mb_strlen($order_recipient, 'utf8') < 2) {
  $output['errors']['order_recipient'] = '請輸入正確的姓名';
  $isPass = false;
}

// if ($isPass) {
$sql = "INSERT INTO `order_all`(
           
            `order_day`,
            `member_id`, 
            `order_state`, 
            `product_id`, 
            `product_number`, 
            `order_money`, 
            `order_memo`, 
            `order_ship_money`, 
            `code`, 
            `order_recipient`, 
            `order_phone`, 
            `order_address_city`, 
            `order_address_dist`, 
            `order_address`) 
            VALUES (
                
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?
            )";

$stmt = $pdo->prepare($sql);
$stmt->execute([

  $order_day,
  $member_id,
  $order_state,
  $product_id,
  $product_number,
  $order_ship_money,
  $order_memo,
  $order_money,
  $code,
  $order_recipient,
  $_POST['order_phone'],
  $_POST['city'],
  $_POST['dist'],
  $_POST['address']

]);


if ($stmt->rowCount()) {
  $output['success'] = true;
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
