<?php

include_once("createDb.php");
include_once("tables.php");
include_once("user.php");
include_once("phputils.php");

$dbcon = createDb("localhost", "root", "", "aiEdufy");

$user = new User($dbcon);

?>
