<?php

function createDb($host, $user, $password, $dbname)
{
    $db = new mysqli($host, $user, $password);

    if ($db->connect_error) {
        die("Failed to connect to the database: " . $db->connect_error);
    }

    $createDbQuery = "CREATE DATABASE IF NOT EXISTS " . $dbname;

    if (!$db->query($createDbQuery)) {
        die("Failed to create the database: " . $db->error);
    }

    if (!$db->select_db($dbname)) {
        die("Failed to select the database: " . $db->error);
    }

    return $db;
}

?>