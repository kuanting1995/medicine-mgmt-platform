<?php
header("Content-Type: application/json");
$fieldName = "productPic";
$extMap = [
    'image/png' => '.png',
    'image/jpeg' => '.jpg',
];

$filename = $_FILES[$fieldName]['name'];

$success = true;
$success = move_uploaded_file(
    $_FILES[$fieldName]['tmp_name'],
    __DIR__ . '/./image/' . $filename
);
echo json_encode([
    'success' => $success,
    'filename' => $filename,
    'files' => $_FILES
]);
