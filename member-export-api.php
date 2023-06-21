<?php

require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin_required_for_api.php';

$pdo = mysqli_connect("localhost", "medicine", "medicine", "medicine");

$sql = "";




if (!isset($_GET['export_e_id']) || $_GET['export_e_id'] == "none") {
    if (empty($_GET['src_id'])) {
        $sql = "SELECT * FROM `members`";
    } else {
        $src_id = substr($_GET['src_id'], 0, -4);
        $sql = "SELECT * FROM `members` WHERE $src_id ";
    }
} else {
    $id = $_GET['export_s_id'];
    $eid = $_GET['export_e_id'];

    $sql = "SELECT * FROM `members` WHERE`member_id` between $id and $eid";
}


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
header('Content-Type: application/xls');
header('Content-Disposition: attachment; filename=member_data.xls');
echo $export;