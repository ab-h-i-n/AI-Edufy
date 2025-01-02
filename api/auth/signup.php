<?php

include_once("../../utils/connect.php");
include_once("../../utils/user.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['role'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $role = $_POST['role'];
        $image = "";
        
        if (isset($_FILES['image'])) {
            $image = file_get_contents($_FILES['image']['tmp_name']); 
        }

        try {
            $user = new User($dbcon);

            $user_data = $user->SignUp($name, $email, $password, $role, $image);

            if ($user_data) {
                setcookie('user_id', $user_data['id'], time() + (86400 * 30), "/");
                setcookie('role', $user_data['role'], time() + (86400 * 30), "/");

                echo json_encode([
                    "status" => 200,
                    "msg" => "User created successfully!",
                    "data" => $user_data
                ]);
            } else {
                echo json_encode([
                    "status" => 404,
                    "msg" => "Failed to create user!"
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
            "status" => 400,
            "msg" => "Missing required fields or invalid file upload."
        ]);
    }

} else {
    echo json_encode([
        "status" => 500,
        "msg" => "Invalid request method"
    ]);
}
?>
