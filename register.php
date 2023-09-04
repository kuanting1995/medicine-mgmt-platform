<?php require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';

$pageName = 'register';
$title = '管理員註冊';

?>

<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/css-style.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<?php include __DIR__ . '/parts/sidebars.php' ?>


<div class="container w-75">
    <div class="row justify-content-center align-items-center" style="height:95vh;">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class=" card-title text-center">管理員註冊</h5>
                    <form name="form1" onsubmit=" checkForm(event)">
                        <div class="mb-3">
                            <div class="">帳號
                                <span style="color: lightcoral;font-size: 10px;;">&nbsp;&nbsp;*必填</span>
                            </div>
                            <div class=" ">
                                <input class="form-control me-2" type="text" name="account" id="account">
                                <div class="form-text"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="">密碼
                                <span style="color: lightcoral;font-size: 10px;;">&nbsp;&nbsp;*必填</span>
                            </div>
                            <div class="   position-relative">
                                <input class="form-control me-2" type="password" name="password" id="password">
                                <div id="seepass">
                                    <i id="seepass1" style="display: none;color:gray" class="fa-solid fa-eye"></i>
                                    <i id="seepass2" style="display: inline;color:gray"
                                        class="fa-solid fa-eye-slash"></i>
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

                        <div class="mb-3">
                            <div class="">員工認證碼
                                <span style="color: lightcoral;font-size: 10px;;">&nbsp;&nbsp;*必填</span>
                            </div>
                            <div class=" ">
                                <input class="form-control me-2" type="text" name="employeeID" id="employeeID">
                                <div class="form-text"></div>
                            </div>
                        </div>




                        <div id="formAlert" class="alert alert-info" style="display: none"></div>
                        <div class="box text-end mt-4">
                            <a href="index.php" class="btn btn-canc" role="button"> 取消</a>
                            <button type="submit" class="btn btn-rgst">儲存</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>

<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
const formAlert = document.querySelector('#formAlert');


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
        form_text[3].innerHTML = '';
    })
    p2.style.border = '1px solid #ced4da';

    // TODO: 欄位檢查

    let isPass = true;

    let field = document.form1.account;
    if (field.value.length > 3) {
        isPass = true;
    } else {
        isPass = false;
        field.style.border = '2px solid red';
        form_text[0].innerHTML = '請設定帳號';
    }

    field = document.form1.password;
    if (field.value.length > 0) {
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
        form_text[1].innerHTML = '請設定密碼';
    }
    field = document.form1.employeeID;
    if (field.value.length > 0) {
        if (field.value === "000") {
            isPass = true;
        } else {
            isPass = false;
            field.style.border = '2px solid red';
            form_text[3].innerHTML = '認證碼錯誤';
        }
    } else {
        isPass = false;
        field.style.border = '2px solid red';
        form_text[3].innerHTML = '請輸入認證碼';
    }








    if (isPass) {
        const fd = new FormData(document.form1);

        fetch('register-api.php', {
            method: 'POST',
            body: fd,
        }).then(r => r.json()).then(obj => {
            console.log(obj);

            if (obj.success) {
                showAlert('新增成功!', 'SUCC');
                //    setTimeout("location.href='member_list.php'",1300);
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
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>