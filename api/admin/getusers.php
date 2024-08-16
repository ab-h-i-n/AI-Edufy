<?php

include_once("../utils/connect.php");

$result = $user->users->select('*');

$userData = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $userData[] = $row;
    }
}


