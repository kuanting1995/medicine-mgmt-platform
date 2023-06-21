<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required-for-api.php';
$output = [
    'success' => false,
    'error' => [],
    'postDara' => $_POST,
];






if (!empty($_POST['name'])) {
    $isPass = true;


    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $gender = $_POST['gender'] ?? "";
    $birthday = $_POST['birthday'] ?? "";
    $mobile = $_POST['mobile'] ?? "";
    $city = $_POST['city'] ?? "";
    $dist = $_POST['dist'] ?? "";
    $rd = $_POST['rd'] ?? "";
    $level = $_POST['level'] ?? "";

    //檢查姓名
    if (mb_strlen($name, 'utf8') < 2) {
        $output['errors']['name'] = '請輸入正確姓名';
        $isPass = false;
    }
    //檢查email
    if (!empty($email) and !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $output['errors']['email'] = 'Email格式錯誤';
        $isPass = false;
    }
    if (empty($password)) {
        $output['errors']['password'] = '無設定密碼';
        $isPass = false;
    }


    if ($isPass) {
        $sql = "INSERT INTO `members`(
        `member_name`, 
        `email`, 
        `password`, 
        `mobile`, 
        `gender`, 
        `birthday`, 
        `address_city`, 
        `address_dist`, 
        `address_rd`, 
        `member_level_id`, 
        `last_edit_date`)  VALUES(
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
            NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(
            [
                $name,
                $email,
                $password,
                $mobile,
                $gender,
                $birthday,
                $city,
                $dist,
                $rd,
                $level
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
