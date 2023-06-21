<?php require __DIR__ . '/parts/connect_db.php';

$pageName = 'login';
$title = '登入';

// 如果已經登入，跳轉到首頁
if (isset($_SESSION['admin'])) {
    header('Location: index_.php');
    exit;
}

?>


<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/css-style.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>


<div class="container w-75">
    <div class="row justify-content-center align-items-center" style="height:95vh;">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class=" card-title text-center">管理者登入</h5>
                    <form name="form1" onsubmit="checkForm(event)" novalidate>

                        <div class="mb-3">
                            <label for="account" class="form-label">帳號</label>
                            <input type="text" class="form-control" id="account" name="account" required>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">密碼</label>
                            <div class="position-relative">
                                <input type="password" class="form-control  " id="password" name="password" required>
                                <div id="seepass" class="col">
                                    <i id="seepass1" style="display: none;color:gray" class="fa-solid fa-eye"></i>
                                    <i id="seepass2" style="display: inline;color:gray" class="fa-solid fa-eye-slash"></i>
                                </div>
                                <div class="form-text"></div>
                            </div>
                        </div>
                        <div id="formAlert" class="alert alert-info" style="display:none;"></div>
                        <div class="text-end mt-4"> <button type="submit" class="btn btn-rgst">登入</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
    //alert
    const formAlert = document.querySelector('#formAlert');
    const showAlert = function(msg = '登入失敗', type = 'INFO') {
        formAlert.innerHTML = msg;
        formAlert.className = `alert alert-${type}`;
        formAlert.style.display = 'block';
    };

    //form-text
    const form_text = document.querySelectorAll(".form-text");

    //seepass
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

    //驗證帳密
    const checkForm = function(event) {
        let p2 = document.form1.password2;
        event.preventDefault();
        // 欄位外觀回復原來的樣子
        document.form1.querySelectorAll(`input`).forEach(el => {
            el.style.border = '1px solid #ced4da';
            form_text[0].innerHTML = '';
            form_text[1].innerHTML = '';
        })


        // TODO: 欄位檢查

        let isPass = true;

        let field = document.form1.account;
        if (field.value.length > 3) {
            isPass = true;
        } else {
            isPass = false;
            field.style.border = '2px solid red';
            form_text[0].innerHTML = '請輸入帳號';
        }

        field = document.form1.password;
        if (field.value.length > 0) {
            isPass = true;
        } else {
            isPass = false;
            field.style.border = '2px solid red';
            form_text[1].innerHTML = '請輸入密碼';
        }



        if (isPass) {
            const fd = new FormData(document.form1);

            fetch('login-api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json()).then(obj => {
                console.log(obj);

                if (obj.success) {
                    showAlert('登入成功!', 'SUCC');
                    setTimeout("location.href='index.php'", 1300);
                } else {
                    showAlert(obj.msg);
                }

            })
        }
    }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>