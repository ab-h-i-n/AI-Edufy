<?php
include_once("../../utils/connect.php");

$qId = $_GET['qId'];
$userId = $_COOKIE['user_id'];

$decoded = json_decode(file_get_contents('php://input'), true);

$answer = $decoded['answer'];
$language = $decoded['language'];

try {
    $questionDetails = $user->question->select('*', "id = $qId")->fetch_assoc();

    $user->completed_questions->insert([
        "learner_id" => $userId,
        "question_id" => $qId,
        "answer" => $answer,
        "language" => $language
    ]);

    $user->leaderboard->insert([
        "learner_id" => $userId,
        "points_earned" => $questionDetails['points'],
    ]);

    echo json_encode([
        "status" => 200,
        "msg" => "Question completed successfully"
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => 500,
        "msg" => "An error occurred: " . $e->getMessage()
    ]);
}