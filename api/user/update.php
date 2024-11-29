<?php

include_once('../../utils/connect.php');

$userId = $_COOKIE['user_id'];

try {
    $updatedUser = $user->users->update([
        "name" => $_POST["name"],
        "email" => $_POST["email"],
        "profile_image" => file_get_contents($_FILES['image']['tmp_name']),
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