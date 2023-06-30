<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';

$pageName = 'edit';
$title = '修改商品頁';

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
if (empty($product_id)) {
  header('Location: product_total.php'); // 轉向到列表頁
  exit;
}

$sql = "SELECT * FROM product_total WHERE product_id=$product_id";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
  header('Location: product_total.php'); // 轉向到列表頁
  exit;
}


?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<style>
.form-text {
    color: red;
}
</style>
<?php include __DIR__ . '/parts/navbar.php' ?>
<div class="container w-75 my-5">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card">

                <div class="card-body">
                    <form name="form1" onsubmit="checkForm(event)" novalidate>
                        <input type="hidden" name="product_id" value="<?= $r['product_id'] ?>">
                        <div class="mb-3">
                            <label for="product_category_id" class="form-label">商品分類</label>
                            <select class="form-select" id="product_category_id" name="product_category_id">
                                <option selected>所有商品</option>
                                <option value="1">手機</option>
                                <option value="2">平板</option>
                                <option value="3">耳機</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <p></p>
                            <label for="product_name" class="form-label">商品名稱</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" required
                                value="<?= htmlentities($r['product_name']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="product_price" class="form-label">商品價格</label>
                            <input type="text" class="form-control" id="product_price" name="product_price" required
                                value="<?= htmlentities($r['product_price']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="product_pic" class="form-label">商品圖片</label>
                            <select class="form-select" id="product_pic" name="product_pic">
                                <option selected>所有圖片</option>
                                <option>264.jpeg</option>
                                <option>265.png</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="brand_category_id" class="form-label">品牌分類</label>
                            <select class="form-select" id="brand_category_id" name="brand_category_id">
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
                        </div>


                </div>

                <button onclick="alert('修改未成功,離開!'),location.href='product_total.php'" , type="submit"
                    class="btn btn-outline" id="bee-btn">離開</button>

                <button onclick="alert('修改成功!'),location.href='product_total.php'" , type="submit"
                    class="btn btn-outline" id="bee-btn" style="background-color:darkseagreen">修改</button>
                </form>
            </div>
        </div>

    </div>
</div>
</div>


<?php include __DIR__ . '/parts/scripts.php' ?>

<script>
const rowData = <?= json_encode($r, JSON_UNESCAPED_UNICODE) ?>;

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
    // 欄位外觀回復原來的樣子
    document.form1.querySelectorAll('input.form-control').forEach(function(el) {
        el.style.border = '1px solid #CCCCCC';
        el.nextElementSibling.innerHTML = '';
    });






    const fd = new FormData(document.form1);

    fetch('product-edit-api.php', {
        method: 'POST',
        body: fd,
    }).then(r => r.json()).then(obj => {
        console.log(obj);
        if (obj.success) {
            showAlert('修改成功', 'success');
            // 跳轉到列表頁
        } else {
            for (let id in obj.errors) {
                const field = document.querySelector(`#${id}`);
                field.style.border = '2px solid red';
                // field.closest('.mb-3').querySelector('.form-text').innerHTML = obj.errors[id];
                field.nextElementSibling.innerHTML = obj.errors[id];
            }
            if (obj.msg) {
                showAlert(obj.msg);
            }
        }

        setTimeout(() => {
            hideAlert();
        }, 2000)
    })
};
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>