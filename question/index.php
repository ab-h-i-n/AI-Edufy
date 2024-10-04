<?php

$questionId = $_GET['id'];

include_once('../utils/connect.php');

$result = $user->question->select('*', "id = $questionId");

$questionDetails = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/question-page.css">
    <title>Document</title>
</head>

<body id="question-page">

    <?php
    include('../users/learner/header.php');
    ?>

    <main>

        <div class="question-container">
            <div class="question-title">
                <?php echo $questionDetails['title']; ?>
            </div>
            <div class="question-desc">
                <?php echo $questionDetails['description']; ?>
            </div>
            <div class="question-tags">
                <div class="question-points">
                    <?php echo $questionDetails['points']; ?>
                </div>
                <div class="question-language">
                    <?php echo $questionDetails['language']; ?>
                </div>
                <div class="question-type">
                    <?php echo $questionDetails['type']; ?>
                </div>
            </div>
        </div>

        <div class="activity-container">
            
        </div>

    </main>

</body>

</html>