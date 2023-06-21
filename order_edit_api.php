<?php

require __DIR__ . '/parts/connect_db.php';

$output = [
  'success' => false,
  'code' => 0, // 除錯用
  'errors' => [],
  'postData' => $_POST, // 除錯用
];
//有沒有表單資料
if (empty(intval($_POST['order_id']))) {
  $output['errors'] = ['order_id' => '沒有資料主鍵'];
  $output['code'] = 1;
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}

$isPass = true; //預設通過

$order_id = intval($_POST['order_id']);
$order_day = $_POST['order_day'];
$member_id = $_POST['member_id'];
$order_state = $_POST['order_state'];
$product_id = $_POST['product_id'];
$product_number = $_POST['product_number'];
$order_ship_money = $_POST['order_ship_money'];
$code = $_POST['code'];
$money = $_POST['order_money'];
$order_recipient = $_POST['order_recipient'];
$order_phone = $_POST['order_phone'];
$city = $_POST['city'];
$dist = $_POST['dist'];
$address = $_POST['address'];
$memo = $_POST['order_memo'];




//檢查姓名
if (mb_strlen($order_recipient, 'utf8') < 2) {
  $output['errors']['order_recipient'] = '請輸入正確的姓名';
  $isPass = false;
  $output['code'] = 2;
}

if ($isPass) {
  $sql = "UPDATE order_all SET 
    `order_day`=?,`member_id`=?,`order_state`=?,`product_id`=?,`product_number`=?,`order_ship_money`=?,`code`=?,`order_money`=?,`order_recipient`=?,`order_phone`=?,`order_address_city`=?,`order_address_dist`=?,`order_address`=?,`order_memo`=? WHERE `order_id`=? ";

  $stmt = $pdo->prepare($sql);
  $stmt->execute(
    [
      $order_day,
      $member_id,
      $order_state,
      $product_id,
      $product_number,
      $order_ship_money,
      $code,
      $money,
      $order_recipient,
      $order_phone,
      $city,
      $dist,
      $address,
      $memo,
      $order_id
    ]
  );


  if ($stmt->rowCount()) {
    $output['success'] = true;
  } else {
    $output['msg'] = '資料沒有變更';
  }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
