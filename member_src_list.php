<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';

$title = "會員搜尋結果";
$nowpage = "member_src_list";


?>

<?php



$id = $_GET['id'];
$name = $_GET['name'];
$city = $_GET['city'];
$gender = $_GET['gender'];


$id = empty($id) ? "" : "`member_id` LIKE '%" . $id . "%'";
$name = empty($name) ? "" : "`member_name` LIKE '%" . $name . "%'";
$city = empty($city) ? "" : "`address_city`='$city'";
$gender = empty($gender) ? "" : "`gender`='$gender'";

$and1 = (!empty($id) and !empty($name)) ? "AND" : "";
$and2 = (!empty($id) and empty($name) and !empty($city)) ? "AND" : "";
$and3 = (!empty($id) and empty($name) and empty($city) and !empty($gender)) ? "AND" : "";

$and4 = (!empty($name) and !empty($city)) ? "AND" : "";
$and5 = (!empty($name) and empty($city) and !empty($gender)) ? "AND" : "";

$and6 = (!empty($city) and !empty($gender)) ? "AND" : "";


if (!empty($id) || !empty($name) || !empty($city) || !empty($gender)) {
    $where = "WHERE";
};

$rows = [];

$sql =  "SELECT * FROM `members`m 
JOIN member_level l ON 
m.member_level_id = l.id
$where $id $and1 $and2 $and3  $name $and4 $and5 $city $and6 $gender
";



$rows = $pdo->query($sql)->fetchAll();


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








<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>


<div class="row justify-content-center mb-5">
    <div class="col-4">
        <h2 class="text-center">會員搜尋結果:</h2>
    </div>
</div>

<div class="container mb-5">




    <div class="buttoncont">
        <div class="row justify-content-start mb-2">
            <div class="">
                <a href="member_list.php" class="btn btn-outline-secondary me-auto" role="button">返回</a>
                <a href="member_add.php" class="btn btn-detail me-4 " role="button">新增會員</a>


            </div>
        </div>
    </div>
    <div class="export_box ">
        <div class="w-100 d-flex justify-content-end mb-3">
            <form class="d-flex " role="search" onsubmit="exPort(event)">



                <button class="btn btn-outline-secondary" type="submit" style="white-space: nowrap;">匯出資料</button>
            </form>




        </div>

        <div class="col-3">

        </div>

        <div class="serch_box">
            <div class="w-100 d-flex justify-content-end">
                <form name="src" class="d-flex" role="search" onsubmit="Serch(event)">

                    <input class="form-control me-2" type="search" placeholder="ID" name="src_id" id="src_id">

                    <input class="form-control me-2" type="search" placeholder="會員姓名" name="src_name" id="src_name">
                    <select class="form-select form-select me-2" type="search" placeholder="會員性別" name="src_gen"
                        id="src_gen">
                        <option value="" selected>性別</option>

                        <option value="female">女</option>
                        <option value="male">男</option>
                    </select>

                    <select class="form-select me-2" name="src_city" id="src_city"> </select>





                    <button class="btn btn-outline-secondary" type="submit"><i
                            class="fa-solid fa-magnifying-glass"></i></button>
                </form>




            </div>

            <div class="col-3">

            </div>




        </div>
    </div>











    <div class="container">
        <div class="list_cont">
            <table class="table table-striped">

                <thead>
                    <tr class="thead">
                        <td scope="col" style="color:#4a493b"><i class="fa-solid fa-pen-to-square"
                                style="color:#4a493b"></i></td>

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
                        <td style="color:#4a493b"><a href="member_edit.php?member_id=<?= $r['member_id'] ?>">
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
                                                    echo "";
                                                } elseif ($r['member_level_id'] == 5) {
                                                    echo "red";
                                                } ?>">
                            <?= $r['name'] ?>
                        </td>

                        <td style="color:#4a493b">
                            <a href="member_detail.php?member_id=<?= $r['member_id'] ?>" class="btn"> <i
                                    class="fa-solid fa-layer-group"></i></a>
                        </td>
                    </tr>


                    <?php endforeach; ?>
                </tbody>




            </table>




        </div>
    </div>










    <?php include __DIR__ . '/parts/scripts.php'; ?>

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

    let expid = "";
    <?php foreach ($rows as $r) : ?>
    expid = "`member_id`=" + <?= $r['member_id'] ?> + " OR " + expid
    <?php endforeach; ?>

    const exPort = function(event) {
        event.preventDefault();

        location.href = `member-export-api.php?src_id=${expid}}`
    }



    const Serch = function(event) {
        event.preventDefault();
        const id = (document.querySelector('#src_id').value);
        const name = (document.querySelector('#src_name').value);
        const gender = (document.querySelector('#src_gen').value);
        const citys = citysele.value;


        location.href = `member_src_list.php?id=${id}&name=${name}&gender=${gender}&city=${citys}`;
    }
    </script>
    <?php include __DIR__ . '/parts/html-foot.php'; ?>