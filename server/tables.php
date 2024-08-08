<?php
$learnerTable = "CREATE TABLE IF NOT EXISTS LEARNER(
	id int PRIMARY KEY AUTO_INCREMENT,
    profile_image BLOB NULL,
    name TEXT NOT NULL,
    email TEXT NOT NULL,
    PASSWORD TEXT NOT NULL
)";
?>