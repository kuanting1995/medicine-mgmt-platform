<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';

$title = "會員詳細資料";
$nowpage = "member-detail";
?>

<?php

$member_id = isset($_GET['member_id']) ? intval($_GET['member_id']) : 0;
if (empty($member_id)) {
    header('Location: member-list.php');
    exit;
}

$sql = "SELECT * FROM `members` WHERE `member_id` = $member_id";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Location: member-list.php');
    exit;
}

?>

<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>



<div class="container w-75">
    <div style="height: 5vh"></div>
    <div class="buttoncont my-3">
        <div class="d-flex flex-row justify-content-end mb-2">
            <a href="member-list.php" class="btn btn-outline-secondary me-auto" role="button">返回</a>
            <a class="btn btn-detail me-4 " href="member-edit.php?member_id=<?= $r['member_id'] ?>">
                <i class="fa-solid fa-pen-to-square"></i>修改資料</a>

            <a href="member-export-one-api.php?id=<?= $r['member_id'] ?>" class="btn btn-outline-secondary me-4" role="button">匯出單筆資料</a>


        </div>

    </div>


</div>











<div class="container">
    <div class="memberList mb-3">
        <form name="form1" class="form1" onsubmit="checkForm(event)">

            <div class="row w-100">
                <div class="theader col-3">會員編號</div>
                <div class="tbb col-9"><input class="form-control me-2" type="text" value="<?= $r['member_id'] ?>" name="member_id" id="member_id" readonly></div>
            </div>

            <div class="row w-100">
                <div class="theader col-3">姓名</div>
                <div class=" tbb col-9 ">
                    <input class="form-control me-2" type="text" value="<?= $r['member_name'] ?>" name="name" id="name" readonly>
                    <div class="form-text"></div>
                </div>
            </div>

            <div class="row w-100">
                <div class="theader col-3">email</div>
                <div class=" tbb col-9 ">
                    <input class="form-control me-2" type="text" value="<?= $r['email'] ?>" name="email" id="email" readonly>
                    <div class="form-text"></div>
                </div>
            </div>



            <div class="row w-100">
                <div class="theader col-3">電話</div>
                <div class=" tbb col-9 ">
                    <input class="form-control me-2" type="text" value="<?= $r['mobile'] ?>" name="mobile" id="mobile" readonly>
                    <div class="form-text"></div>
                </div>
            </div>



            <div class="row w-100">
                <div class="theader col-3">會員性別</div>
                <div class=" tbb col-9 ">
                    <div class="input-group">
                        <input class="form-control me-2" type="text" value="<?= $r['gender'] === "female" ? "女" : "男" ?>" readonly>


                    </div>
                </div>
            </div>

            <div class="row w-100">
                <div class="theader col-3">生日</div>
                <div class=" tbb col-9 ">
                    <input class="form-control me-2" type="date" value="<?= $r['birthday'] ?>" name="birthday" id="birthday" readonly>
                    <div class="form-text"></div>
                </div>
            </div>



            <div class="row w-100">
                <div class="theader col-3">地址</div>
                <div class=" tbb col-9 ">
                    <input class="form-control me-2" name="city" id="city-list" value="<?= $r['address_city'] ?>" readonly>
                    <input class="form-control me-2" name="dist" id="dist-list" value="<?= $r['address_dist'] ?>" readonly>

                    <input class="form-control me-2" type="text" value="<?= $r['address_rd'] ?>" name="rd" readonly>
                </div>
            </div>



            <div class="row w-100">
                <div class="theader col-3">會員資格</div>
                <div class=" tbb col-9 ">
                    <?php if ($r["member_level_id"] == 1) {
                        $level = "金會員";
                    } elseif ($r["member_level_id"] == 2) {
                        $level = "銀會員";
                    } elseif ($r["member_level_id"] == 3) {
                        $level = "一般會員";
                    } elseif ($r["member_level_id"] == 5) {
                        $level = "停權會員";
                    } ?>
                    <input class="form-control me-2" type="text" id="level" value="<?= $level ?>">

                </div>
            </div>

            <div class="row w-100">
                <div class="theader col-3">帳號修改日期</div>
                <div class="tbb col-9"><input class="form-control me-2" type="text" value="<?= $r['last_edit_date'] ?>" readonly></div>
            </div>



        </form>

    </div>

    <div class="d-flex flex-row justify-content-around">
        <div class=" me-2"><a href="member-his-order.php?member_id=<?= $member_id ?>" class="me-2"><button class="btn bg-bb">歷史訂單</button></a></div>
        <div class=""><a href="member-his-comment.php?member_id=<?= $member_id ?>"><button class="btn bg-bb">歷史評論</button></a></div>
    </div>

</div>



<?php include __DIR__ . '/parts/scripts.php'; ?>

<script>

</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>