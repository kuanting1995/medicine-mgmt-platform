<?php

require __DIR__ . '/parts/connect_db.php';

$pageName = 'add';
$title = '新增商品頁';


?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<style>
    .form-label,
    .p-color {
        color: #4a493b;
    }

    #bee-btn {
        border: 1px solid #4a493b;
    }
</style>

<?php include __DIR__ . '/parts/navbar.php' ?>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">新增商品資料</h5>
                    <div class="d-flex justify-content-between">
                        <form name="form2">
                            <div class="mb-3 d-flex">
                                <div>
                                    <label for="productPic" class="form-label">productPic</label>
                                    <br>
                                    <img id="myimg" src="../medicine0702/image/<?= $r['product_pic'] ?>" alt="">
                                    <input type="file" name="productPic" id="productPic" accept="image/*" style="display:none" />
                                </div>
                            </div>
                            <!-- <button style="height:50px" type="button" onclick="productPic.click()">上傳檔案</button> -->
                        </form>
                    </div>
                    <form name="form1" onsubmit="checkForm(event)" novalidate>
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
                            <label for="product_name" class="form-label">商品名稱</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" required>
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="product_price" class="form-label">商品價格</label>
                            <input type="text" class="form-control" id="product_price" name="product_price" required>
                            <div class="form-text"></div>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="product_pic" class="form-label">商品圖片</label>
                            <select class="form-select" id="product_pic" name="product_pic">
                                <option selected>所有圖片</option>
                                <option>264.jpeg</option>
                                <option>265.png</option>
                            </select>
                        </div> -->
                        <div class="mb-3">
                            <input type="hidden" name="productPic1" id="productPic1" accept="image/*" value="" />
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

                        <button onclick="alert('新增未成功,離開!'),location.href='product_total.php'" , type="submit" class="btn btn-outline" id="bee-btn">離開</button>

                        <button onclick="alert('新增成功!'),location.href='product_total.php'" , type="submit" class="btn btn-outline" id="bee-btn" style="background-color:darkseagreen">新增</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require __DIR__ . "/parts/scripts.php" ?>

<script>
    const checkForm = function(event) {
        event.preventDefault();

        const fd = new FormData(document.form1);
        fetch('product-add-api.php', {
            method: 'POST',
            body: fd,
        }).then(r => r.json()).then(obj => {
            console.log(obj);
            if (obj.success) {
                showAlert('新增成功', 'success');
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
    //上傳圖片
    const productPic = document.form2.productPic;
    productPic.onchange = function(event) {
        event.preventDefault();
        const fd = new FormData(document.form2);
        fetch("product-upload.php", {
            method: "POST",
            body: fd
        }).then(r => r.json()).then(obj => {
            myimg.src = "../medicine0702/image/" + obj.filename;
            document.querySelector('#productPic1').value = `${obj.filename}`;

        })
    }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>