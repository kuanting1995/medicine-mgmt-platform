<?php 
require __DIR__.'/parts/connect_db.php';
require __DIR__.'/parts/admin_required.php';

$title="會員歷史訂單";
$nowpage="member_his_order";
?>

<?php

 $member_id = isset($_GET['member_id'])?intval($_GET['member_id']):0;
  if(empty($member_id)){
      header('Location: member_list.php');exit;
  }

//  $sql = "SELECT * FROM `order_all` WHERE `member_id`= $member_id";
//  $r= $pdo->query($sql)->fetch();
//   if(empty($r)){
//       header('Location: member_list.php');exit;
//   }



  $perPage = 10;
  $page = isset($_GET['page'])?intval($_GET['page']):1;
      if ($page<1){
          header('Location: ?page=1');exit;
  
      }
      $t_sql="SELECT COUNT(1) FROM `order_all` WHERE `member_id`= $member_id";
      $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
  


  $totalPage = ceil($totalRows/$perPage);
  
  $all=[];
  $sqlall= sprintf( "SELECT * FROM `member_list`");
      $all=$pdo->query($sqlall)->fetchAll();
  
  
  $rows=[];
  if($totalPage>0){
      if($page>$totalPage){
          header('Location: ?page'.$totalPage);exit;
      }
      $sql= sprintf( "SELECT * FROM `order_all` WHERE `member_id`= $member_id ORDER BY `member_id` DESC" );
      $rows=$pdo->query($sql)->fetchAll();
  }










?>




<?php include __DIR__.'/parts/html-head.php';?>
<?php include __DIR__.'/parts/navbar.php'; ?>

<div class="row justify-content-center mb-5">
    <div class="col-4">
        <h2 class="text-center">會員歷史訂單</h2>
    </div>
</div>


<div class="container mb-3">

    <div class="buttoncont">
        <div class="d-flex flex-row justify-content-end mb-2">
            <a href="<?=$_SERVER['HTTP_REFERER'] ?>" class="btn btn-outline-secondary me-auto" role="button">返回</a>




        </div>

    </div>


</div>







<div class="container">
    <div class="list_cont">
        <table class="table table-striped">

            <thead>
                <tr class="thead">


                    <td> </td>

                    <td>訂單編號</td>
                    <td>訂購日期</td>
                    <td>訂單狀態</td>
                    <td>訂單金額</td>
                    <td>訂單備註</td>
                    <td>訂單明細</td>






                </tr>


            </thead>

            <tbody>
                <?php foreach ($rows as $r) : ?>

                <td><a href="order-edit.php?sid=<?= $r['order_id'] ?>"><i class="fa-solid fa-pen-to-square"
                            style="color:#4a493b"></i></a></td>
                <td><?= $r['order_id'] ?></td>
                <td><?= $r['order_day'] ?></td>

                <td><?= $r['order_state'] ?></td>
                <td><?= $r['order_money'] ?></td>
                <td><?= $r['order_memo'] ?></td>
                <td>
                    <a href="order_detail.php?sid=<?= $r['order_id'] ?>" style="color:#4a493b">
                        <i class="fa-solid fa-layer-group"></i></a>
                </td>


                </tr>


                <?php endforeach; ?>
            </tbody>




        </table>




        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <nav>
                    <ul class="pagination">

                        <li class="  me-1">
                            <a class="page-link" style="color: #4a493b;" href='<?= "?page=({$page} - 1)" ?>'>上一頁</a>
                        </li>

                        <?php  for($i=$page-1;$i<=$page+1;$i++):
                                    if ($i>=1 and $i<=$totalPage):
                                        ?>

                        <li class=" me-2">
                            <a class="page-link" style="color: #4a493b;background-color:#f4f4f5;"
                                href="?page=<?=$i?>"><?=$i?></a>
                        </li>


                        <?php  endif;  endfor;?>








                        <li class=" me-1">
                            <a class="page-link" style="color: #4a493b;" href="?page=<?= $page + 1 ?>">下一頁</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

</div>













<?php include __DIR__.'/parts/scripts.php';?>

<script>
const tr = document.querySelectorAll("tbody tr");
const changeColor = [...tr];
for (let i in changeColor) {
    if (i % 2 === 0) {
        changeColor[i].style = "background-color:#FFFFCC";
    }
};

function delete_it(sid) {
    if (confirm(`是否要刪除編號為 ${sid} 的資料?`)) {
        location.href = 'delete.php?sid=' + sid;
    }
}
</script>
<?php include __DIR__.'/parts/html-foot.php';?>