<?php

include_once ("../../utils/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $decoded = json_decode(file_get_contents('php://input'), true);

    $email = $decoded['email'];
    $password = $decoded['password'];


    try {
        $user_id = $user->Login($email, $password);
        $user_role = $user->getRole($user_id);

        echo json_encode([
            "id" => $user_id,
            "role" => $user_role
        ]);

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

