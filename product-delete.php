<?php
require __DIR__ . '/../connect/admin-required-for-api.php';
require __DIR__ . '/../connect/connect_db.php';

$sid = isset($_GET['productSid']) ? intval($_GET['productSid']) : 0;
if (empty($sid)) {
  header('Location: ../product-list.php'); // 轉向到列表頁
  exit;
}

$pdo->query("DELETE FROM `product` WHERE productSid=$sid");

if (empty($_SERVER['HTTP_REFERER'])) {
  header('Location: ../product-list.php');
} else {
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}