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

                    <a class="queslink" href="<?php echo "http://localhost/AI-Edufy/question?id=" . $question['id']; ?>">

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