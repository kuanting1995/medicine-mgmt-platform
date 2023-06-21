<?php
require __DIR__ . '/parts/connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: order_.php');
    exit;
}

$pdo->query("DELETE FROM `order_all` WHERE `order_id`=$sid");

if (empty($_SERVER['HTTP_REFERER'])) {
    header('Location: order_.php');
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
