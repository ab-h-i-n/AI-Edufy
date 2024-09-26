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
    <script src="../scripts/global.js" type="module" defer></script>
    <script src="../scripts/mentor.js" type="module" defer></script>
    <title>Document</title>
</head>

<body id="mentor">
    <?php include('header.php'); include('../common/Toast.php'); ?>

    <main>

        <!-- modal  -->
        <div class="modal closed">
            <div class="modal-content">
                <div class="modal-close">
                    <img src="../public/icons/cross.svg" alt="close">
                </div>

                <div class="modal-title">Create New Question</div>

                <!-- contents  -->
                <form id="create-question" method="post">
                    <div class="left">
                        <div class="question-title">
                            <label for="ques-title">Title</label>
                            <input type="text" id="ques-title" name="ques-title" >
                        </div>
                        <div class="question-desc">
                            <label for="ques-desc">Description</label>
                            <textarea id="ques-desc" name="ques-desc" ></textarea>
                        </div>
                        <div class="type">
                            <label for="ques-type">Type</label>
                            <select name="ques-type" id="ques-type" >
                                <option value="easy">Easy</option>
                                <option value="medium">Medium</option>
                                <option value="hard">Hard</option>
                            </select>
                        </div>
                        <div class="language">
                            <label for="ques-lang">Language</label>
                            <select name="ques-lang" id="ques-lang" >
                                <option value="C">C</option>
                                <option value="C++">C++</option>
                            </select>
                        </div>
                        <div class="points">
                            <label for="ques-points">Points</label>
                            <input type="number" id="ques-points" name="ques-points" >
                        </div>
                    </div>

                    <div class="right">
                        <div class="test-cases">
                            <label>Test Cases</label>
                            <div class="test-cases-container">
                                <div class="test-case">
                                    <label>Input</label>
                                    <input type="text" name="input[]" placeholder="Input" >
                                    <label>Output</label>
                                    <input type="text" name="output[]" placeholder="Output" >
                                </div>
                            </div>
                            <!-- add test case btn  -->
                            <div id="add-test-case" class="add-btn-container">
                                <span class="add-btn">
                                <span class="add-label">Add Test Cases</span>
                                    <img src="../public/icons/plus.svg" alt="plus">
                                </span>
                            </div>
                            <div>
                                <span></span>
                            </div>
                        </div>
                    </div>

                    <!-- submit btn  -->
                     <div class="btn-container">
                        <button type="submit" >Create</button>
                     </div>
                </form>

            </div>
        </div>

        <!-- questions section  -->
        <section class="question-section">
            <!-- title  -->
            <div class="title-container">
                <p class="title">My Questions</p>
                <div class="add-btn-container modal-open">
                    <span class="add-label">ADD NEW</span>
                    <span class="add-btn">
                        <img src="../public/icons/plus.svg" alt="plus">
                    </span>
                </div>
            </div>
            <!-- questions  -->
            <div class="questions-container">
                <?php
                if (isset($userQuestions)) {
                    foreach ($userQuestions as $question) {
                        include('../common/questionBox.php');
                    }
                } else {
                    ?>
                    <div>No Questions</div>
                    <?php
                }
                ?>
            </div>
        </section>

        <!-- side section  -->
        <section class="side-section"></section>

    </main>

</body>

</html>