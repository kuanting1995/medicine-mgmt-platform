<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin_required.php';

//頁面名稱
$pageName = "brand";

//網站標題
$title = "商品管理";

//每頁顯示幾個
$perPage = 15;



//用戶點選page 傳送query string
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;


$brandchange = isset($_POST['brand_change']) ? intval($_POST['brand_change']) : "33";

//page不能低於1 低於1直接跳轉
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}

//總共有幾筆資料
$t_sql = "SELECT count(1) FROM `product_total` WHERE brand_category_id	 = {$brandchange}";


//總共有幾欄
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

//總共有幾頁 
$totalPages = ceil($totalRows / $perPage);

if ($page > $totalPages) {
    header("Location: ?page={$totalPages}");
    exit;
}




//資料
$rows = [];

if ($totalRows > 0) {

    if ($page > $totalPages) {
        header('Location: ?page' . $totalPages);
        exit;
    }
    //要顯示的欄位 
    $sql = sprintf("SELECT pt.product_id, pt.product_name, pt.product_price, pt.product_pic, pt.brand_category_id, pc.product_category, bc.brand_category, pt.product_category_id, pt.created_at, pt.updated_at FROM `product_total` pt JOIN product pc ON pc.product_category_id = pt.product_category_id JOIN brand bc ON pt.brand_category_id = bc.brand_category_id WHERE pt.brand_category_id	 = {$brandchange} LIMIT %s, %s;", $perPage * ($page - 1), $perPage);



    $rows = $pdo->query($sql)->fetchAll();
}




?>



<?php require __DIR__ . "/parts/html-head.php" ?>



<?php require __DIR__ . "/parts/navbar.php" ?>




<div class="container mb-5">
    <div class="row justify-content-center mb-5">
        <div class="col-4">
            <h2 class="text-center"><a style="color:#4a493b;text-decoration:none">商品品牌管理頁</a></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-4 d-flex justify-content-between">
            <a href="product-add.php" class="btn btn-outline-secondary me-4 " role="button">新增商品</a>
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


    </div>


</div>

<div class="container">



    <table class="table table-striped ">
        <thead>
            <tr class="fw-light">
                <th scope="col" style="color:#4a493b"><i class="fa-solid fa-pen-to-square" style="color:#4a493b"></i></th>
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


    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <nav>
                    <ul class="pagination">
                        <li class="page-item me-1">
                            <a class="page-link" style="color: #4a493b;" href="?page=<?= $page - 1 ?>">上一頁</a>
                        </li>

                        <!-- 迴圈頁面 -->
                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>

                            <!--  頁面跳轉-->
                            <li class=" page-item <?= $page == $i ? 'active' : '' ?> me-2">
                                <a class="page-link" style="color: #4a493b;background-color:#f4f4f5;" href="?page=<?= $i ?> "><?= $i ?></a>
                            </li>
                        <?php
                        endfor; ?>

                        <li class="page-item me-1 <? $page == $totalPages ? 'disable' : '' ?>">
                            <a class="page-link" style="color: #4a493b;" href="?page=<?= $page + 1 ?>">下一頁</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
</div>


<?php require __DIR__ . "/parts/script.php" ?>
<script>
    const tr = document.querySelectorAll("tbody tr");

    const changeColor = [...tr];
    for (let i in changeColor) {
        if (i % 2 === 0) {
            changeColor[i].style = "background-color:#fffacd";
        }
    }

    // const del = document.querySelectorAll('.del');

    // [...del].map(el => el.addEventListener('click', e =>
    //     // e.currentTarget.closest('tr')
    // e.currentTarget.closest('tr').remove()));



    function delete_it(product_id) {
        if (confirm(`是否要刪除編號為 ${product_id } 的資料?`)) {
            location.href = 'product-delete.php?product_id=' + product_id;
        }
    }
</script>


<?php require __DIR__ . "/parts/html-foot.php" ?>