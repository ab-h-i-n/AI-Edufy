<?php

class User
{
    public $admin;
    public $question;
    public $completed_questions;
    private $dbcon;
    private $userTables;
    public $users;

    public function __construct($dbcon)
    {
        $this->dbcon = $dbcon;
        $this->admin = new Admin($dbcon);
        $this->users = new Users($dbcon);
        $this->question = new Questions($dbcon);
        $this->completed_questions = new CompletedQuestions($dbcon);

        $this->userTables = [
            $this->admin,
            $this->users
        ];
    }

    public function Login($email, $password)
    {
        foreach ($this->userTables as $table) {
            $result = $table->select('*', "email = '$email' AND password = '$password'");
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                return [
                    "role" => $user["role"] ?? 'admin',
                    "id" => $user["id"],
                ];
            }
        }
        return null;
    }

    public function SignUp($name, $email, $password, $role, $image)
    {
        $checkUser = $this->users->select("*", "email = '$email'")->fetch_assoc();

        if ($checkUser) {
            echo json_encode([
                "status" => 214,
                "msg" => "User already exists"
            ]);

            die();
        }

        $result = $this->users->insert([
            "name" => $name,
            "email" => $email,
            "password" => $password,
            "role" => $role,
            "profile_image" => $image
        ]);

        if (!$result) {
            return false;
        }

        return $result;

    }

    public function Delete($id){
        $result = $this->users->delete($id);
        if($result->num_rows > 0) {
            return $result;
        }else{
            return false;
        }
    }

    public function getUserQuestions($userId)
    {
        $result = $this->question->select('*', "mentor_id = '$userId'");
        if ($result->num_rows > 0) {
            $questions = [];
            while ($row = $result->fetch_assoc()) {
                $questions[] = $row;
            }
            return $questions;
        } else {
            return null;
        }
    }
}
