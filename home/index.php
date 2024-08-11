<?php
$role = $_COOKIE['role'] ?? '';

if (empty($role)) {
    header('Location: /AI-Edufy/login');
    exit();
} else {
    $file_to_include = "../users/$role/index.php";
    include ($file_to_include);
}
?>