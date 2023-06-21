<?php 
require __DIR__.'/parts/connect_db.php';
require __DIR__.'/parts/admin-required-for-api.php';


$output = [
    'success'=>false,
    'error'=>[],
    'postDara'=>$_POST,
];



//若沒有資料
if (empty(intval($_POST['member_id']))) {
    $output['error'] = ['id'=>'沒有資料主鍵'];
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
    exit;
}

if(!empty($_POST['name'])){
    $isPass=true;

    $id = intval($_POST['member_id']);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];  
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $city = $_POST['city'];
    $dist = $_POST['dist'];
    $rd= $_POST['rd'];
    $level = $_POST['level'];

//檢查姓名
if(mb_strlen($name, 'utf8')<2 ){
    $output['errors']['name']='請輸入正確姓名';
    $isPass=false;
}
//檢查email
if(!empty($email) and !filter_var($email,FILTER_VALIDATE_EMAIL)){
    $output['errors']['email']='Email格式錯誤';
    $isPass=false;
}


if($isPass){   
    $sql= "UPDATE `members` SET `member_name`=?,`email`=?,`mobile`=?,`gender`=?,`birthday`=?,`address_city`=?,`address_dist`=?,`address_rd`=?,`member_level_id`=? WHERE `member_id`=?";

$stmt = $pdo ->prepare($sql);
$stmt -> execute(
   [
    $name,
    $email,
    $mobile,
    $gender,
    $birthday, 
    $city,
    $dist,
    $rd,
    $level,
    $id
   ] );

   if($stmt->rowCount()){
    $output['success']=true;
   }else{
    $output['msg']='資料未變更';
   }
}




}

echo json_encode($output,JSON_UNESCAPED_UNICODE);