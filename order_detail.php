<?php
require __DIR__ . '/parts/connect_db.php';


$pageName = "order_detail";
$title = "訂單明細";
//  $perPage = 10;
//  $tr_count = 0;
//  $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
// if ($page<1) {
//     header('Location: ?page=1');
//     exit;
// }
//  $t_sql = "SELECT COUNT(1) FROM order_all";
//  $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
//  $totalPages = ceil($totalRows / $perPage);
$sid = $_GET['sid'];

$sql = "SELECT * FROM `order_all`AS o JOIN `product_total` AS p ON o.product_id= p.product_id WHERE `order_id` = $sid";
$rows = $pdo->query($sql)->fetch();

$sqll = "SELECT * FROM `order_all`AS o JOIN `order_status` AS s ON o.order_state= s.order_status_id WHERE `order_id` = $sid";
//WHERE 要拿什麼資料
$r = $pdo->query($sqll)->fetch();





?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<style>
  #bee-btn {
    border: 1px solid #4a493b;
    transform: translateX(500%);
    background-color: #F6E8B0;
    border: 1px solid #F6E8B0;
  }

  #bee-btn:hover {
    background-color: white;
  }
</style>
<?php include __DIR__ . '/parts/navbar.php' ?>

<div class="container">
  <div class="row justify-content-center mb-5">
    <div class="col-4">
      <h2 class="text-center">訂單明細</h2>
    </div>
  </div>
</div>

<table class="table table-striped container">
  <tr>
    <th scope="row">訂單編號</th>
    <td><?= $rows["order_id"] ?></td>
  </tr>
  <tr>
    <th scope="row">訂購日期</th>
    <td><?= $rows["order_day"] ?></td>
  </tr>
  <tr>
    <th scope="row">訂單狀態</th>
    <td><?= $r["order_status"] ?></td>
  </tr>
  <tr>
    <th scope="row">商品名稱</th>
    <td><?= $rows["product_id"] ?></td>
  </tr>
  <tr>

    <th for="product" class="form-label " scope="row">商品名稱</th>

    <td><?= $rows['product_name'] ?></td>
  </tr>
  <tr>
    <th for="product" class="form-label" scope="row">商品照片</th>

    <td type="text" class="form-control"> <img class="product_img" style="width:100px" src="./image/<?= $rows['product_pic'] ?>"></td>

  </tr>
  <tr>
    <th scope="row">商品數量</th>
    <td><?= $rows["product_number"] ?></td>
  </tr>
  <tr>
    <th scope="row">運費</th>
    <td><?= $rows["order_ship_money"] ?></td>
  </tr>
  <tr>
    <th scope="row">優惠折抵</th>
    <td><?= $rows["code"] ?></td>
  </tr>
  <tr>
    <th scope="row">訂單金額</th>
    <td><?= $rows["order_money"] ?></td>
  </tr>
  <tr>
    <th scope="row">收件人</th>
    <td><?= $rows["order_recipient"] ?></td>
  </tr>
  <tr>
    <th scope="row">收件人電話</th>
    <td><?= $rows["order_phone"] ?></td>
  </tr>
  <tr>
    <th scope="row">收件人地址</th>
    <td><?= $rows["order_address_city"] ?><?= $rows["order_address_dist"] ?><?= $rows["order_address"] ?></td>
  </tr>
  <tr>
    <th scope="row">訂單備註</th>
    <td><?= $rows["order_memo"] ?></td>
  </tr>

</table>

<div class="container">
  <a href="order_.php" class="btn btn-outline col-1" id="bee-btn" style="color: #4a493b">返回</a>
  <a href="order-edit.php?sid=<?= $rows["order_id"] ?>" class="btn btn-outline col-1" id="bee-btn">修改</a>
</div>
<br>

<?php include __DIR__ . '/parts/script.php' ?>
<script>
  const tr = document.querySelectorAll("tbody tr");

  const changeColor = [...tr];
  for (let i in changeColor) {
    if (i % 2 === 0) {
      changeColor[i].style = "background-color:#f6e8b0";
    }
  }

  const del = document.querySelectorAll('.del');

  [...del].map(el => el.addEventListener('click', e =>
    // e.currentTarget.closest('tr')
    e.currentTarget.closest('tr').remove()))
</script>

<?php include __DIR__ . '/parts/html-foot.php' ?>