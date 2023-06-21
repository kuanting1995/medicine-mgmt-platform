<?php
require __DIR__ . '/../connect/admin-required-for-api.php';
require __DIR__ . '/../connect/connect_db.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'code' => 0,
    'errors' => [],
    'postData' => $_POST,
];

if (empty($_POST)) {
    $output['errors'] = ['all' => '沒有表單資料'];
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}


$logo = $_POST['logo1'] ?? '';
$name = $_POST['name'] ?? '';
$account = $_POST['account'] ?? '';
$password = $_POST['password'] ?? '';
$leader = $_POST['leader'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$city = $_POST['city'] ?? '';
$address = $_POST['address'] ?? '';
$email = $_POST['email'] ?? '';
$time = $_POST['time'] ?? '';
$rest = $_POST['rest'] ?? '';
$website = $_POST['website'] ?? '';
$leaderId = $_POST['leaderId'] ?? '';
$news = $_POST['news'] ?? '';


$isPass = true;

if (mb_strlen($name, 'utf8') < 2) {
    $output['errors']['name'] = '請輸入正確的姓名';
    $isPass = false;
}

if (!empty($email) and !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $output['errors']['email'] = '格式不合法';
    $isPass = false;
}


if ($isPass) {
    $sql = "INSERT INTO `store`(
        `storeName`,`storeAccount`,`storePassword`,`storeLeader`,`storeLeaderId`,`storeMobile`,`storeCity`,`storeAddress`,`storeEmail`,`storeTime`,`storeRest`,`storeWebsite`,`storeLogo`,`storeNews`,`storeCreatedAt`) VALUES(
        ?,?,?,?,
        ?,?,?,?,
        ?,?,?,?,
        ?,?,NOW())";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $name,
        $account,
        $password,
        $leader,
        $leaderId,
        $mobile,
        $city,
        $address,
        $email,
        $time,
        $rest,
        $website,
        $logo,
        $news,
    ]);

    if ($stmt->rowCount()) {
        $output['success'] = true;
    }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
