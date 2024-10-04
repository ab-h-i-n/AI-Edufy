<?php

include_once('../../utils/connect.php');

$userID = $_GET['userid'];

$userQuestions = $user->getUserQuestions($userID);

if ($userQuestions) {
    echo json_encode([
        'status' => 404,
        'message' => 'User have questions delete them first',
        'data' => null
    ]);
    return;
}

$result = $user->Delete($userID);

echo json_encode([
    'status' => 200,
    'message' => 'User deleted successfully',
    'data' => null
]);
