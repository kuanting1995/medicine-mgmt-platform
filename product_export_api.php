<?php

require __DIR__.'/parts/connect_db.php';
require __DIR__.'/parts/admin_required_for_api.php.';

$pdo = mysqli_connect("192.168.21.92", "beebee1", "beebee1", "beebee1");

$sql = "SELECT * FROM `product_total`pt JOIN
`product`p ON pt.`product_category_id` = p.`product_category_id`JOIN
`brand`b ON pt.`brand_category_id` = b.`brand_category_id`";



$stmt =mysqli_query($pdo,$sql);




 
 $export = '
 <table> 
 <tr> 
 <th>商品id </th>
 <th>商品分類編號</th> 
 <th>商品分類名稱</th> 
 <th>商品名稱</th> 
 <th>商品價格</th> 
 <th>商品圖片編號</th> 
 <th>品牌分類編號</th> 
 <th>品牌分類名稱</th> 
 <th>商品登入時間</th> 
 
 </tr>
 ';
 while($row = mysqli_fetch_array($stmt))
 {
    $imgdata = base64_decode($row['product_pic']);


    
 $export .= '
 <tr>
 <td>'.$row["product_id"].'</td> 
 <td>'.$row["product_category_id"].'</td> 
 <td>'.$row["product_category"].'</td> 
 <td>'.$row["product_name"].'</td> 
 <td>'.$row["product_price"].'</td> 
 <td>'.$row['product_pic'].'</td> 
 <td>'.$row["brand_category_id"].'</td> 
 <td>'.$row["brand_category"].'</td> 
 <td>'.$row["created_at"].'</td> 

 
 
 </tr>
 ';
 }
 $export .= '</table>';
 header('Content-Type: application/xls');
 header('Content-Disposition: attachment; filename=member_data.xls');
 echo $export;
 