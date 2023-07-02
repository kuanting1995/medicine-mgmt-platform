<?php require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';
$pageSid = "5";
$title = "訂單管理";
$perPage = 10;
$tr_count = 0;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}
$t_sql = "SELECT COUNT(1) FROM order_all";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$totalPages = ceil($totalRows / $perPage);

$rows = [];
if ($totalRows > 0) {
    $sql = sprintf(
        "SELECT * FROM `order_all` ORDER BY `order_id` ASC LIMIT %s, %s",
        ($page - 1) * $perPage,
        $perPage
    );
    $rows = $pdo->query($sql)->fetchAll();
}

?>

<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/css-style.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>

<style>
    .fonts {
        text-align: center;
    }

    .my-btn {
        border: 1px solid #4a493b;
        background-color: #fff;
    }

    .my-btn:hover {
        background-color: white;
    }
</style>

<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>


<div class="container w-75 mt-5">
    <div class="mb-3">
        <div class="row ">
            <div class="col-3 d-flex justify-content-between ">
                <!-- <select class="form-select form-select-sm">
                <option selected>訂單日期（起）</option>
                <option value="1">2022-12</option>
                <option value="2">2022-11</option>
                <option value="3">2022-10</option>
                <option value="4">2022-09</option>
                <option value="5">2022-08</option>
                <option value="6">2022-07</option>
                <option value="7">2022-06</option>
            </select> -->
            </div>

            <div class="col-3 d-flex justify-content-between ">
                <!-- <select class="form-select form-select-sm">
                <option selected>訂單日期（末）</option>
                <option value="1">2022-12</option>
                <option value="2">2022-11</option>
                <option value="3">2022-10</option>
                <option value="4">2022-09</option>
                <option value="5">2022-08</option>
                <option value="6">2022-07</option>
                <option value="7">2022-06</option>
            </select> -->
            </div>
            <div class="col-1"></div>
            <a href="order-add.php" type="submit" class="btn btn-outline  col-2 my-btn" style="color: #4a493b">新增訂單</a>
            <div class="col-3">
                <form name="form1" method="post" action="" class="d-flex" role="search">
                    <input name="keyword" id="keyword" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-secondary" type="submit">search</button>
                </form>
            </div>

        </div>

    </div>
    <table class="table table-striped ">
        <thead>
            <tr class="fw-light fonts">
                <th scope="col" style="color:#4a493b"></th>
                <th scope="col" style="color:#4a493b">訂單編號</th>
                <th scope="col" style="color:#4a493b">訂購日期</th>
                <th scope="col" style="color:#4a493b">訂購者</th>
                <th scope="col" style="color:#4a493b">訂單狀態</th>
                <th scope="col" style="color:#4a493b">訂單金額</th>
                <th scope="col" style="color:#4a493b">訂單備註</th>
                <th scope="col" style="color:#4a493b">訂單明細</th>
                <th scope="col" style="color:#4a493b"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr class="fonts">
                    <td><a href="order-edit.php?sid=<?= $r['order_id'] ?>"><i class="fa-solid fa-pen-to-square" style="color:#4a493b"></i></a></td>
                    <td><?= $r['order_id'] ?></td>
                    <td><?= $r['order_day'] ?></td>
                    <td><?= $r['member_id'] ?></td>
                    <td><?= $r['order_state'] ?></td>
                    <td><?= $r['order_money'] ?></td>
                    <td><?= $r['order_memo'] ?></td>
                    <td>
                        <!-- <form method="get" action="order_detail.php"> -->
                        <a href="order_detail.php?sid=<?= $r['order_id'] ?>" style="color:#4a493b">
                            <i class="fa-solid fa-layer-group"></i></a>
                    <td>
                        <a href="javascript: delete_it(<?= $r['order_id'] ?>)">
                            <i class="fa-solid fa-trash-can " style="color:#4a493b"></i>
                        </a>
                    </td>
                </tr>
                <!-- onclick="delItem(event)" class="del" -->
            <?php endforeach ?>
        </tbody>
    </table>

    <?php
    //頁碼
    $perPage = 10;
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    if ($page < 1) {
        header('Location: ?page=1');
        exit;
    }
    $t_sql = "SELECT COUNT(1) FROM members";
    $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

    $totalPage = ceil($totalRows / $perPage);
    $showpage = 3; //每次要顯示幾筆分頁
    $cut = floor($showpage / 2); //以目前所在頁次 為中心 往左右各顯示幾個頁次 以無條件捨去
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <nav>

                    <ul class="pagination">

                        <li class="  me-1">
                            <a class="page-link" style="color: #4a493b;" href='<?= "?page=({$page} - 1)" ?>'>上一頁</a>
                        </li>

                        <?php
                        $left = 1;
                        $right = $totalPage;
                        if ($totalPage > $showpage) {
                            if ($page <= $cut) {
                                $left = $page - 1;
                            } else {
                                $left = $cut;
                            }
                            if ($page > $totalPage - $cut) {
                                $right = ($page == $totalPage ? 0 : 1);
                                $left += $left - $right;
                            } else {
                                $right = $cut + ($cut - $left);
                            }
                            $left = $page - $left;
                            $right = $page + $right;
                        }

                        for ($i = $left; $i <= $right; $i++) : ?>
                            <li class=" me-2">
                                <a class="page-link" style="color: #4a493b;" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>


                        <?php endfor; ?>

                        <li class=" me-1">
                            <a class="page-link" style="color: #4a493b;" href="?page=<?= $page + 1 ?>">下一頁</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/parts/scripts.php' ?>
    <script>
        function delete_it(sid) {
            if (confirm(`是否要刪除編號為 ${sid} 的資料?`)) {
                location.href = 'order_delete.php?sid=' + sid;
            }
        }

        function delItem(event) {
            event.currentTarget.closest('tr').remove();
        }

        const tr = document.querySelectorAll("tbody tr");

        const changeColor = [...tr];
        for (let i in changeColor) {
            if (i % 2 === 0) {
                changeColor[i].style = "background-color:#fff";
            }
        }

        const del = document.querySelectorAll('.del');

        [...del].map(el => el.addEventListener('click', e =>
            // e.currentTarget.closest('tr')
            e.currentTarget.closest('tr').remove()))
    </script>
    <?php include __DIR__ . '/parts/html-foot.php' ?>