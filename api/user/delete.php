<?php

$userID = $_GET['userid'];

if(!$userID){
    echo json_encode([
        'status'=> 404,
        'message'=> 'User id not found!'
    ]);
}