<?php
// Database connection
$db_host = 'localhost';
$db_user = 'medicine';
$db_password = 'medicine';
$db_name = 'medicine';

$db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);

// CHECK DATABASE CONNECTION
if ($db_connection->error) {
    echo "Connection Failed - " . $db_connection->connect_error;
    exit;
}
