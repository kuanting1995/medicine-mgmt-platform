<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin_required.php';


$title = "會員歷史評論";
$nowpage = "member_his_comment";
?>

<?php

$member_id = isset($_GET['member_id']) ? intval($_GET['member_id']) : 0;
if (empty($member_id)) {
    header('Location: member_list.php');
    exit;
}

//  $sql = "SELECT * FROM `order_all` WHERE `member_id`= $member_id";
//  $r= $pdo->query($sql)->fetch();
//   if(empty($r)){
//       header('Location: member_list.php');exit;
//   }



$perPage = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}
$t_sql = "SELECT COUNT(1) FROM `comment` WHERE `member_id`= $member_id";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];



$totalPage = ceil($totalRows / $perPage);

$all = [];
$sqlall = sprintf("SELECT * FROM `member_list`");
$all = $pdo->query($sqlall)->fetchAll();


$rows = [];
if ($totalPage > 0) {
    if ($page > $totalPage) {
        header('Location: ?page' . $totalPage);
        exit;
    }
    $sql = sprintf("SELECT * FROM `comment`c  
      JOIN product_total p ON
        c.product_id = p.product_id
      JOIN member_list m ON
        c.member_id = m.member_id 
        WHERE c.member_id= $member_id  
        ORDER BY c.id DESC");
    $rows = $pdo->query($sql)->fetchAll();
}










?>




<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>

<div class="row justify-content-center mb-5">
    <div class="col-4">
        <h2 class="text-center">會員歷史評論</h2>
    </div>
</div>


<div class="container mb-3">

    <div class="buttoncont">
        <div class="d-flex flex-row justify-content-end mb-2">
            <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-outline-secondary me-auto" role="button">返回</a>





        </div>

    </div>


</div>







<div class="container">
    <div class="list_cont">
        <table class="table table-striped">

            <thead>
                <tr class="thead">


                    <td> </td>
                    <td>評論編號</td>
                    <td>商品名稱</td>
                    <td>評論星級</td>
                    <td>評論內容</td>
                    <td>對應訂單</td>
                    <td>發布時間</td>
                    <td> </td>




                </tr>


            </thead>

            <tbody>
                <?php foreach ($rows as $r) : ?>

                    <td><a href=".php?sid=<?= $r['id'] ?>"><i class="fa-solid fa-pen-to-square" style="color:#4a493b"></i></a></td>
                    <td><?= $r['id'] ?></td>
                    <td><?= $r['product_name'] ?></td>
                    <td><?= $r['star'] ?></td>
                    <td><?= $r['content'] ?></td>
                    <td><?= $r['order_id'] ?></td>
                    <td><?= $r['created_at'] ?></td>
                    <td>

                        <a href=".php?sid=<?= $r['order_id'] ?>" style="color:#4a493b">
                            <i class="fa-solid fa-layer-group"></i></a>


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

                        <?php for ($i = $page - 1; $i <= $page + 1; $i++) :
                            if ($i >= 1 and $i <= $totalPage) :
                        ?>

                                <li class=" me-2">
                                    <a class="page-link" style="color: #4a493b;background-color:#f4f4f5;" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>


                        <?php endif;
                        endfor; ?>








                        <li class=" me-1">
                            <a class="page-link" style="color: #4a493b;" href="?page=<?= $page + 1 ?>">下一頁</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

</div>













<?php include __DIR__ . '/parts/scripts.php'; ?>

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
<?php include __DIR__ . '/parts/html-foot.php'; ?>