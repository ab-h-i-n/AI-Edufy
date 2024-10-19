<?php
include_once("../../utils/connect.php");

$levelId = $_GET['id'];

$levelDeleted = $user->leaderboard->levels->delete($levelId, false);

if ($levelDeleted) {
    echo json_encode([
        "status" => 200,
        "msg" => "Level deleted successfully"
    ]);
} else {
    echo json_encode([
        "status" => 500,
        "msg" => "Failed to delete level"
    ]);
}