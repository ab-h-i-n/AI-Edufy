<?php

include_once("../../utils/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $decoded = json_decode(file_get_contents('php://input'), true);

    $quesTitle = $decoded['title'];
    $quesDesc = $decoded['description'];
    $quesType = $decoded['type'];
    $quesLang = $decoded['language'];
    $quesPoints = $decoded['points'];
    $quesTestCases = $decoded['testCases'];
    $userId = $decoded['userId'];

    $questionInserted = $user->question->insert([
        "title" => $quesTitle,
        "description" => $quesDesc,
        "type" => $quesType,
        "language" => $quesLang,
        "points" => $quesPoints,
        "mentor_id" => $userId
    ]);

    if (!$questionInserted) {
        echo json_encode([
            "status" => 500,
            "msg" => "Failed to create question"
        ]);
        return;
    }

    foreach ($quesTestCases as $testCase) {
        $testCaseInsert = $user->question->test_cases->insert([
            "input" => $testCase['input'],
            "output" => $testCase['output'],
            "question_id" => $questionInserted
        ]);

        if (!$testCaseInsert) {
            echo json_encode([
                "status" => 500,
                "msg" => "Failed to create test cases"
            ]);
            return;
        }
    }

    echo json_encode([
        "status" => 200,
        "msg" => "Question created",
        "data" => $questionInserted
    ]);

} else {
    echo json_encode([
        "status" => 500,
        "msg" => "Invalid request method"
    ]);
}

?>