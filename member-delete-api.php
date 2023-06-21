<?php

require __DIR__ . '/parts/connect_db.php';
require __DIR__ . '/parts/admin-required-for-api.php';

$id = isset($_GET['member_id']) ? intval($_GET['member_id']) : 0;

if (empty($_GET['member_id'])) {
    header('Location: member-list.php');
    exit;
}

$pdo->query("DELETE FROM `members` WHERE `member_id` =$id");

if (isset($_SERVER['HTTP_REFERER'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: member-list.php');
}
