<?php
require __DIR__ . "/parts/connect_db.php";

//頁面名稱
$pageName = "product_total";

//網站標題
$title = "商品管理頁";

//每頁顯示幾個
$perPage = 7;

//幾個tr
$tr_count = 0;
$tr_color = "background-color:#f6e8b0";

//用戶點選page 傳送query string
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;


//page不能低於1 低於1直接跳轉
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}
//總共有幾筆資料
$t_sql = "SELECT count(1) FROM `product_total` WHERE 1";


//總共有幾欄
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

//總共有幾頁 
$totalPages = ceil($totalRows / $perPage);






//資料
$rows = [];
if ($totalRows > 0) {

    if ($page > $totalPages) {
        header('Location: ?page' . $totalPages);
        exit;
    }
    //要顯示的欄位
    $sql = sprintf("SELECT pt.product_id, pt.product_name, pt.product_price, pt.product_pic, pt.brand_category_id, pc.product_category, bc.brand_category, pt.product_category_id, pt.created_at, pt.updated_at FROM `product_total` pt JOIN product pc ON pc.product_category_id = pt.product_category_id JOIN brand bc ON pt.brand_category_id = bc.brand_category_id LIMIT %s, %s;", $perPage * ($page - 1), $perPage);

    $rows = $pdo->query($sql)->fetchAll();
}



?>



<?php require __DIR__ . "/parts/html-head.php" ?>


<?php require __DIR__ . "/parts/navbar.php" ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>

<div class="container w-75">


    <div class="container mb-5">
        <div class="row">
            <div class="col-4 d-flex justify-content-between">
                <a href="product-add.php" class="btn btn-outline-secondary me-4 " role="button">新增商品</a>
                <a class="btn btn-outline-secondary me-2" onclick="exPort(event)">匯出資料</a>
                <form action="product-product-change.php" method="post" class="col-5 d-flex justify-content-between" onchange="submit()">
                    <select class="form-select form-select-sm" name="product_change">
                        <option selected>所有商品</option>
                        <option value="1">手機</option>
                        <option value="2">平板</option>
                        <option value="3">耳機</option>
                    </select>
                </form>

            </div>

            <div class="col-4">
                <form action="product-brand-change.php" method="post" class="col-5 d-flex justify-content-between" onchange="submit()">
                    <select class="form-select form-select-sm" name="brand_change">
                        <option selected>所有品牌</option>
                        <option value="1">ASUS</option>
                        <option value="2">小米</option>
                        <option value="3">Google</option>
                        <option value="4">NOKIA</option>
                        <option value="5">Apple</option>
                        <option value="6">Motorola</option>
                        <option value="7">realme</option>
                        <option value="8">SAMSUNG</option>
                        <option value="9">OPPO</option>
                        <option value="10">Sony</option>
                        <option value="11">SUGAR</option>
                        <option value="12">Microsoft</option>
                        <option value="13">Lenovo</option>
                        <option value="14">AVITA</option>
                        <option value="15">TCL</option>
                        <option value="16">SuperPad</option>
                        <option value="17">ALLDOCUBE</option>
                        <option value="18">HUAWEI</option>
                        <option value="19">Benten</option>
                        <option value="20">Ergotech</option>
                        <option value="21">ARKO</option>
                        <option value="22">OPAD</option>
                        <option value="23">WIZ</option>
                        <option value="24">Dream</option>
                        <option value="25">IS</option>
                        <option value="26">soundcore</option>
                        <option value="27">Philips</option>
                        <option value="28">thecoopidea</option>
                        <option value="29">Libratone</option>
                        <option value="30">Beats</option>
                        <option value="31">audio-technica</option>
                        <option value="32">Monster</option>
                        <option value="33">Xround</option>
                    </select>
                </form>
            </div>
            <div class="col-3">
                <form class="d-flex" method="post" action="product-search.php">
                    <input class="form-control me-2" type="text" placeholder="請輸入商品名稱" name="product-search">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </form>
            </div>

        </div>


    </div>

    <div class="container">
        <table class="table table-striped ">
            <thead>
                <tr class="fw-light">
                    <th scope="col" style="color:#4a493b"><i class="fa-solid fa-pen-to-square" style="color:#4a493b"></i>
                    </th>
                    <th scope="col" style="color:#4a493b">商品編號</th>
                    <th scope="col" style="color:#4a493b">商品分類</th>
                    <th scope="col" style="color:#4a493b">商品名稱</th>
                    <th scope="col" style="color:#4a493b">商品價格</th>
                    <th scope="col" style="color:#4a493b">商品圖</th>
                    <th scope="col" style="color:#4a493b">品牌分類</th>
                    <th scope="col" style="color:#4a493b">上架時間</th>
                    <th scope="col" style="color:#4a493b">更新時間</th>
                    <th scope="col" style="color:#4a493b"><i class="fa-solid fa-trash-can" style="color:#4a493b"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r) : ?>
                    <tr>
                        <td><a href="product-edit.php?product_id=<?= $r['product_id'] ?>"><i class="fa-solid fa-pen-to-square" style="color:#4a493b"></i></a></td>
                        <td><?= $r['product_id'] ?></td>
                        <td><?= $r['product_category_id'] ?></td>
                        <td><?= $r['product_name'] ?></td>
                        <td><?= $r['product_price'] ?></td>
                        <td><img class="product_img" style="width:100px;" src="./image/<?= $r['product_pic'] ?>"></td>
                        <td><?= $r['brand_category_id'] ?></td>
                        <td><?= $r['created_at'] ?></td>
                        <td><?= $r['updated_at'] ?></td>

                        <td><a href="javascript: delete_it(<?= $r['product_id'] ?>) "><i class="fa-solid fa-trash-can" style="color:#4a493b"></i></a></td>
                    </tr>
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
        $showpage = 8; //每次要顯示幾筆分頁
        $cut = floor($showpage / 2); //以目前所在頁次 為中心 往左右各顯示幾個頁次 以無條件捨去
        ?>



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
                                <a class="page-link" style="color: #4a493b;background-color:#f4f4f5;" href="?page=<?= $i ?>"><?= $i ?></a>
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

</div>


<?php require __DIR__ . "/parts/scripts.php" ?>
<script>
    const tr = document.querySelectorAll("tbody tr");
    // console.log(tr)
    const changeColor = [...tr];
    for (let i in changeColor) {
        if (i % 2 === 0) {
            changeColor[i].style = "background-color:#fff";
        }
    }

    function delete_it(product_id) {
        if (confirm(`是否要刪除編號為 ${product_id } 的資料?`)) {
            location.href = 'product-delete.php?product_id=' + product_id;
        }
    }

    const exPort = function(event) {
        event.preventDefault();
        location.href = `product_export_api.php`;
    }
</script>


<?php require __DIR__ . "/parts/html-foot.php" ?>