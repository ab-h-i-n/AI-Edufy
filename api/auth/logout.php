<?php

if (isset($_POST['logout'])) {
    setcookie('user_id', "", -36000, "/");
    setcookie('role', "", -36000, "/");
    header("Location: /AI-Edufy/");
}