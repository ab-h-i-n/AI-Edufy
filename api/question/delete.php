<?php

include_once('../../utils/connect.php');

try {

    $ques_id = $_GET['id'];

    // Step 1: Delete from completed_questions if exists
    $completedQuestionsDeleted = $user->completed_questions->delete("question_id = $ques_id", true);
    
    // Step 2: Delete from test_cases if exists
    $testCasesDeleted = $user->question->test_cases->delete("question_id = $ques_id" , true);
    
    // Step 3: Delete from questions
    $questionsDeleted = $user->question->delete($ques_id , false);

    // Check if deletions were successful
    if ($completedQuestionsDeleted || $testCasesDeleted || $questionsDeleted) {
        echo json_encode([
            'status' => 200,
            'message' => 'Question deleted successfully',
            'data' => null
        ]);
    } else {
        echo json_encode([
            'status' => 404,
            'message' => 'No question found to delete',
            'data' => null
        ]);
    }
} catch (Exception $e) {
    // Handle exceptions and return an error message
    echo json_encode([
        'status' => 500,
        'message' => 'An error occurred: ' . $e->getMessage(),
        'data' => null
    ]);
}
