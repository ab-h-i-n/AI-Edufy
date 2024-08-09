<?php

class User
{
    private $learner;
    private $admin;
    private $mentor;
    private $question;
    private $completed_questions;
    private $dbcon;
    private $userTables;


    public function __construct($dbcon)
    {
        $this->dbcon = $dbcon;
        $this->admin = new Admin($dbcon);
        $this->learner = new Learners($dbcon);
        $this->mentor = new Mentors($dbcon);
        $this->question = new Questions($dbcon);
        $this->completed_questions = new CompletedQuestions($dbcon);

        $this->userTables = [
            $this->admin,
            $this->learner,
            $this->mentor,
        ];
    }

    public function getRole($userId)
    {
        foreach ($this->userTables as $table) {
            $result = $table->select();
            if ($result->num_rows > 0) {
                return $table->userRole;
            }
        }

        return false;
    }

    public function Login($email, $password)
    {

        foreach ($this->userTables as $table) {
            $result = $table->select();
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                return $user['id'];
            }
        }

        return false;

    }

}

