<style>
    .butten {
        position: relative;
    }

    .form-label,
    .p-color {
        color: #4a493b;
    }

    #bee-btn {
        border: 1px solid #4a493b;
        transform: translateX(-50%), translateY(-50%);
        background-color: #F6E8B0;
        position: absolute;
        left: 45.5%;
        bottom: 3%;
    }

    #bee-btn:hover {
        background-color: white;
    }
</style>

<?php require __DIR__ . '/parts/connect_db.php';
$pageName = 'edit';
$title = '修改訂單';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location:order_.php');
    exit;
}

$sql = "SELECT * FROM `order_all`o JOIN  `member_list`m ON 
o.`member_id`=m.`member_id`
 WHERE `order_id`=$sid";

$sqll = "SELECT * FROM `order_all`oo JOIN  `product_total`p ON 
oo.`product_id`=p.`product_id`
 WHERE `order_id`=$sid";
$r = $pdo->query($sql)->fetch();
$row = $pdo->query($sqll)->fetch();
if (empty($r)) {
    header('Location:order_.php'); //轉到列表頁
    exit;
}
?>
<?php
//地址
$sql_city = sprintf("SELECT `ct_name`FROM address_list WHERE `parent_sid`=0 ");

$stmt_city = $pdo->prepare($sql_city);
$stmt_city->execute();
$rows_city = $stmt_city->fetchAll();

$city = array_column($rows_city, 'ct_name', 'ct_sid');
$city_num = count($city);



$sql_dist = sprintf("SELECT `ct_name`,`parent_sid`FROM address_list WHERE `parent_sid`!=0 ");

$stmt_dist = $pdo->prepare($sql_dist);
$stmt_dist->execute();
$dist = $stmt_dist->fetchAll(PDO::FETCH_ASSOC);


?>
<?php require __DIR__ . '/parts/html-head.php'; ?>

<?php require __DIR__ . '/parts/navbar.php'; ?>

<div class="row justify-content-center mb-5">
    <div class="col-4">
        <h2 class="text-center">修改訂單</h2>
    </div>
</div>
<div class="container butten">
    <div class="row justify-content-center">
        <div class="col-6">
            <form style="border:1px solid gray;background-color:#F6E7B0" class="px-5 py-4 rounded " name="form" onsubmit="checkForm(event)" novalidate>
                <input type="hidden" name="order_id" value="<?= $r['order_id'] ?>">
                <div class="mb-3">
                    <label for="order_day" class="form-label">訂購日期</label>
                    <input type="date" class="form-control" id="order_day" name="order_day" value="<?= $r['order_day'] ?>">
                </div>
                <div class="mb-3">
                    <label for="member_id" class="form-label">會員姓名</label>
                    <input type="text" class="form-control d-none" id="member_id" name="member_id" required value="<?= htmlentities($r['member_id']) ?>">
                    <input type="text" class="form-control " disabled id="member_id" name="member_id" required value="<?= htmlentities($r['member_name']) ?>">
                    <div id="name_alert"></div>
                </div>
                <div class="mb-3">
                    <label for="order_state" class="form-label">訂單狀態</label>
                    <input type="text" class="form-control" id="order_state" name="order_state" value="<?= $r['order_state'] ?>">
                </div>
                <div class="mb-3">
                    <label for="product" class="form-label">商品名稱</label>
                    <input type="text" class="form-control d-none" id="product_id" name="product_id" required value="<?= $row['product_id'] ?>">
                    <input type="text" class="form-control" disabled id="product_id" name="product_id" required value="<?= $row['product_name'] ?>">
                    <div id="name_alert"></div>
                    <div class="mb-3">
                        <label for="number" class="form-label">商品數量</label>
                        <input type="text" class="form-control" id="product_number" name="product_number" value="<?= $r['product_number'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="order_ship" class="form-label">運費</label>
                        <input type="text" class="form-control" id="order_ship_money" name="order_ship_money" value="<?= $r['order_ship_money'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">優惠碼</label>
                        <input type="text" class="form-control" id="code" name="code" value="<?= $r['code'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="money" class="form-label">訂單金額</label>
                        <input type="text" class="form-control" id="order_money" name="order_money" value="<?= $r['order_money'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="order_recipient" class="form-label">收件人</label>
                        <input type="text" class="form-control" id="order_recipient" name="order_recipient" value="<?= $r['order_recipient'] ?>">
                        <div id="rec_name"></div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">收件人電話</label>
                        <input type="text" class="form-control" id="order_phone" name="order_phone" value="<?= $r['order_phone'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">收件人地址</label>
                        <div></div>
                        <select class="form-select" type="text" name="city" id="city-list" onchange="citychange(this.selectedIndex)"></select>
                        <select class="form-select" type="text" name="dist" id="dist-list"></select>
                        <input class="form-control" type="text" name="address" value="<?= $r['order_address'] ?>">

                    </div>
                    <div class="mb-3">
                        <label for="memo" class="form-label">訂單備註</label>
                        <input type="text" class="form-control" id="order_memo" name="order_memo" value="<?= $r['order_memo'] ?>">
                    </div>

                    <button type="submit" class="btn btn-outline" id="bee-btn">確認修改</button>
                    <br>

            </form>
        </div>


    </div>
</div>

<?php require __DIR__ . '/parts/script.php' ?>

<script>
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
    citysele.innerHTML = `<option value="<?= $r['order_address_city'] ?>" selected  hidden><?= $r['order_address_city'] ?></option>` + cityinner;

    //鄉鎮區選擇
    function citychange(ind) {
        let distinner = "";
        let dist2 = dist.filter((el) => el.parent_sid == (ind));

        for (let i = 0; i < dist2.length; i++) {
            distinner = distinner + '<option value=' + dist2[i].ct_name + '>' + dist2[i].ct_name + '</option>'
        };
        distsele.innerHTML = `<option value="<?= $r['order_address_dist'] ?>" selected  hidden><?= $r['order_address_dist'] ?></option>` + distinner;
    }

    citychange(document.getElementById("city-list").selectedIndex);
    // 這裡呼叫一次"typechange"這方法，讓瀏覽器在讀完XML後可以直接讓系所的資料出來




    const checkForm = function(event) {
        event.preventDefault();
        //要做欄位檢查

        document.form.querySelectorAll('input').forEach(function(el) {
            el.style.border = '1px solid #CCCCCC';
            document.querySelector('#name_alert').innerHTML = '';
            document.querySelector('#rec_name').innerHTML = '';
        });

        let isPass = true;
        let field = document.form.order_recipient;
        if (field.value.length < 2) {
            isPass = false;
            field.style.border = '2px solid red';
            document.querySelector('#rec_name').innerHTML = '請填寫正確的姓名';
        }


        if (isPass) {
            const fd = new FormData(document.form);

            fetch('order_edit_api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json()).then(obj => {
                console.log(obj);
                if (obj.success) {
                    alert('修改成功');
                    location.href = 'order_.php';
                } else {
                    for (let id in obj.errors) {
                        const field = document.querySelector(`#${id}`);
                        field.style.border = '2px solid red';
                        field.closest('.mb-3').querySelector('.form-text').innerHTML = obj.errors[id];
                        field.nextElementSibling.innerHTML = obj.errors[id];
                    }
                }
            })

        }
    };
</script>

<?php require __DIR__ . '/parts/html-foot.php' ?>