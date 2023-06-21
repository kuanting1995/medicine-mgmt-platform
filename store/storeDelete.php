<?php
require __DIR__ . '/../connect/admin-required-for-api.php';
require __DIR__ . '/../connect/connect_db.php';

$sid = isset($_GET['storeSid']) ? intval($_GET['storeSid']) : 0;
if (empty($sid)) {
  header('Location: ../storeList.php'); // 轉向到列表頁
  exit;
}

$pdo->query("DELETE FROM `store` WHERE storeSid=$sid");

if (empty($_SERVER['HTTP_REFERER'])) {
  header('Location: ../storeList.php');
} else {
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}
