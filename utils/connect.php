<?php

include_once("createDb.php");
include_once("tables.php");

$dbcon = createDb("localhost", "root", "", "aiEdufy");

$admin = new Admin($dbcon);
$learner = new Learners($dbcon);
$mentor = new Mentors($dbcon);
$question = new Questions($dbcon);
$completed_questions = new CompletedQuestions($dbcon);
$leader_board = new Leaderboard($dbcon);

?>
