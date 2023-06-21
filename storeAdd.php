<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';
$pageName = 'storeList';
$title = '新增工作室通訊錄';

?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<style>
  .form-text {
    color: red;
  }
</style>
<?php include __DIR__ . '/parts/navbar.php' ?>

<div class="col-9">
  <div class="card">

    <div class="card-body">
      <div class="d-flex justify-content-between">
        <h4 class="card-title">新增工作室</h4>
        <a class="btn btn-secondary" href="storeList.php" role="button">
          返回工作室管理列表
        </a>
      </div>

      <div class="d-flex justify-content-between">
        <form name="form2">
          <div class="mb-3 d-flex">
            <div>
              <label for="logo" class="form-label">工作室Logo</label>
              <br>
              <img id="myimg" src="store/images/<?= $r['storeLogo'] ?>" alt="">
              <input type="file" name="Logo" id="Logo" accept="image/*" style="display:none" />
            </div>
          </div>
          <button style="height:50px" type="button" onclick="Logo.click()">上傳檔案</button>
        </form>
      </div>

      <form name="form1" onsubmit="checkForm(event)" novalidate>
        <div class="mb-3">
          <input type="hidden" name="sid" value="<?= $r['storeSid'] ?>">
          <input type="hidden" name="logo1" id="logo1" accept="image/*" value="" />
        </div>

        <div class="mb-3">
          <label for="name" class="form-label">店名</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="工作室店名" required>
          <div class="form-text"></div>
        </div>

        <div class="mb-3">
          <label for="leader" class="form-label">負責人</label>
          <input type="text" class="form-control" id="leader" name="leader" placeholder="負責人姓名" required>
          <div class="form-text"></div>
        </div>

        <div class="mb-3">
          <label for="account" class="form-label">帳號</label>
          <input type="text" class="form-control" id="account" name="account" placeholder="請輸入4-20字元長度的帳號" required>
          <div class="form-text"></div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">密碼</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="設定4-20位數密碼" required>
          <div class="form-text"></div>
        </div>

        <div class="mb-3">
          <label for="leaderId" class="form-label">負責人身分證</label>
          <input type="text" class="form-control" id="leaderId" name="leaderId" placeholder="身分證" required>
          <div class="form-text"></div>
        </div>

        <div class="mb-3">
          <label for="mobile" class="form-label">電話號碼</label>
          <input type="text" class="form-control" id="mobile" name="mobile" placeholder="工作室電話號碼" required>
          <div class="form-text"></div>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">信箱</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
          <div class="form-text"></div>
        </div>

        <div class="mb-3">
          <label for="website" class="form-label">官方網站</label>
          <input type="text" class="form-control" id="website" name="website" placeholder="網站" required>
          <div class="form-text"></div>
        </div>

        <div class="mb-3">
          <label for="city" class="form-label">縣市</label>
          <select name="city" class="form-select">
            <option placeholder="請選擇縣市">請選擇縣市</option>
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
          <input type="text" class="form-control" id="address" name="address" placeholder="工作室地址" required>
          <div class="form-text"></div>
        </div>

        <div class="mb-3">
          <label for="time" class="form-label">營業時間</label>
          <input type="text" class="form-control" id="time" name="time" placeholder="00:00-24:00" required>
          <div class="form-text"></div>
        </div>

        <div class="mb-3">
          <label for="rest" class="form-label">休息日</label>
          <input type="text" class="form-control" id="rest" name="rest">
          <div class="form-text"></div>
        </div>

        <div class="mb-3">
          <label for="news" class="form-label">工作室介紹</label>
          <textarea class="form-control" name="news" id="news" cols="50" rows="5"></textarea>
          <div class="form-text"></div>
        </div>

        <button type="submit" class="btn btn-primary">新增</button>
      </form>
    </div>
  </div>
</div>

<?php include __DIR__ . '/parts/scripts.php' ?>

<script>
  const mobile_re = /(^(\(0\d{1}\)|0\d{1}\-)?\d{7,8}$)|(^09\d{2}-?\d{3}-?\d{3}$)/;

  const email_re =
    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zAZ]{2,}))$/;

  const leaderId_re = /^[A-Za-z]{1}[1-2]{1}[0-9]{8}$/;

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

      fetch('store/storeAdd-api.php', {
        method: 'POST',
        body: fd,
      }).then(r => r.json()).then(obj => {
        console.log(obj);
        if (obj.success) {
          alert('新增成功');
          location.href = "storeList.php";
        } else {
          for (let id in obj.errors) {
            const field = document.querySelector(`#${id}`);
            field.style.border = '2px solid red';
            field.nextElementSibling.innerHTML = obj.errors[id];
          }
        }
      })
    }
  };

  const Logo = document.form2.Logo;
  Logo.onchange = function(event) {
    event.preventDefault();
    const fd = new FormData(document.form2);
    fetch("store/storeUpload.php", {
      method: "POST",
      body: fd
    }).then(r => r.json()).then(obj => {
      myimg.src = "/JIM/store/images/" + obj.filename;
      document.querySelector('#logo1').value = `${obj.filename}`;

    })
  }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>