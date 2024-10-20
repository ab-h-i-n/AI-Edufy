<?php

include('../../utils/connect.php');

$decoded = json_decode(file_get_contents("php://input"), true);

$level_title = $decoded['level_title'];
$points_required = $decoded['points_required'];

//check level with this points exists 
$level = $user->leaderboard->levels->select('*', "points_required = $points_required");
if (mysqli_num_rows($level) > 0) {
    echo json_encode([
        "status" => 404,
        "msg" => "Level with this points already exists"
    ]);
    exit();
}

// insert new level
$insert = $user->leaderboard->levels->insert([
    "level_title" => $level_title,
    "points_required" => $points_required
]);

if ($insert) {
    echo json_encode([
        "status" => 200,
        "msg" => "Level added successfully"
    ]);
} else {
    echo json_encode([
        "status" => 500,
        "msg" => "Failed to add level"
    ]);
}