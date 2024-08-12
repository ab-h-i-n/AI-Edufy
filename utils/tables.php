<?php

class BaseClass
{
    protected $dbcon;
    protected $tableName;

    function __construct($dbcon, $tableName)
    {
        $this->dbcon = $dbcon;
        $this->tableName = $tableName;
    }

    function select($columns = "*", $where = "")
    {
        $query = "SELECT $columns FROM $this->tableName";
        if (!empty($where)) {
            $query .= " WHERE $where";
        }
        $result = $this->dbcon->query($query);
        if (!$result) {
            die("Error in select query: " . $this->dbcon->error);
        }

        return $result;
    }


    function insert($data)
    {

        $columns = implode(", ", array_keys($data));
        $values = implode("', '", array_values($data));
        $query = "INSERT INTO $this->tableName ($columns) VALUES ('$values')";
        $result = $this->dbcon->query($query);

        if (!$result) {
            die("Error in insert query: " . $this->dbcon->error);
        }

        $userData = $this->select("*", "email = '" . $data['email'] . "'")->fetch_assoc();

        return $userData;
    }


}

class Admin extends BaseClass
{
    public $userRole = "admin";

    function __construct($dbcon)
    {
        parent::__construct($dbcon, "ADMIN");

        $createQuery = "CREATE TABLE IF NOT EXISTS " . $this->tableName . "(
            id INT PRIMARY KEY AUTO_INCREMENT,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        ) AUTO_INCREMENT=1000";

        if (!$this->dbcon->query($createQuery)) {
            die("Failed to create table " . $this->tableName . ": " . $this->dbcon->error);
        }

        // $insertQuery = "INSERT INTO " . $this->tableName . " (email, password) VALUES ('admin@edufy.com','admin')";

        // if (!$this->dbcon->query($insertQuery)) {
        //     die("Failed to insert admin into table " . $this->tableName . ": " . $this->dbcon->error);
        // }
    }

}

class Users extends BaseClass
{

    function __construct($dbcon)
    {
        parent::__construct($dbcon, "USERS");

        $createQuery = "CREATE TABLE IF NOT EXISTS " . $this->tableName . "(
            id INT PRIMARY KEY AUTO_INCREMENT,
            profile_image TEXT NULL,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('learner', 'mentor') NOT NULL
        ) AUTO_INCREMENT=1000";

        if (!$this->dbcon->query($createQuery)) {
            die("Failed to create table " . $this->tableName . ": " . $this->dbcon->error);
        }
    }
}

class Questions extends BaseClass
{
    public $test_cases;

    function __construct($dbcon)
    {
        parent::__construct($dbcon, "QUESTIONS");

        $createQuery = "CREATE TABLE IF NOT EXISTS " . $this->tableName . "(
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            type ENUM('easy', 'medium', 'hard') NOT NULL,
            language ENUM('C++', 'C') NOT NULL,
            mentor_id INT NOT NULL,
            points INT NOT NULL,
            FOREIGN KEY (mentor_id) REFERENCES USERS(id)
        ) AUTO_INCREMENT=1000";

        if (!$this->dbcon->query($createQuery)) {
            die("Failed to create table " . $this->tableName . ": " . $this->dbcon->error);
        }

        $this->test_cases = new TestCases($this->dbcon);
    }
}

class TestCases extends BaseClass
{

    function __construct($dbcon)
    {
        parent::__construct($dbcon, "TEST_CASES");

        $createQuery = "CREATE TABLE IF NOT EXISTS " . $this->tableName . "(
            id INT PRIMARY KEY AUTO_INCREMENT,
            input VARCHAR(255) NOT NULL,
            output VARCHAR(255) NOT NULL,
            question_id INT NOT NULL,
            FOREIGN KEY (question_id) REFERENCES QUESTIONS(id)
        ) AUTO_INCREMENT=1000";

        if (!$this->dbcon->query($createQuery)) {
            die("Failed to create table " . $this->tableName . ": " . $this->dbcon->error);
        }
    }
}

class CompletedQuestions extends BaseClass
{
    function __construct($dbcon)
    {
        parent::__construct($dbcon, "COMPLETED_QUESTIONS");

        $createQuery = "CREATE TABLE IF NOT EXISTS " . $this->tableName . "(
            learner_id INT PRIMARY KEY,
            question_id INT NOT NULL,
            FOREIGN KEY (learner_id) REFERENCES USERS(id),
            FOREIGN KEY (question_id) REFERENCES QUESTIONS(id)
        )";

        if (!$this->dbcon->query($createQuery)) {
            die("Failed to create table " . $this->tableName . ": " . $this->dbcon->error);
        }
    }
}

class LeaderBoard extends BaseClass
{
    public $levels;

    function __construct($dbcon)
    {
        parent::__construct($dbcon, "LEADER_BOARD");

        $this->levels = new Levels($dbcon);

        $createQuery = "CREATE TABLE IF NOT EXISTS " . $this->tableName . "(
            learner_id INT PRIMARY KEY NOT NULL,
            points_earned INT NOT NULL,
            level_id INT NOT NULL,
            FOREIGN KEY (learner_id) REFERENCES LEARNERS(id),
            FOREIGN KEY (level_id) REFERENCES LEVELS(id)
        )";

        if (!$this->dbcon->query($createQuery)) {
            die("Failed to create table " . $this->tableName . ": " . $this->dbcon->error);
        }
    }
}

class Levels extends BaseClass
{
    function __construct($dbcon)
    {
        parent::__construct($dbcon, "LEVELS");

        $createQuery = "CREATE TABLE IF NOT EXISTS " . $this->tableName . "(
            id INT PRIMARY KEY AUTO_INCREMENT,
            level_no INT NOT NULL,
            level_title VARCHAR(255) NOT NULL,
            points_required INT NOT NULL
        ) AUTO_INCREMENT=1000";

        if (!$this->dbcon->query($createQuery)) {
            die("Failed to create table " . $this->tableName . ": " . $this->dbcon->error);
        }
    }
}

?>