<?php

include_once "../../utils/connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $decoded = json_decode(file_get_contents('php://input'), true);

    $quesId = $decoded['quesId'];
    $quesTitle = $decoded['title'];
    $quesDesc = $decoded['description'];
    $quesType = $decoded['type'];
    $quesPoints = $decoded['points'];
    $quesTestCases = $decoded['testCases'];
    $userId = $decoded['userId'];

    $questionUpdated = $user->question->update([
        "title" => $quesTitle,
        "description" => $quesDesc,
        "type" => $quesType,
        "points" => $quesPoints,
        "mentor_id" => $userId
    ], "id = $quesId");

    if (!$questionUpdated) {
        echo json_encode([
            "status" => 500,
            "msg" => "Failed to create question"
        ]);
        return;
    }

    foreach ($quesTestCases as $testCase) {
        $testCaseInsert = $user->question->test_cases->update([
            "input" => $testCase['input'],
            "output" => $testCase['output'],
        ],"question_id = $quesId");

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
        "msg" => "Question updated",
        "data" => $questionUpdated
    ]);

} else {
    echo json_encode([
        "status" => 500,
        "msg" => "Invalid request method"
    ]);
}