<?php

session_start();

if (isset($_SESSION['admin'])) {
    include './product_total-admin.php';
} else {
    include './product_total-noadmin.php';
}
