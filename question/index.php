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
    <script type="module" src="../scripts/question.js" defer></script>
    <script type="module" src="../utils/gemini.js" defer></script>
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
                <div class="question-type">
                    <?php echo $questionDetails['type']; ?>
                </div>
            </div>
        </div>

        <div class="activity-container">

            <iframe scrolling="no" id="oc-editor" frameBorder="0"
                src="https://onecompiler.com/embed/python?theme=dark&hideTitle=true&disableCopyPaste=true&hideNewFileOption=true&hideNew=true&codeChangeEvent=true&hideStdin=true&fontSize=20"></iframe>

        </div>

    </main>

</body>

</html>