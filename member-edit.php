<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';

$title = "修改會員資料";
$nowpage = "member-edit";
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

<?php
//地址
$sql_city = sprintf("SELECT `ct_name`FROM `address_list` WHERE `parent_sid`=0 ");

$stmt_city = $pdo->prepare($sql_city);
$stmt_city->execute();
$rows_city = $stmt_city->fetchAll();

$city = array_column($rows_city, 'ct_name', 'ct_sid');
$city_num = count($city);



$sql_dist = sprintf("SELECT `ct_name`,`parent_sid`FROM `address_list` WHERE `parent_sid`!=0 ");

$stmt_dist = $pdo->prepare($sql_dist);
$stmt_dist->execute();
$dist = $stmt_dist->fetchAll(PDO::FETCH_ASSOC);


?>



<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>

<div class="container w-75">
    <div style="height: 5vh"></div>
    <div class="buttoncont my-3">
        <div class="d-flex flex-row justify-content-end mb-2">

            <a onclick="delet(event)" class="btn btn-delete me-4 " role="button"><i class="fa-solid fa-trash-can"></i>
                刪除會員</a>



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
                    <input class="form-control me-2" type="text" value="<?= $r['member_name'] ?>" name="name" id="name">
                    <div class="form-text"></div>
                </div>
            </div>

            <div class="row w-100">
                <div class="theader col-3">email</div>
                <div class=" tbb col-9 ">
                    <input class="form-control me-2" type="text" value="<?= $r['email'] ?>" name="email" id="email">
                    <div class="form-text"></div>
                </div>
            </div>

            <div class="row w-100">
                <div class="theader col-3">會員密碼</div>
                <div class=" tbb col-9 ">
                    <a class="form-control me-2 text-decoration-none" type="button" value="修改" style="color:#c2686d;" href="member-password-edit.php?member_id=<?= $r['member_id'] ?>">修改密碼</a>
                </div>
            </div>

            <div class="row w-100">
                <div class="theader col-3">電話</div>
                <div class=" tbb col-9 ">
                    <input class="form-control me-2" type="text" value="<?= $r['mobile'] ?>" name="mobile" id="mobile">
                    <div class="form-text"></div>
                </div>
            </div>



            <div class="row w-100">
                <div class="theader col-3">會員性別</div>
                <div class=" tbb col-9 ">
                    <div class="input-group">
                        <input class="form-control me-2" type="text" value="<?= $r['gender'] === "female" ? "女" : "男" ?>" readonly>
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" value="male" name="gender" <?= $r['gender'] === "male" ? "checked" : "" ?> /> <label for="male">&nbsp;男</label>
                        </div>
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" value="female" name="gender" <?= $r['gender'] === "female" ? "checked" : "" ?> /><label for="female">&nbsp;女</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row w-100">
                <div class="theader col-3">生日</div>
                <div class=" tbb col-9 ">
                    <input class="form-control me-2" type="date" value="<?= $r['birthday'] ?>" name="birthday" id="birthday">
                    <div class="form-text"></div>
                </div>
            </div>



            <div class="row w-100">
                <div class="theader col-3">地址</div>
                <div class=" tbb col-9 ">
                    <select class="form-select" name="city" id="city-list" onchange="citychange(this.selectedIndex)">
                    </select>
                    <select class="form-select" name="dist" id="dist-list"></select>

                    <input class="form-control me-2" type="text" value="<?= $r['address_rd'] ?>" name="rd">
                </div>
            </div>



            <div class="row w-100">
                <div class="theader col-3">會員資格</div>
                <div class=" tbb col-9 ">

                    <select class="form-select" name="level" id="level" placeholder="">
                        <option value="1" style="color:goldenrod" <?= ($r['member_level_id'] == 1) ? "selected" : "" ?>>
                            金會員
                        </option>
                        <option value="2" style="color:LightSlateGray" <?= ($r['member_level_id'] == 2) ? "selected" : "" ?>>
                            銀會員</option>
                        <option value="3" <?= ($r['member_level_id'] == 3) ? "selected" : "" ?>>一般會員</option>
                        <option value="5" style="color:red" <?= ($r['member_level_id'] == 5) ? "selected" : "" ?>>無法使用
                        </option>


                    </select>
                </div>
            </div>

            <div class="row w-100">
                <div class="theader col-3">帳號修改日期</div>
                <div class="tbb col-9"><input class="form-control me-2" type="text" value="<?= $r['last_edit_date'] ?>" readonly></div>
            </div>




            <div id="formAlert" class="alert alert-info" style="display: none"></div>


            <div class="box">
                <button type="submit" class="btn btn-che">儲存</button>
                <a href="member-list.php" class="btn btn-canc me-4 " role="button"> 取消</a>
            </div>
        </form>

    </div>


