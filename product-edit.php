<?php
require __DIR__ . '/connect/admin-required.php';
require __DIR__ . '/connect/connect_db.php';
$pageName = 'productList';
$title = '修改工作室通訊錄';

$sid = isset($_GET['productSid']) ? intval($_GET['productSid']) : 0;
if (empty($sid)) {
  header('Location: ./product-list.php');
  exit;
}

$sql = "SELECT * FROM `product` WHERE productSid=$sid";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
  header('Location: ./product-list.php');
  exit;
}

?>
<?php include __DIR__ . '/parts/html-head.php'; ?>

<style>
.form-text {
    color: red;
}
</style>

<?php include __DIR__ . '/parts/navbar.php'; ?>

<div class="col-lg-9">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h4 class="card-title">工作室詳細資料</h4>
                <a class="btn btn-secondary" href="product-list.php" role="button">
                    返回工作室管理列表
                </a>
            </div>

            <div class="d-flex justify-content-between">
                <form name="form2">
                    <div class="mb-3 d-flex">
                        <div>
                            <label for="Logo" class="form-label">工作室Logo</label>
                            <br>
                            <img id="myimg" src="product/images/<?= $r['productLogo'] ?>" alt="">
                            <input type="file" name="Logo" id="Logo" accept="image/*" style="display:none" />
                        </div>
                    </div>
                    <button style="height:50px" type="button" onclick="Logo.click()">上傳檔案</button>
                </form>
            </div>


            <form name="form1" onsubmit="checkForm(event)" novalidate>
                <div class="mb-3">
                    <input type="hidden" name="sid" value="<?= $r['productSid'] ?>">
                    <input type="hidden" name="logo1" id="logo1" accept="image/*" value="<?= $r['productLogo'] ?>" />
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">店名</label>
                    <input type="text" class="form-control" id="name" name="name" required placeholder="工作室店名"
                        value="<?= $r['productName'] ?>">
                    <div class="form-text"></div>
                </div>

                <div class="mb-3">
                    <label for="leader" class="form-label">負責人</label>
                    <input type="text" class="form-control" id="leader" name="leader" required placeholder="負責人姓名"
                        value="<?= $r['productLeader'] ?>">
                    <div class="form-text"></div>
                </div>

                <div class="mb-3">
                    <label for="account" class="form-label">帳號</label>
                    <input type="text" class="form-control" id="account" name="account" required
                        placeholder="請輸入4-20字元長度的帳號" value="<?= $r['productAccount'] ?>">
                    <div class="form-text"></div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">密碼</label>
                    <input type="text" class="form-control" id="password" name="password" required
                        placeholder="設定4-20位數密碼" value="<?= $r['productPassword'] ?>">
                    <div class="form-text"></div>
                </div>

                <div class="mb-3">
                    <label for="leaderId" class="form-label">負責人身分證</label>
                    <input type="text" class="form-control" id="leaderId" name="leaderId" required placeholder="身分證"
                        value="<?= $r['productLeaderId'] ?>">
                    <div class="form-text"></div>
                </div>

                <div class="mb-3">
                    <label for="mobile" class="form-label">電話號碼</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" required placeholder="工作室電話號碼"
                        value="<?= $r['productMobile'] ?>">
                    <div class="form-text"></div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">信箱</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Email"
                        value="<?= $r['productEmail'] ?>">
                    <div class="form-text"></div>
                </div>

                <div class="mb-3">
                    <label for="website" class="form-label">官方網站</label>
                    <input type="text" class="form-control" id="website" name="website" required placeholder="網站"
                        value="<?= $r['productWebsite'] ?>">
                    <div class="form-text"></div>
                </div>

                <div class="mb-3">
                    <label for="city" class="form-label">縣市</label>
                    <select name="city" class="form-select">
                        <option><?= $r['productCity'] ?></option>
                        <option value="臺北市">臺北市</option>
                        <option value="新北市">新北市</option>
                        <option value="基隆市">基隆市</option>
                        <option value="桃園市">桃園市</option>
                        <option value="新竹市">新竹市</option>
                        <option value="新竹縣">新竹縣</option>
                        <option value="臺中市">臺中市</option>
                        <option value="臺南市">臺南市</option>
                        <option value="高雄市">高雄市</option>
                        <option value="苗栗縣">苗栗縣</option>
                        <option value="彰化縣">彰化縣</option>
                        <option value="南投縣">南投縣</option>
                        <option value="雲林縣">雲林縣</option>
                        <option value="嘉義市">嘉義市</option>
                        <option value="嘉義縣">嘉義縣</option>
                        <option value="屏東縣">屏東縣</option>
                        <option value="宜蘭縣">宜蘭縣</option>
                        <option value="花蓮縣">花蓮縣</option>
                        <option value="臺東縣">臺東縣</option>
                        <option value="澎湖縣">澎湖縣</option>
                        <option value="金門縣">金門縣</option>
                        <option value="連江縣">連江縣</option>
                    </select>
                    <div class="form-text"></div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">地址</label>
                    <input type="text" class="form-control" id="address" name="address" required placeholder="工作室地址"
                        value="<?= $r['productAddress'] ?>">
                    <div class="form-text"></div>
                </div>

                <div class="mb-3">
                    <label for="time" class="form-label">營業時間</label>
                    <input type="text" class="form-control" id="time" name="time" required placeholder="00:00-24:00"
                        value="<?= $r['productTime'] ?>">
                    <div class="form-text"></div>
                </div>

                <div class="mb-3">
                    <label for="rest" class="form-label">休息日</label>
                    <input type="text" class="form-control" id="rest" name="rest" value="<?= $r['productRest'] ?>">
                    <div class="form-text"></div>
                </div>

                <div class="mb-3">
                    <label for="news" class="form-label">工作室介紹</label>
                    <textarea class="form-control" name="news" id="news" cols="50"
                        rows="5"><?= $r['productNews'] ?></textarea>
                    <div class="form-text"></div>
                </div>

                <div class="mb-3">
                    <p>註冊時間</p>
                    <p class="border p-2"><?= $r['productCreatedAt'] ?></p>
                </div>

                <div class="mb-3">
                    <p>最後異動時間</p>
                    <p class="border p-2"><?= $r['productEditAt'] ?></p>
                </div>

                <div class="alert alert-primary" role="alert" id="myAlert" style="display: none;"></div>
                <button type="submit" class="btn btn-primary">修改</button>

                <a class="btn btn-primary" href="product-list.php" role="button">
                    返回
                </a>

            </form>
        </div>
    </div>
