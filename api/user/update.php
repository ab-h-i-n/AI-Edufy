<?php

include_once('../../utils/connect.php');
$userId = $_COOKIE['user_id'];
$decodedData = json_decode(file_get_contents("php://input") , true);

$image = "image";

try {
    $updatedUser = $user->users->update([
        "name" => $decodedData["name"],
        "email" => $decodedData["email"],
        "profile_image" => $decodedData["image"],
    ], "id=$userId");


    echo json_encode([
        "status" => 200,
        "message" => "User updated successfully"
    ]);
} catch (Throwable $th) {
    echo json_encode([
        "status" => 500,
        "message" => "Failed to update user",
        "error" => $th->getMessage()
    ]);
}