</div>










<?php include __DIR__ . '/parts/scripts.php'; ?>

<script>
    const formAlert = document.querySelector('#formAlert');

    const fields = ['name', 'email'];

    const rowData = <?= json_encode($r, JSON_UNESCAPED_UNICODE) ?>;

    const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;
    const email_re =
        /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zAZ]{2,}))$/;

    const showAlert = function(msg = '無更改資料', type = 'INFO') {
        formAlert.innerHTML = msg;
        formAlert.className = `alert alert-${type}`;
        formAlert.style.display = 'block';
    };
    const hideAlert = () => {
        formAlert.style.display = 'none';
    };

    const form_text = document.querySelectorAll(".form-text");


    const delet = function(event) {
        if (confirm("確認要刪除編號: <?= $r['member_id'] ?> 姓名:「<?= $r['member_name'] ?>」會員嗎?")) {
            location.href = 'member-delete-api.php?member_id=<?= $r['member_id'] ?>';
        }
    }



    //地址選單
    const citysele = document.querySelector("#city-list");
    const distsele = document.querySelector("#dist-list");

    const city = <?= json_encode($city) ?>;
    const dist = <?= json_encode($dist) ?>
    //都市選擇
    let cityinner = "";
    for (let i = 0; i < city.length; i++) {
        cityinner = cityinner + '<option value=' + city[i] + '>' + city[i] + '</option>';
    }
    citysele.innerHTML = `<option value="<?= $r['address_city'] ?>" selected hidden><?= $r['address_city'] ?></option>` +
        cityinner;

    //鄉鎮區選擇
    function citychange(ind) {
        let distinner = "";
        let dist2 = dist.filter((el) => el.parent_sid == (ind));

        for (let i = 0; i < dist2.length; i++) {
            distinner = distinner + '<option value=' + dist2[i].ct_name + '>' + dist2[i].ct_name + '</option>'
        };
        distsele.innerHTML =
            `<option value="<?= $r['address_dist'] ?>" selected hidden><?= $r['address_dist'] ?></option>` +
            distinner;
    }

    citychange(document.getElementById("city-list").selectedIndex);
    // 這裡呼叫一次"typechange"這方法，讓瀏覽器在讀完XML後可以直接讓系所的資料出來





    //表單送出
    const checkForm = function(event) {

        event.preventDefault();
        // 欄位外觀回復原來的樣子
        document.form1.querySelectorAll(`input`).forEach(el => {
            el.style.border = '1px solid #ced4da';
            form_text[0].innerHTML = '';
            form_text[1].innerHTML = '';
            form_text[2].innerHTML = '';

        })
        // TODO: 欄位檢查

        let isPass = true;

        let field = document.form1.name;
        if (field.value.length < 2) {
            isPass = false;
            field.style.border = '2px solid red';
            form_text[0].innerHTML = '請輸入正確姓名';
        }
        field = document.form1.email;
        if (!email_re.test(field.value)) {
            isPass = false;
            field.style.border = '2px solid red';
            form_text[1].innerHTML = '請輸入正確email';
        }
        field = document.form1.mobile;
        if (!mobile_re.test(field.value)) {
            isPass = false;
            field.style.border = '2px solid red';
            form_text[2].innerHTML = '請輸入正確手機號碼';
        }



        if (isPass) {
            const fd = new FormData(document.form1);
            if (confirm("確認更新編號: <?= $r['member_id'] ?> 姓名:「<?= $r['member_name'] ?>」會員嗎?")) {


                fetch('member-edit-api.php', {
                    method: 'POST',
                    body: fd,
                }).then(r => r.json()).then(obj => {
                    console.log(obj);

                    if (obj.success) {

                        showAlert('修改成功!', 'succ');
                    } else {
                        for (let id in obj.errors) {
                            const field = document.querySelector(`#${id}`);
                            field.style.border = '2px solid red';
                            field.nextElementSibling.innerHTML = obj.error[id];
                        }
                        if (obj.msg) {
                            showAlert(obj.msg);
                        }

                    }
                })
            }
        }
    }
</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>