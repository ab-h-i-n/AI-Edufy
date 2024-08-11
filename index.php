<?php
$role = $_COOKIE['role'] ?? '';

if (empty($role)) {
    header('Location: /AI-Edufy/welcome');
} else {
    header('Location: /AI-Edufy/home');
}
exit(); 
