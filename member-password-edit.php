<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';
$title = "修改會員密碼";
$nowpage = "member-password-edit";


?>

<?php

$member_id = isset($_GET['member_id']) ? intval($_GET['member_id']) : 0;
if (empty($member_id)) {
    header('Location: member-list.php');
    exit;
}



?>








<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>


<div class="container w-75">>
    <div style="height: 5vh"></div>
    <div class="row justify-content-center my-3">
        <div class="col-6">
            <form name="form1" style="border:1px solid gray;background-color:#c6bbac" class="px-5 py-4  rounded " onsubmit="checkForm(event)">


                <div class="mb-3">
                    <div class="">原密碼
                        <span style="color: lightcoral;font-size: 10px;;">&nbsp;&nbsp;*必填</span>
                    </div>
                    <div class="   position-relative">
                        <input class="form-control me-2" type="text" name="member_id" id="member_id" value="<?= $_GET['member_id'] ?>" style="display:none">
                        <input class="form-control me-2" type="password" name="old_password" id="old_password">

                        <div class="form-text"></div>

                    </div>


                    <div class="mb-3">
                        <div class="">新密碼
                            <span style="color: lightcoral;font-size: 10px;;">&nbsp;&nbsp;*必填</span>
                        </div>
                        <div class="   position-relative">
                            <input class="form-control me-2" type="password" name="password" id="password">
                            <div id="seepass">
                                <i id="seepass1" style="display: none;color:gray" class="fa-solid fa-eye"></i>
                                <i id="seepass2" style="display: inline;color:gray" class="fa-solid fa-eye-slash"></i>
                            </div>
                            <div class="form-text"></div>

                        </div>
                        <div class=" ">再次輸入密碼
                        </div>
                        <div class="  ">
                            <input class="form-control me-2" type="password" name="password2" id="password2">
                            <div class="form-text"></div>
                        </div>
                    </div>






                    <div id="formAlert" class="alert alert-info" style="display: none"></div>
                    <div class="box">
                        <button type="submit" class="btn btn-rgst">儲存</button>
                        <a href="member-list.php" class="btn btn-canc me-4 " role="button"> 取消</a>
                    </div>
            </form>
        </div>
    </div>


</div>











<?php include __DIR__ . '/parts/scripts.php'; ?>

<script>
    const formAlert = document.querySelector('#formAlert');
    //密碼驗證:含1個大寫字母1個小寫字母1個數字,長度6-12位
    var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,12}$/;


    const showAlert = function(msg = '新增失敗', type = 'INFO') {
        formAlert.innerHTML = msg;
        formAlert.className = `alert alert-${type}`;
        formAlert.style.display = 'block';
    };
    const hideAlert = () => {
        formAlert.style.display = 'none';
    };

    const form_text = document.querySelectorAll(".form-text");

    document.getElementById("seepass").onmousedown = function() {
        document.getElementById("password").type = "text";
        seepass1.style.display = "inline";
        seepass2.style.display = "none";
    }
    document.getElementById("seepass").onmouseup = function() {
        document.getElementById("password").type = "password";
        seepass1.style.display = "none";
        seepass2.style.display = "inline";

    }






    const checkForm = function(event) {
        let p2 = document.form1.password2;
        event.preventDefault();
        // 欄位外觀回復原來的樣子
        document.form1.querySelectorAll(`input`).forEach(el => {
            el.style.border = '1px solid #ced4da';
            form_text[0].innerHTML = '';
            form_text[1].innerHTML = '';
            form_text[2].innerHTML = '';
        })
        p2.style.border = '1px solid #ced4da';

        // TODO: 欄位檢查


        let isPass = true;

        let field = document.form1.old_password;
        if (field.value.length > 0) {
            isPass = true;
        } else {
            isPass = false;
            field.style.border = '2px solid red';
            form_text[0].innerHTML = '請輸入舊密碼';
        }

        field = document.form1.password;
        if (field.value.match(passw)) {
            isPass = true;
            if (field.value === p2.value) {
                isPass = true;
            } else {
                isPass = false;
                p2.style.border = '2px solid red';
                form_text[2].innerHTML = '兩次密碼輸入不同';
            }
        } else {
            isPass = false;
            field.style.border = '2px solid red';
            form_text[1].innerHTML = '請設定至少含1個大寫字母及1個小寫字母1個數字,長度6-12位的密碼';
        }









        if (isPass) {
            const fd = new FormData(document.form1);

            fetch('member-password-edit-api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json()).then(obj => {
                console.log(obj);

                if (obj.success) {
                    showAlert('修改成功!', 'SUCC');
                    setTimeout("location.href='member-detail.php?member_id=<?= $member_id ?>'", 1300);
                } else {

                    showAlert(obj.error, 'INFO');
                }

            })
        }
    }
</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>