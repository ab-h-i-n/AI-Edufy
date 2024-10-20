<?php

include '../../utils/connect.php';

$decoded = json_decode(file_get_contents("php://input"), true);

$level_title = $decoded['level_title'];
$points_required = $decoded['points_required'];
$level_id = $decoded['level_id'];


// update existing level
$update = $user->leaderboard->levels->update([
    "level_title" => $level_title,
    "points_required" => $points_required
], "id=$level_id");


if ($update) {
    echo json_encode([
        "status" => 200,
        "msg" => "Level updated successfully"
    ]);
} else {
    echo json_encode([
        "status" => 500,
        "msg" => "Failed to update level"
    ]);
}
