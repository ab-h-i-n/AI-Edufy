<?php

class Admin
{
    public $tableName = "ADMINS";
    public $userRole = "admin";
    private $dbcon;

    function __construct($dbcon)
    {
        $this->dbcon = $dbcon;

        $createQuery = "CREATE TABLE IF NOT EXISTS " . $this->tableName . "(
            id INT PRIMARY KEY AUTO_INCREMENT,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )";

        if (!$this->dbcon->query($createQuery)) {
            die("Failed to create table " . $this->tableName . ": " . $this->dbcon->error);
        }
    }
    
}

class Learners
{
    public $tableName = "LEARNERS";
    public $userRole = "learner";
    private $dbcon;

    function __construct($dbcon)
    {
        $this->dbcon = $dbcon;

        $createQuery = "CREATE TABLE IF NOT EXISTS " . $this->tableName . "(
            id INT PRIMARY KEY AUTO_INCREMENT,
            profile_image LONGBLOB NULL,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )";

        if (!$this->dbcon->query($createQuery)) {
            die("Failed to create table " . $this->tableName . ": " . $this->dbcon->error);
        }
    }
}

class Mentors
{
    public $tableName = "MENTORS";
    public $userRole = "mentor";
    private $dbcon;

    function __construct($dbcon)
    {
        $this->dbcon = $dbcon;

        $createQuery = "CREATE TABLE IF NOT EXISTS " . $this->tableName . "(
            id INT PRIMARY KEY AUTO_INCREMENT,
            profile_image LONGBLOB NULL,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )";

        if (!$this->dbcon->query($createQuery)) {
            die("Failed to create table " . $this->tableName . ": " . $this->dbcon->error);
        }
    }
}

class Questions
{
    public $tableName = "QUESTIONS";
    private $dbcon;
    public $test_cases;

    function __construct($dbcon)
    {
        $this->dbcon = $dbcon;

        $createQuery = "CREATE TABLE IF NOT EXISTS " . $this->tableName . "(
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            type ENUM('easy', 'medium', 'hard') NOT NULL,
            language ENUM('C++', 'C') NOT NULL,
            mentor_id INT NOT NULL,
            points INT NOT NULL,
            FOREIGN KEY (mentor_id) REFERENCES MENTORS(id)
        )";

        if (!$this->dbcon->query($createQuery)) {
            die("Failed to create table " . $this->tableName . ": " . $this->dbcon->error);
        }

        $this->test_cases = new TestCases($this->dbcon);
    }
}



class TestCases
{
    public $tableName = "TEST_CASES";
    private $dbcon;

    function __construct($dbcon)
    {
        $this->dbcon = $dbcon;

        $createQuery = "CREATE TABLE IF NOT EXISTS " . $this->tableName . "(
            id INT PRIMARY KEY AUTO_INCREMENT,
            input VARCHAR(255) NOT NULL,
            output VARCHAR(255) NOT NULL,
            question_id INT NOT NULL,
            FOREIGN KEY (question_id) REFERENCES QUESTIONS(id)
        )";

        if (!$this->dbcon->query($createQuery)) {
            die("Failed to create table " . $this->tableName . ": " . $this->dbcon->error);
        }
    }
}


class CompletedQuestions
{
    public $tableName = "COMPLETED_QUESTIONS";
    private $dbcon;

    function __construct($dbcon)
    {
        $this->dbcon = $dbcon;

        $createQuery = "CREATE TABLE IF NOT EXISTS " . $this->tableName . "(
            learner_id INT PRIMARY KEY,
            question_id INT NOT NULL,
            FOREIGN KEY (learner_id) REFERENCES LEARNERS(id),
            FOREIGN KEY (question_id) REFERENCES QUESTIONS(id)
        )";

        if (!$this->dbcon->query($createQuery)) {
            die("Failed to create table " . $this->tableName . ": " . $this->dbcon->error);
        }
    }
}



class LeaderBoard
{
    public $tableName = "LEADER_BOARD";
    private $dbcon;
    public $levels;

    function __construct($dbcon)
    {
        $this->dbcon = $dbcon;

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


class Levels
{
    public $tableName = "LEVELS";
    private $dbcon;

    function __construct($dbcon)
    {
        $this->dbcon = $dbcon;

        $createQuery = "CREATE TABLE IF NOT EXISTS " . $this->tableName . "(
            id INT PRIMARY KEY AUTO_INCREMENT,
            level_title VARCHAR(255) NOT NULL,
            points_required INT NOT NULL
        )";

        if (!$this->dbcon->query($createQuery)) {
            die("Failed to create table " . $this->tableName . ": " . $this->dbcon->error);
        }
    }
}


?>