</div>
</div>
</div>
<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>
const rowData = <?= json_encode($r, JSON_UNESCAPED_UNICODE) ?>;


const mobile_re = /(^(\(0\d{1}\)|0\d{1}\-)?\d{7,8}$)|(^09\d{2}-?\d{3}-?\d{3}$)/;

const email_re =
    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zAZ]{2,}))$/;

const leaderId_re = /^[A-Za-z]{1}[1-2]{1}[0-9]{8}$/;

const myAlert = document.querySelector('#myAlert');
const showAlert = function(msg = '沒給訊息文字', type = 'primary') {
    myAlert.innerHTML = msg;
    myAlert.className = `alert alert-${type}`;
    myAlert.style.display = 'block';
}
const hideAlert = function() {
    myAlert.style.display = 'none';
}

const checkForm = function(event) {
    event.preventDefault();
    document.form1.querySelectorAll('input.form-control').forEach(function(el) {
        el.style.border = '1px solid black';
        el.nextElementSibling.innerHTML = '';
    });
    document.form1.querySelectorAll('select').forEach(function(el) {
        el.style.border = '1px solid black';
        el.nextElementSibling.innerHTML = '';
    });
    document.form1.querySelectorAll('textarea.form-control').forEach(function(el) {
        el.style.border = '1px solid black';
        el.nextElementSibling.innerHTML = '';
    });

    let isPass = true;
    let field = document.form1.name;

    if (field.value.length < 2) {
        isPass = false;
        field.style.border = '2px solid red';
        field.nextElementSibling.innerHTML = '請輸入正確的店名';
    }

    field = document.form1.leader;
    if (field.value.length < 2) {
        isPass = false;
        field.style.border = '2px solid red';
        field.nextElementSibling.innerHTML = '請輸入負責人姓名';
    }

    field = document.form1.account;
    if ((field.value.length < 4) | (field.value.length > 20)) {
        isPass = false;
        field.style.border = '2px solid red';
        field.nextElementSibling.innerHTML = '請輸入正確的帳號格式';
    }

    field = document.form1.password;
    if ((field.value.length < 4) | (field.value.length > 20)) {
        isPass = false;
        field.style.border = '2px solid red';
        field.nextElementSibling.innerHTML = '密碼長度需4-20位數密碼';
    }

    field = document.form1.leaderId;
    if (!leaderId_re.test(field.value)) {
        isPass = false;
        field.style.border = '2px solid red';
        field.nextElementSibling.innerHTML = '請輸入正確的身分證格式';
    }

    field = document.form1.mobile;
    if (!mobile_re.test(field.value)) {
        isPass = false;
        field.style.border = '2px solid red';
        field.nextElementSibling.innerHTML = '請輸入正確的電話號碼格式';
    }

    field = document.form1.email;
    if (!email_re.test(field.value)) {
        isPass = false;
        field.style.border = '2px solid red';
        field.nextElementSibling.innerHTML = '請輸入正確的 email 格式';
    }

    field = document.form1.website;
    if (field.value.length < 3) {
        isPass = false;
        field.style.border = '2px solid red';
        field.nextElementSibling.innerHTML = '請輸入網站';
    }

    field = document.form1.city;
    if (field.value.length > 4) {
        isPass = false;
        field.style.border = '2px solid red';
        field.nextElementSibling.innerHTML = '請選擇縣市';
    }

    field = document.form1.address;
    if (field.value.length < 3) {
        isPass = false;
        field.style.border = '2px solid red';
        field.nextElementSibling.innerHTML = '請輸入地址';
    }

    field = document.form1.time;
    if (field.value.length < 3) {
        isPass = false;
        field.style.border = '2px solid red';
        field.nextElementSibling.innerHTML = '請輸入營業時間';
    }

    if (isPass) {
        const fd = new FormData(document.form1);

        fetch('product/productEdit-api.php', {
            method: 'POST',
            body: fd,
        }).then(r => r.json()).then(obj => {
            if (obj.success) {
                showAlert('修改成功', 'success');

            } else {
                for (let id in obj.errors) {
                    const field = document.querySelector(`#${id}`);
                    field.style.border = '2px solid red';
                    field.nextElementSibling.innerHTML = obj.errors[id];
                }

                if (obj.msg) {
                    showAlert(obj.msg);
                }
            }

            setTimeout(() => {
                hideAlert();
            }, 3000)
        })
    }



};

const Logo = document.form2.Logo;
Logo.onchange = function(event) {
    event.preventDefault();
    const fd = new FormData(document.form2);
    fetch("product/productUpload.php", {
        method: "POST",
        body: fd
    }).then(r => r.json()).then(obj => {
        myimg.src = "/JIM/product/images/" + obj.filename;
        document.querySelector('#logo1').value = `${obj.filename}`;

    })
}
</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>