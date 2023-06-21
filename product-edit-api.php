<?php
require __DIR__ . '/../connect/admin-required-for-api.php';
require __DIR__ . '/../connect/connect_db.php';

header('Content-Type: application/json');

// 設定輸出的格式
$output = [
  'success' => false,
  'code' => 0, // 除錯用
  'errors' => [],
  'postData' => $_POST, // 除錯用
];



if (empty(intval($_POST['sid']))) {
  $output['errors'] = ['sid' => '沒有資料主鍵'];
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}
$sid = intval($_POST['sid']);
$logo = $_POST['logo1'] ?? '';
$name = $_POST['name'] ?? '';
$account = $_POST['account'] ?? '';
$password = $_POST['password'] ?? '';
$leader = $_POST['leader'] ?? '';
$leaderId = $_POST['leaderId'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$email = $_POST['email'] ?? '';
$website = $_POST['website'] ?? '';
$city = $_POST['city'] ?? '';
$address = $_POST['address'] ?? '';
$time = $_POST['time'] ?? '';
$rest = $_POST['rest'] ?? '';
$news = $_POST['news'] ?? '';


$isPass = true; // 預設是通過的
// TODO: 欄位檢查
// 檢查姓名
if (mb_strlen($name, 'utf8') < 2) {
  $output['errors']['name'] = '請輸入正確的姓名';
  $isPass = false;
}

if (!empty($mobile) and !preg_match("/(^(\(0\d{1}\)|0\d{1}\-)?\d{7,8}$)|(^09\d{2}-?\d{3}-?\d{3}$)/", $mobile)) {
  $output['errors']['mobile'] = '請輸入正確電話號碼';
  $isPass = false;
}

// 檢查 email 格式: 有填值才判斷格式
if (!empty($email) and !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $output['errors']['email'] = '格式不合法';
  $isPass = false;
}


if ($isPass) {
  $sql = "UPDATE `product` SET
    `productLogo`=?, 
    `productName`=?, 
    `productLeader`=?, 
    `productAccount`=?, 
    `productPassword`=?, 
    `productLeaderId`=?, 
    `productMobile`=?,
    `productEmail`=?, 
    `productWebsite`=?,
    `productCity`=?,
    `productAddress`=?,
    `productTime`=?,
    `productRest`=?,
    `productNews`=?,
    `productEditAt`=NOW() 
    WHERE `productSid`=?";

  $stmt = $pdo->prepare($sql);

  $stmt->execute([
    $logo,
    $name,
    $leader,
    $account,
    $password,
    $leaderId,
    $mobile,
    $email,
    $website,
    $city,
    $address,
    $time,
    $rest,
    $news,
    $sid,
  ]);

  if ($stmt->rowCount()) {
    $output['success'] = true;
  } else {
    $output['msg'] = '資料沒有變更';
  }
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);