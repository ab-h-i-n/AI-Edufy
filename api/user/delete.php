<?php

$userID = $_GET['userid'];


echo json_encode([
    'status' => 404,
    'message' => 'User id not found!',
    'data' => $userID
]);
