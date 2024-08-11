<?php

include_once ("../../utils/connect.php");
include_once ("../../utils/user.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $decoded = json_decode(file_get_contents('php://input'), true);

    $email = $decoded['email'];
    $password = $decoded['password'];


    try {
        $user = new User($dbcon);

        $user_data = $user->Login($email, $password);

        if ($user_data) {
            setcookie('user_id', $user_data['id'], time() + (86400 * 30), "/");
            setcookie('role', $user_data['role'], time() + (86400 * 30), "/");
            echo json_encode([
                "status" => 200,
                "msg" => "User found",
                "data" => $user_data
            ]);
        } else {
            echo json_encode([
                "status" => 404,
                "msg" => "User not found"
            ]);
        }

    } catch (Throwable $th) {

        echo json_encode([
            'status' => 'error',
            'error' => $th->getMessage()
        ]);
    }

} else {
    echo json_encode([
        "status" => 500,
        "msg" => "Invalid request method"
    ]);
}

