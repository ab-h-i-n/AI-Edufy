<?php
    include_once('../utils/connect.php');
    $userId = $_COOKIE['user_id'];
    $userQuestions = $user->getUserQuestions($userId);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/mentor-page.css">
    <title>Document</title>
</head>
<body id="mentor">
    <?php include('../common/header.php') ?>

    <main>

        <!-- questions section  -->
         <section class="question-section">
            <!-- title  -->
             <p class="title">My Questions</p>
             <!-- quesitons  -->
              <div class="questions-container">
                <?php foreach ($userQuestions as $question) : ?>
                    <div>
                        <!-- question title  -->
                         <p class="ques_title"><?php echo $question['title']; ?></p>
                         <!-- question description  -->
                          <p><?php echo $question['description']; ?></p>
                    </div>
                <?php endforeach; ?>
              </div>
         </section>

        <!-- side section  -->
         <section class="side-section"></section>

    </main>

</body>
</html>