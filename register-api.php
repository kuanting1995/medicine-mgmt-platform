<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required-for-api.php';
$output = [
    'success' => false,
    'error' => [],
    'postDara' => $_POST,
];

if (!empty($_POST['account'])) {
$isPass = true;


$account = $_POST['account'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);


if ($isPass) {
$sql = "INSERT INTO `admins`( `account`, `password`, `permissions`, `create_at`) VALUES (?,?,?,NOW())";

$stmt = $pdo->prepare($sql);
$stmt->execute(
[
$account,
$password,
"1"
]
);


if ($stmt->rowCount()) {
$output['success'] = true;
} else {
$output['msg'] = '未加入新資料';
}
}
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
