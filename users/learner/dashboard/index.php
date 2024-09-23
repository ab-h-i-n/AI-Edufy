<?php
include_once('../utils/connect.php');
$user_id = $_COOKIE['user_id'];
$noOfEasyQuestions = $user->getNumberOfQuestions("easy", $user_id);
$noOfMediumQuestions = $user->getNumberOfQuestions('medium', $user_id);
$noOfHardQuestions = $user->getNumberOfQuestions('hard', $user_id);

$totalQuestionsSolved = $noOfEasyQuestions[0] + $noOfMediumQuestions[0] + $noOfHardQuestions[0];
$totalQuestions = $noOfEasyQuestions[1] + $noOfMediumQuestions[1] + $noOfHardQuestions[1];

// Calculate the solved questions for chart
$easySolved = $noOfEasyQuestions[0];
$mediumSolved = $noOfMediumQuestions[0];
$hardSolved = $noOfHardQuestions[0];

// Total questions for each difficulty
$easyTotal = $noOfEasyQuestions[1];
$mediumTotal = $noOfMediumQuestions[1];
$hardTotal = $noOfHardQuestions[1];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/learner-page.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js" type="module" defer></script>
    <script type="module" src="../scripts/learner.js" defer></script>
    <title>Document</title>
</head>

<body id="dashboard">

    <?php include_once('../users/learner/header.php') ?>

    <main>

        <section class="count-section">
            <div class="progress-container">
                <canvas id="progress-chart"></canvas>
                <div class="count-text">
                    <p><span
                            id="solved-count"><?php echo $totalQuestionsSolved; ?></span>/<?php echo $totalQuestions; ?>
                    </p>
                    <p>Solved</p>
                </div>
            </div>
            <div class="difficulty-stats">
                <p>Easy<br>
                    <span id="easy-solved"><?php echo $easySolved; ?></span>/
                    <span id="easy-total"><?php echo $easyTotal; ?></span>
                </p>
                <p>Medium<br>
                    <span id="medium-solved"><?php echo $mediumSolved; ?></span>/
                    <span id="medium-total"><?php echo $mediumTotal; ?></span>
                </p>
                <p>Hard<br>
                    <span id="hard-solved"><?php echo $hardSolved; ?></span>/
                    <span id="hard-total"><?php echo $hardTotal; ?></span>
                </p>
            </div>

        </section>

        <section class="points-section">total points earned and rank</section>
        <section class="profile-section">profile</section>
        <section class="solved-questions-section">questions you solved</section>

    </main>



</body>

</html>