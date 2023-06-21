<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required-for-api.php';


$output = [
    'success' => false,
    'error' => [],
    'postDara' => $_POST,
];


//若沒有資料
$member_id = isset($_POST['member_id']) ? intval($_POST['member_id']) : 0;
if (empty($member_id)) {
    $output['error'] = ['沒有資料主鍵'];
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    header('Location: member-list.php');
    exit;
}

//拿新密碼
$new_pass = $_POST['password'];
$new_password = password_hash($new_pass, PASSWORD_DEFAULT);

//有輸入舊密碼
if (!empty($_POST['old_password'])) {
    $isPass = true;
    $sql = "SELECT * FROM `members` WHERE `member_id` = $member_id";
}

//取出舊密碼
$r = $pdo->query($sql)->fetch();
$hash = $r['password'];
//驗證舊密碼正確
$pass_ve = password_verify($_POST['old_password'], $hash);



if ($pass_ve) {
    //新舊密碼不同
    if ($new_pass != $_POST['old_password']) {
        $isPass = true;
        $output['success'] = true;
    } else {
        $isPass = false;
        $output['success'] = false;
        $output['error'] = '舊密碼不能同於新密碼';
    };
} else {
    $isPass = false;
    $output['success'] = false;
    $output['error'] = '原密碼輸入錯誤';
};


if ($isPass) {
    $sql_edit_pass = "UPDATE `members` SET `password`=? WHERE `member_id` = $member_id";
    $stmt = $pdo->prepare($sql_edit_pass);
    $stmt->execute([$new_password]);
}








echo json_encode($output, JSON_UNESCAPED_UNICODE);
