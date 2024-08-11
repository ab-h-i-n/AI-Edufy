<?php

class User
{
    private $admin;
    private $question;
    private $completed_questions;
    private $dbcon;
    private $userTables;
    private $users;

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

}

