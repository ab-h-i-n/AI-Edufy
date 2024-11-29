<?php

class User
{
    public $admin;
    public $question;
    public $completed_questions;
    private $dbcon;
    private $userTables;
    public $users;
    public $leaderboard;

    public function __construct($dbcon)
    {
        $this->dbcon = $dbcon;
        $this->admin = new Admin($dbcon);
        $this->users = new Users($dbcon);
        $this->question = new Questions($dbcon);
        $this->completed_questions = new CompletedQuestions($dbcon);
        $this->leaderboard = new LeaderBoard($dbcon);

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

        $userData = $this->users->select("id,email,name,role", "email = '" . $email . "'")->fetch_assoc();

        return $userData;

    }

    public function Delete($id)
    {
        $result = $this->users->delete($id);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getUserQuestions($userId)
    {
        $query = "SELECT q.* , u.name as mentor_name FROM QUESTIONS q LEFT JOIN USERS u ON q.mentor_id = u.id WHERE mentor_id = '$userId'";

        $result = $this->dbcon->query($query);
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

    public function getAllQuestions()
    {
        $query = "SELECT q.*, u.name AS mentor_name FROM QUESTIONS q LEFT JOIN USERS u ON q.mentor_id = u.id";
        $result = $this->dbcon->query($query);

        if ($result->num_rows > 0) {
            $questions = [];


            while ($row = $result->fetch_assoc()) {
                $questions[] = [
                    'id' => $row['id'],
                    'mentor_name' => $row['mentor_name'],
                    'title' => $row['title'],
                    'description' => $row['description'],
                    'type' => $row['type'],
                    'points' => $row['points'],
                    'test_cases' => [] // Initialize test_cases as an empty array
                ];
            }

            // Now fetch test cases for each question
            $questionIds = array_column($questions, 'id'); // Get an array of question IDs
            $questionIdsString = implode(',', $questionIds); // Create a comma-separated string of IDs

            if (!empty($questionIdsString)) {
                $testCaseQuery = "SELECT * FROM TEST_CASES WHERE question_id IN ($questionIdsString)";
                $testCaseResult = $this->dbcon->query($testCaseQuery);

                // Fetch test cases and associate them with the corresponding questions
                if ($testCaseResult->num_rows > 0) {
                    while ($testCaseRow = $testCaseResult->fetch_assoc()) {
                        // Find the question to which the test case belongs
                        foreach ($questions as &$question) {
                            if ($question['id'] == $testCaseRow['question_id']) {
                                $question['test_cases'][] = [
                                    'id' => $testCaseRow['id'],
                                    'input' => $testCaseRow['input'],
                                    'output' => $testCaseRow['output'],
                                ];
                                break;
                            }
                        }
                    }
                }
            }

            return $questions;
        } else {
            return null;
        }
    }


    public function getNumberOfQuestions($type, $user)
    {
        $result = $this->question->select('*', "type = '$type'");
        $result2 = $this->completed_questions->select('*', "learner_id = '$user' AND q.type = '$type'");
        return [$result2->num_rows, $result->num_rows];
    }
}
