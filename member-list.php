<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';
$title = "會員管理頁";
$pageSid = "6";


?>

<?php

$perPage = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}
$t_sql = "SELECT COUNT(1) FROM `members`";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

$totalPage = ceil($totalRows / $perPage);
$showpage = 3; //每次要顯示幾筆分頁
$cut = floor($showpage / 2); //以目前所在頁次 為中心 往左右各顯示幾個頁次 以無條件捨去

$all = [];
$sqlall = sprintf("SELECT * FROM `members`");
$all = $pdo->query($sqlall)->fetchAll();


$rows = [];
if ($totalPage > 0) {
    if ($page > $totalPage) {
        header('Location: ?page' . $totalPage);
        exit;
    }
    $sql = sprintf("SELECT * FROM `members`m
    JOIN member_level l ON 
    m.member_level_id = l.id
    ORDER BY `member_id`
    DESC LIMIT %s,%s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll();
}

?>

<?php
//地址
$sql_city = sprintf("SELECT `ct_name`FROM `address_list` WHERE `parent_sid`=0 ");

$stmt_city = $pdo->prepare($sql_city);
$stmt_city->execute();
$rows_city = $stmt_city->fetchAll();

$city = array_column($rows_city, 'ct_name', 'ct_sid');
$city_num = count($city);
?>


<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/css-style.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>

<div class="container w-75">
    <div class="buttoncont">
        <div class="row justify-content-start my-1">
            <div class="">
                <a href="member-add.php" class="btn btn-outline-secondary btn-detail me-4 " role=" button">新增會員</a>
            </div>
        </div>
    </div>
    <div class="export_box ">
        <div class="w-100 d-flex justify-content-end mb-3">
            <form class="d-flex w-50" role="search" onsubmit="exPort(event)">
                <select name="export_s_id" id="export_s_id" class="form-select form-select-sm me-2">
                    <option value="none" selected disabled hidden>自幾號</option>
                    <?php foreach ($all as $a) : ?>

                        <option value="<?= $a['member_id'] ?>"><?= $a['member_id'] ?></option>
                    <?php endforeach; ?>

                </select>

                <select name="export_e_id" id="export_e_id" class="form-select form-select-sm me-2">
                    <option value="none" selected>全筆</option>
                    <?php foreach ($all as $a) : ?>
                        <option value="<?= $a['member_id'] ?>"><?= $a['member_id'] ?></option>
                    <?php endforeach; ?>

                </select>





                <button class="btn btn-outline-secondary" type="submit" style="white-space: nowrap;">匯出資料</button>
            </form>




        </div>

        <div class="col-3">

        </div>

        <div class="serch_box">
            <div class="w-100 d-flex justify-content-end">
                <form name="src" class="d-flex" role="search" onsubmit="Serch(event)">

                    <input class="form-control me-2" type="search" placeholder="搜尋ID" name="src_id" id="src_id">

                    <input class="form-control me-2" type="search" placeholder="搜尋會員姓名" name="src_name" id="src_name">

                    <? /*性別*/ ?>
                    <select class="form-select form-select me-2" type="search" placeholder="會員性別" name="src_gen" id="src_gen">
                        <option value="" selected>性別</option>

                        <option value="female">女</option>
                        <option value="male">男</option>
                    </select>

                    <? /*縣市*/ ?>

                    <select class="form-select me-2" name="src_city" id="src_city"> </select>


                    <? /*查詢btn*/ ?>

                    <button class="btn btn-outline-secondary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>




            </div>

        </div>
    </div>











    <div class="container">
        <div class="list_cont">
            <table class="table table-striped">

                <thead>
                    <tr class="thead">
                        <td scope="col" style="color:#4a493b"><i class="fa-solid fa-pen-to-square" style="color:#4a493b"></i></td>

                        <td>會員編號</td>
                        <td>姓名</td>
                        <td>Email</td>
                        <td>性別</td>
                        <td>電話</td>
                        <td>會員資格</td>

                        <td scope="col" style="color:#4a493b">
                            詳細資料</td>

                    </tr>


                </thead>

                <tbody>
                    <?php foreach ($rows as $r) : ?>


                        <tr style="color: <?= $r['member_level_id'] === 5 ? "red" : '#4a493b' ?>;">
                            <td style="color:#4a493b"><a href="member-edit.php?member_id=<?= $r['member_id'] ?>">
                                    <i class="fa-solid fa-pen-to-square" style="color:#4a493b"></i></a></td>

                            <td><?= $r['member_id'] ?></td>
                            <td><?= $r['member_name'] ?></td>
                            <td><?= $r['email'] ?></td>
                            <td><?= $r['gender'] === "female" ? "女" : "男" ?></td>
                            <td><?= $r['mobile'] ?></td>
                            <td style="color:<?php
                                                if ($r['member_level_id'] == 1) {
                                                    echo "goldenrod";
                                                } elseif ($r['member_level_id'] == 2) {
                                                    echo "LightSlateGray";
                                                } elseif ($r['member_level_id'] == 3) {
                                                    echo "navy";
                                                } elseif ($r['member_level_id'] == 5) {
                                                    echo "red";
                                                } ?>">
                                <?= $r['name'] ?>
                            </td>

                            <td style="color:#4a493b">
                                <a href="member-detail.php?member_id=<?= $r['member_id'] ?>" class="btn"> <i class="fa-solid fa-layer-group"></i></a>
                            </td>
                        </tr>


                    <?php endforeach; ?>
                </tbody>




            </table>




            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <nav>
                        <ul class="pagination">

                            <li class="<?= $page == 1 ? 'disabled' : '' ?>  me-1">
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








                            <li class="<?= $page == $totalPage ? 'disabled' : '' ?> me-1">
                                <a class="page-link" style="color: #4a493b;" href="?page=<?= $page + 1 ?>">下一頁</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

    </div>










    <?php include __DIR__ . '/parts/scripts.php' ?>

    <script>
        const tr = document.querySelectorAll("tbody tr");
        const changeColor = [...tr];
        for (let i in changeColor) {
            if (i % 2 === 0) {
                changeColor[i].style = "background-color:#fff";
            }
        };
        //縣市選單
        const citysele = document.querySelector("#src_city");

        const city = <?= json_encode($city) ?>;
        //都市選擇
        let cityinner = "";
        for (let i = 0; i < city.length; i++) {
            cityinner = cityinner + '<option value=' + city[i] + '>' + city[i] + '</option>';
        }
        citysele.innerHTML = `<option value="" selected hidden>縣市</option>` + cityinner;


        const exPort = function(event) {
            event.preventDefault();
            const sid = (document.querySelector('#export_s_id').value);
            const eid = (document.querySelector('#export_e_id').value);
            location.href = `member_export_api.php?export_s_id=${sid}&export_e_id=${eid}`
        }



        const Serch = function(event) {
            event.preventDefault();
            const id = (document.querySelector('#src_id').value);
            const name = (document.querySelector('#src_name').value);
            const gender = (document.querySelector('#src_gen').value);
            const citys = citysele.value;


            location.href = `member-src-list.php?id=${id}&name=${name}&gender=${gender}&city=${citys}`;
        }
    </script>
    <?php include __DIR__ . '/parts/html-foot.php'; ?>