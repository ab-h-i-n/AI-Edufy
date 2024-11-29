<?php
$user_id = $_COOKIE['user_id'];
include_once('../utils/connect.php');
$allQuestions = $user->getAllQuestions();

$completedQuestions = $user->completed_questions->select('*', "learner_id=$user_id");
$completedQuestionsArr = [];

while ($row = $completedQuestions->fetch_assoc()) {
    $completedQuestionsArr [] = $row['question_id'];
}

foreach ($allQuestions as &$question) { 
    $question['isCompleted'] = in_array($question['id'], $completedQuestionsArr);
}
unset($question);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/learner-page.css">
    <script type="module" src="../scripts/learner.js" defer></script>
    <title>Document</title>
</head>

<body id="home">

    <?php include_once('header.php') ?>

    <main>

        <div class="questions-container">
            <?php
            if (isset($allQuestions)):

                foreach ($allQuestions as $question):
                    ?>

                    <a href="<?php echo "http://localhost/AI-Edufy/question?id=" . $question['id']; ?>">

                        <?php
                        include('../common/questionBox.php');
                        ?>

                    </a>

                <?php endforeach; ?>
                <?php
            else:
                ?>

                <div>No Questions</div>

            <?php endif ?>


        </div>


    </main>

</body>

</html>