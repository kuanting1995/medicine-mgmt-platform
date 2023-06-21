<?php

require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required-for-api.php';

$pdo = mysqli_connect("localhost", "medicine", "medicine", "medicine");








$id = $_GET['id'];

$sql = "SELECT * FROM `members` WHERE `member_id` = $id";

$stmt = mysqli_query($pdo, $sql);





$export = '
 <table> 
 <tr> 
 <th>會員id </th>
 <th>姓名</th> 
 <th>email</th> 
 <th>電話</th> 
 <th>性別</th> 
 <th>生日</th> 
 <th>地址</th> 
 <th>會員資格</th> 

 
 </tr>
 ';
while ($row = mysqli_fetch_array($stmt)) {
    if ($row["member_level_id"] == 1) {
        $level = "金會員";
    } elseif ($row["member_level_id"] == 2) {
        $level = "銀會員";
    } elseif ($row["member_level_id"] == 3) {
        $level = "一般會員";
    } elseif ($row["member_level_id"] == 5) {
        $level = "停權會員";
    }

    if ($row["gender"] == "female") {
        $gender = "女";
    } else {
        $gender = "男";
    }
    $export .= '
 <tr>
 <td>' . $row["member_id"] . '</td> 
 <td>' . $row["member_name"] . '</td> 
 <td>' . $row["email"] . '</td> 
 <td>' . $row["mobile"] . '</td> 
 <td>' . $gender . '</td> 
 <td>' . $row["birthday"] . '</td> 
 <td>' . $row["address_city"] . $row["address_dist"] . $row["address_rd"] . '</td> 

 <td>' . $level . '</td> 

 
 
 </tr>
 ';
}
$export .= '</table>';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=info.xls');

$export = mb_convert_encoding($export, "Big5", "UTF-8");

echo $export;
