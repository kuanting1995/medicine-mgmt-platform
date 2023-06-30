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
    background-color: #c6bbac;
    position: absolute;
    left: 45.5%;
    bottom: 3%;
}

#bee-btn:hover {
    background-color: white;
}

/*     
    .butten1{

    } */
</style>



<?php require __DIR__ . '/parts/connect_db.php';
$pageName = 'order-add';
$title = '新增訂單'; ?>
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
        <h2 class="text-center">新增訂單</h2>
    </div>
</div>
<div class="container butten">
    <div class="row justify-content-center">
        <div class="col-6">
            <form style="border:1px solid gray;background-color:#c6bbac;" class="px-5 py-4 rounded" name="form"
                onsubmit="checkForm(event)" novalidate>
                <!-- <div class="mb-3">
                    <label for="order_id" class="form-label">訂單編號</label>
                    <input type="text" class="form-control" id="order_id" name="order_id"  >
                </div> -->
                <div class="mb-3">
                    <label for="order_day" class="form-label">訂購日期</label>
                    <input type="date" class="form-control" id="order_day" name="order_day">
                </div>
                <div class="mb-3">
                    <label for="member_id" class="form-label" onclick="input()">會員編號</label>
                    <!-- <button onclick="worder()">1</button> -->
                    <input type="text" class="form-control" id="member_id" name="member_id">
                    <div id="name_alert"></div>
                </div>
                <div class="mb-3">
                    <label for="order_state" class="form-label">訂單狀態</label>
                    <input type="text" class="form-control" id="order_state" name="order_state">
                </div>
                <div class="mb-3">
                    <label for="product" class="form-label">商品名稱</label>
                    <input type="text" class="form-control" id="product_id" name="product_id">
                </div>
                <div class="mb-3">
                    <label for="number" class="form-label">商品數量</label>
                    <input type="text" class="form-control" id="product_number" name="product_number">
                </div>
                <div class="mb-3">
                    <label for="order_ship" class="form-label">運費</label>
                    <input type="text" class="form-control" id="order_ship_money" name="order_ship_money">
                </div>
                <div class="mb-3">
                    <label for="code" class="form-label">優惠碼</label>
                    <input type="text" class="form-control" id="code" name="code">
                </div>
                <div class="mb-3">
                    <label for="money" class="form-label">訂單金額</label>
                    <input type="text" class="form-control" id="order_money" name="order_money">
                </div>
                <div class="mb-3">
                    <label for="order_recipient" class="form-label">收件人</label>
                    <input type="text" class="form-control" id="order_recipient" name="order_recipient">
                    <div id="rec_name"></div>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">收件人電話</label>
                    <input type="text" class="form-control" id="order_phone" name="order_phone">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">收件人地址</label>
                    <select class="form-select" type="text" name="city" id="city-list"
                        onchange="citychange(this.selectedIndex)"></select>
                    <select class="form-select" type="text" name="dist" id="dist-list"></select>
                    <input class="form-control" type="text" name="address">

                </div>
                <div class="mb-3">
                    <label for="memo" class="form-label">訂單備註</label>
                    <input type="text" class="form-control" id="order_memo" name="order_memo">
                </div>
                <div>
                    <button type="submit" class="btn butten" id="bee-btn">新增訂單</button>
                </div>
                <br>
                <br>
            </form>
        </div>


    </div>
</div>

<?php require __DIR__ . '/parts/scripts.php' ?>

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
citysele.innerHTML = `<option value="none" selected disabled hidden>縣市</option>` + cityinner;

//鄉鎮區選擇
function citychange(ind) {
    let distinner = "";
    let dist2 = dist.filter((el) => el.parent_sid == (ind));

    for (let i = 0; i < dist2.length; i++) {
        distinner = distinner + '<option value=' + dist2[i].ct_name + '>' + dist2[i].ct_name + '</option>'
    };
    distsele.innerHTML = `<option value="none" selected disabled hidden>區鄉鎮</option>` + distinner;
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

        fetch('order_add-api.php', {
            method: 'POST',
            body: fd,
        }).then(r => r.json()).then(obj => {
            console.log(obj);
            if (obj.success) {
                alert('新增成功');
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

// function worder() {
//     document.getElementById("member_id").innerHTML = "35";
// }
function input() {
    order_day.value = "2022-12-18";
    member_id.value = "35";
    order_state.value = "2";
    product_id.value = "23";
    product_number.value = "4";
    order_ship_money.value = "100";
    code.value = "21";
    order_money.value = "13000";
    order_recipient.value = "喪彪";
    order_phone.value = "0927382736";
    // city.value = "台北市";
    // dist.value = "松山區";
    // address.value = "長安東路五段300號2樓";
    order_memo.value = "請交給大樓管理員謝謝"

}
</script>

<?php require __DIR__ . '/parts/html-foot.php' ?>