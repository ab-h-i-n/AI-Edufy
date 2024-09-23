<?php
include_once('../utils/connect.php');
$allQuestions = $user->getAllQuestions();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/learner-page.css">
    <title>Document</title>
</head>

<body id="home">

    <?php include_once('header.php') ?>

    <main>

        <div class="questions-container">
            <?php
            if (isset($allQuestions)) {

                foreach ($allQuestions as $question) {
                    include('../common/questionBox.php');
                }
            } else {
                ?>

                <div>No Questions</div>

                <?php
            }
            ?>
        </div>

    </main>

</body>

</html>