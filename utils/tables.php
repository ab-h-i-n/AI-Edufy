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

    function select($columns = "*", $where = "", $orderBy = "")
    {
        $query = "SELECT $columns FROM $this->tableName";
        if (!empty($where)) {
            $query .= " WHERE $where";
        }

        if (!empty($orderBy)) {
            $query .= " ORDER BY $orderBy";
        }

        $result = $this->dbcon->query($query);
        if (!$result) {
            die("Error in select query: " . $this->dbcon->error);
        }

        return $result;
    }


    function insert($data)
    {
        // Prepare the SQL statement
        $columns = implode(", ", array_keys($data));
        $placeholders = rtrim(str_repeat('?, ', count($data)), ', '); // Create placeholders
        $query = "INSERT INTO $this->tableName ($columns) VALUES ($placeholders)";

        // Prepare the statement
        $stmt = $this->dbcon->prepare($query);

        // Create a types string based on the data types of the values
        $types = '';
        foreach ($data as $value) {
            if (is_int($value)) {
                $types .= 'i'; // integer
            } elseif (is_float($value)) {
                $types .= 'd'; // double
            } else {
                $types .= 's'; // string
            }
        }

        // Bind parameters dynamically
        $stmt->bind_param($types, ...array_values($data));

        // Execute the statement
        $result = $stmt->execute();

        if (!$result) {
            die("Error in insert query: " . $stmt->error);
        }

        return $this->dbcon->insert_id; // Return the ID of the newly inserted record
    }




    function delete($id, $isDifferentColumn)
    {
        $query = "DELETE FROM " . $this->tableName . " WHERE ";

        if ($isDifferentColumn) {
            $query .= $id;
        } else {
            $query .= "id = " . intval($id);
        }
        $result = $this->dbcon->query($query);

        if (!$result) {
            die("" . $this->dbcon->error);
        }

        return $result;
    }

    function update($data, $where)
    {

        $setClauses = [];

        foreach ($data as $column => $value) {
            $setClauses[] = "$column = '" . $this->dbcon->real_escape_string($value) . "'";
        }

        $setString = implode(", ", $setClauses);

        $query = "UPDATE $this->tableName SET $setString";

        if (!empty($where)) {
            $query .= " WHERE $where";
        }

        $result = $this->dbcon->query($query);

        if (!$result) {
            die("Error in update query: " . $this->dbcon->error);
        }

        return $result;
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
            learner_id INT NOT NULL,
            question_id INT NOT NULL,
            answer MEDIUMTEXT NOT NULL,
            language TEXT NOT NULL,
            FOREIGN KEY (learner_id) REFERENCES USERS(id),
            FOREIGN KEY (question_id) REFERENCES QUESTIONS(id)
        )";

        if (!$this->dbcon->query($createQuery)) {
            die("Failed to create table " . $this->tableName . ": " . $this->dbcon->error);
        }
    }

    function select($columns = "*", $where = "", $orderBy = "")
    {
        $query = "SELECT " . $columns . " FROM " . $this->tableName . " cq JOIN QUESTIONS q ON cq.question_id = q.id";

        if (!empty($where)) {
            $query .= " WHERE " . $where;
        }

        if (!empty($orderBy)) {
            $query .= " ORDER BY " . $orderBy;
        }

        $result = $this->dbcon->query($query);
        if (!$result) {
            die("Error in select query: " . $this->dbcon->error);
        }

        return $result;
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
            FOREIGN KEY (learner_id) REFERENCES USERS(id)
        )";

        if (!$this->dbcon->query($createQuery)) {
            die("Failed to create table " . $this->tableName . ": " . $this->dbcon->error);
        }
    }

    // Function to insert or update leaderboard
    function insert($data)
    {
        // Check if the learner already exists in the leaderboard
        $learner_id = $data['learner_id'];
        $points_earned = $data['points_earned'];

        $checkQuery = "SELECT points_earned FROM $this->tableName WHERE learner_id = '$learner_id'";
        $checkResult = $this->dbcon->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            // Learner exists, update points by adding the current points to the previous points
            $row = $checkResult->fetch_assoc();
            $updated_points = $row['points_earned'] + $points_earned;

            $updateQuery = "UPDATE $this->tableName 
                            SET points_earned = '$updated_points'
                            WHERE learner_id = '$learner_id'";

            $result = $this->dbcon->query($updateQuery);

            if (!$result) {
                die("Error in update query: " . $this->dbcon->error);
            }
        } else {
            // Learner doesn't exist, insert a new record
            $insertQuery = "INSERT INTO $this->tableName (learner_id, points_earned) 
                            VALUES ('$learner_id', '$points_earned')";

            $result = $this->dbcon->query($insertQuery);

            if (!$result) {
                die("Error in insert query: " . $this->dbcon->error);
            }

            return $this->dbcon->insert_id;
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
            level_title VARCHAR(255) NOT NULL,
            points_required INT NOT NULL
        )AUTO_INCREMENT = 1";

        if (!$this->dbcon->query($createQuery)) {
            die("Failed to create table " . $this->tableName . ": " . $this->dbcon->error);
        }
    }
}

?>