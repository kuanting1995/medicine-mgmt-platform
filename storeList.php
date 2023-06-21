<?php
require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required.php';
$pageName = 'storeList';
$title = '工作室通訊錄列表';

$perPage = 6;
$onePage = 5;
$min = "";
$max = "";

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$sql = sprintf("SELECT * FROM `store` ORDER BY `storeSid` DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

$ss = isset($_GET['ss']) ? $_GET['ss'] : '';

$t_sql = "SELECT COUNT(1) FROM store";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

$totalPages = ceil($totalRows / $perPage);


if (!empty($ss)) {
  $sql = sprintf("SELECT * FROM `store` WHERE  `storeSid` LIKE '%%%s%%' ORDER BY `storeSid` DESC LIMIT %s, %s", $ss, ($page - 1) * $perPage, $perPage);
  // $t_sql = "SELECT COUNT(1) FROM store WHERE  `storeSid` LIKE '%{$ss}%'";
  $t_sql = "SELECT COUNT(1) FROM store WHERE `storeSid` = $ss";
  $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
  $totalPages = ceil($totalRows / $perPage);
}

if ($page < 1) {
  header('Location: ?page=1');
  exit;
} else if ($page > $totalPages) {
  header("Location: ?page={$totalPages}");
}

if ($totalPages >= $onePage) {
  if ($page > 3) {
    if ($page + 2 < $totalPages) {
      $min = $page - 2;
      $max = $page + 2;
    } else {
      $min = $totalPages - 4;
      $max = $totalPages;
    }
  } else {
    $min = 1;
    $max = $onePage;
  }
} else {
  $min = 1;
  $max = $totalPages;
}


$rows = [];


if ($totalRows > 0) {
  if ($page > $totalPages) {
    header('Location: ?page=' . $totalPages);
    exit;
  }
}

$rows = $pdo->query($sql)->fetchAll();

$url = "?ss=$ss&page=";
?>

<?php
include __DIR__ . '/parts/html-head.php';
include __DIR__ . '/parts/navbar.php';
?>


<div class="col-9">
    <div class="col">
        <h2>工作室管理</h2>

        <nav aria-label="Page navigation example">
            <ul class="pagination d-flex justify-content-between">
                <div class="d-flex">
                    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $url ?><?= $page - 5 ?>">
                            <i class="fa-solid fa-circle-arrow-left"></i>
                        </a>
                    </li>
                    <?php for ($i = $min; $i <= $max; $i++) :
            if ($i >= 1 and $i <= $totalPages) :
          ?>
                    <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                        <a class="page-link" href="<?= $url ?><?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php
            endif;
          endfor; ?>
                    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= $url ?><?= $page + 5 ?>">
                            <i class="fa-solid fa-circle-arrow-right"></i>
                        </a>
                    </li>
                </div>

                <div class="d-flex">

                    <form action="storeList.php<?= $url ?>" method="GET" class="me-2">
                        <input type="text" name="ss" placeholder="請輸入搜尋工作室編號">
                        <button class="btn btn-primary">確認</button>
                    </form>
                </div>

                <a class="btn btn-secondary" href="storeAdd.php" role="button">
                    新增工作室
                </a>
            </ul>
        </nav>

    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr class="text-center">
                <th scope="col">編號</th>
                <th scope="col">Logo</th>
                <th scope="col">店名</th>
                <th scope="col">帳號</th>
                <th scope="col">電話號碼</th>
                <th scope="col">註冊時間</th>
                <th scope="col">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
            <tr class="text-center">
                <td class=" align-middle"><?= $r['storeSid'] ?></td>
                <td class="align-middle">
                    <div>
                        <?php if ($r['storeLogo'] !== NULL) { ?>
                        <img style="width: 80px" src="store/images/<?php echo $r['storeLogo'] ?>" />
                        <?php } ?>
                    </div>
                </td>
                <td class="align-middle"><?= $r['storeName'] ?></td>
                <td class="align-middle"><?= $r['storeAccount'] ?></td>
                <td class="align-middle"><?= $r['storeMobile'] ?></td>
                <td class="align-middle"><?= $r['storeCreatedAt'] ?></td>
                <td class="align-middle">
                    <a class="btn btn-primary" href="storeEdit.php?storeSid=<?= $r['storeSid'] ?>" role="button">
                        檢視
                    </a>
                    <a class="btn btn-danger" href="javascript: delete_it(<?= $r['storeSid'] ?>)" role="button">
                        刪除
                    </a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
</div>
</div>

<?php
include __DIR__ . '/parts/scripts.php';
?>
<script>
function delete_it(sid) {
    if (confirm(`是否要刪除編號為 ${sid} 的資料?`)) {
        location.href = 'store/storeDelete.php?storeSid=' + sid;
    }
}
</script>
<?php
include __DIR__ . '/parts/html-foot.php';
?>