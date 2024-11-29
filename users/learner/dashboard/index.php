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


//total points earned
$usersLB = $user->leaderboard->select('*', "learner_id=$user_id")->fetch_assoc();
$points;
$level_title;
if ($usersLB) {
    $points = $usersLB['points_earned'];
    $level_title = $user->leaderboard->levels->select('level_title', "points_required <= $usersLB[points_earned]", "points_required DESC LIMIT 1")->fetch_assoc()['level_title'];
}

//completed questions
$completedQuestions = $user->completed_questions->select('*', "learner_id=$user_id");
$completedQuestionsArr = [];
while ($row = $completedQuestions->fetch_assoc()) {
    $question = $user->question->select('title', "id=$row[question_id]")->fetch_assoc();
    $row['title'] = $question['title'];
    array_push($completedQuestionsArr, $row);
}

//user details
$userDetails = $user->users->select('*', " id=$user_id ")->fetch_assoc();

$fileModified = time();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/learner-page.css?v=<?php echo $fileModified ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js" type="module" defer></script>
    <script type="module" src="../scripts/learner.js" defer></script>
    <script type="module" src="../scripts/global.js" defer></script>
    <title>Document</title>
</head>

<body id="dashboard">

    <?php include_once('../users/learner/header.php') ?>
    <?php include_once('../common/Toast.php') ?>

    <!-- profile-edit modal -->

    <div class="modal closed">
        <div class="modal-content">
            <div class="modal-close">
                <img src="../public/icons/cross.svg" alt="close">
            </div>

            <div class="modal-title">Update Profile</div>

            <!-- contents  -->
            <form id="update-profile" method="post">

                <!-- profile image -->
                <div class="profile-image">
                    <label for="profile-image-input">
                        <img id="profile-image-photo" src="<?php echo base64($userDetails['profile_image']); ?>"
                            alt="profile image" />
                        <img id="cam" src="../public/icons/camera.svg" alt="camera" />
                    </label>
                    <input class="hidden" type="file" name="profile-image" id="profile-image-input" accept="image/*" />
                </div>

                <!-- name -->
                <div class="input-container">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="<?php echo $userDetails['name']; ?>" required />
                </div>

                <!-- email -->
                <div class="input-container">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo $userDetails['email']; ?>" required />
                </div>

                <!-- submit btn  -->
                <div class="btn-container">
                    <button name="update" type="submit">Update</button>
                </div>
            </form>

        </div>
    </div>

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

        <section class="points-section">
            <div class="points">
                <p id="points"><?php echo $points ?? 0; ?></p>
            </div>
            <div class="level">
                <p id="level"><?php echo $level_title ?? 'Beginner 👶'; ?></p>
            </div>
        </section>
        <section class="profile-section">

            <div class="edit-profile-btn modal-open">
                <img width="30px" height="30px" src="../public/icons/edit.svg" alt="edit proile" />
            </div>

            <div class="name-photo">
                <img alt="profile" src="<?php echo base64($userDetails['profile_image']);  ?>" />
                <div class="username"><?php echo $userDetails['name']; ?></div>
                <div class="email"><?php echo $userDetails['email']; ?></div>
            </div>

        </section>
        <section class="solved-questions-section">
            <h2>Solved Questions</h2>
            <div class="solved-questions">
                <?php if (count($completedQuestionsArr) === 0): ?>
                    <div>You have no solved questions</div>
                <?php endif; ?>
                <?php
                foreach ($completedQuestionsArr as $question) {
                    echo "<a href='http://localhost/AI-Edufy/question/?id=$question[question_id]' class='solved-question'>
                    <p>$question[title]</p>
                    <div class='tags'>
                        <p>$question[points] </p>
                        <p>$question[type] </p>
                    </div>
                </a>";
                }
                ?>
            </div>
        </section>

    </main>



</body>

</html>