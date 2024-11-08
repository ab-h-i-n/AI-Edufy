<?php
include_once('../utils/connect.php');
$userId = $_COOKIE['user_id'];
$userQuestions = $user->getUserQuestions($userId);
$userDetails = $user->users->select('*', " id=$userId ")->fetch_assoc();

//updating question details
$quesId = $_GET['update'] ?? null;
$updateQuestion;
if ($quesId) {
    $updateQuestion = $user->question->select('*', " id=$quesId ");
    $updateQuestionTestcases = $user->question->test_cases->select('*', " question_id=$quesId ");
    $updateQuestion = $updateQuestion->fetch_assoc();
    $updateQuestion['test_cases'] = [];

    if ($updateQuestion) {
        while ($row = $updateQuestionTestcases->fetch_assoc()) {
            array_push($updateQuestion['test_cases'], $row);
        }
    }

    if (!$updateQuestion) {
        echo "<script>alert('Question not found')</script>";
    }

    echo "<script> console.log(" . json_encode($updateQuestion) . ") </script>";
}


$time = time();


?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/global.css?t=<?php echo $time; ?>">
    <link rel="stylesheet" href="../styles/mentor-page.css">
    <script src="../scripts/global.js" type="module" defer></script>
    <script src="../scripts/mentor.js" type="module" defer></script>
    <title>Document</title>
</head>

<body id="mentor">
    <?php include('header.php');
    include('../common/Toast.php'); ?>

    <main>

        <?php
        $type = $_GET['type'] ?? null;
        $upId = $_GET['update'] ?? null;
        if ($type == "update"):
            ?>
            <!-- update question modal  -->
            <div class="modal">
                <div class="modal-content">
                    <div class="modal-close">
                        <img src="../public/icons/cross.svg" alt="close">
                    </div>

                    <div class="modal-title">Update Question</div>

                    <!-- contents  -->
                    <form id="create-question" method="post">
                        <input type="hidden" id="user-id" name="user-id" value="<?php echo $userId; ?>" />
                        <input type="hidden" id="ques-id" name="ques-id" value="<?php echo $updateQuestion['id']; ?>" />
                        <div class="left">
                            <div class="question-title">
                                <label for="ques-title">Title</label>
                                <input type="text" id="ques-title" name="ques-title"
                                    value="<?php echo $updateQuestion['title']; ?>">
                            </div>
                            <div class="question-desc">
                                <label for="ques-desc">Description</label>
                                <textarea id="ques-desc"
                                    name="ques-desc"><?php echo $updateQuestion['description']; ?></textarea>
                            </div>
                            <div class="type">
                                <label for="ques-type">Type</label>
                                <select name="ques-type" id="ques-type">
                                    <option value="easy" <?php if ($updateQuestion['type'] == 'easy')
                                        echo "selected"; ?>>Easy
                                    </option>
                                    <option value="medium" <?php if ($updateQuestion['type'] == 'medium')
                                        echo "selected"; ?>>
                                        Medium</option>
                                    <option value="hard" <?php if ($updateQuestion['type'] == 'hard')
                                        echo "selected"; ?>>Hard
                                    </option>
                                </select>
                            </div>
                            <div class="points">
                                <label for="ques-points">Points</label>
                                <input type="number" id="ques-points" name="ques-points"
                                    value="<?php echo $updateQuestion['points']; ?>">
                            </div>
                        </div>

                        <div class="right">
                            <div class="test-cases">
                                <label>Test Cases</label>
                                <div class="test-cases-container">
                                    <div class="test-case">
                                        <label>Input</label>
                                        <input type="text" name="input[]" placeholder="Input"
                                            value="<?php echo $updateQuestion['test_cases'][0]['input']; ?>">
                                        <label>Output</label>
                                        <input type="text" name="output[]" placeholder="Output"
                                            value="<?php echo $updateQuestion['test_cases'][0]['output']; ?>">
                                    </div>
                                    <?php if (count($updateQuestion['test_cases']) > 0): ?>
                                        <?php foreach (array_slice($updateQuestion['test_cases'], 1) as $testCase): ?>
                                            <div class="test-case">
                                                <input type="hidden" name="test-case-id[]" value="<?php echo $testCase['id']; ?>">
                                                <label>Input</label>
                                                <input type="text" name="input[]" placeholder="Input"
                                                    value="<?php echo $testCase['input']; ?>">
                                                <label>Output</label>
                                                <input type="text" name="output[]" placeholder="Output"
                                                    value="<?php echo $testCase['output']; ?>">
                                                <div class="add-btn-container remove-btn">
                                                    <span class="add-btn">
                                                        <span class="add-label">Remove</span>
                                                        <img src="../public/icons/minus.svg" alt="minus">
                                                    </span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </div>
                                <!-- add test case btn  -->
                                <!-- <div id="add-test-case" class="add-btn-container">
                                    <span class="add-btn">
                                        <span class="add-label">Add Test Cases</span>
                                        <img src="../public/icons/plus.svg" alt="plus">
                                    </span>
                                </div> -->
                                <div>
                                    <span></span>
                                </div>
                            </div>
                        </div>

                        <!-- submit btn  -->
                        <div class="btn-container">
                            <button name="update" type="submit">Update</button>
                            <button name="delete" type="button">Delete</button>
                        </div>
                    </form>

                </div>
            </div>
        <?php elseif ($type == "edit"): ?>
            <!-- profile-edit modal -->
            <div class="modal ">
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
                                <img id="profile-image-photo" src="<?php echo $userDetails['profile_image']; ?>"
                                    alt="profile image" />
                                <img id="cam" src="../public/icons/camera.svg" alt="camera" />
                            </label>
                            <input class="hidden" type="file" name="profile-image" id="profile-image-input"
                                accept="image/*" />
                        </div>

                        <!-- name -->
                        <div class="input-container">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="<?php echo $userDetails['name']; ?>" required />
                        </div>

                        <!-- email -->
                        <div class="input-container">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="<?php echo $userDetails['email']; ?>"
                                required />
                        </div>

                        <!-- submit btn  -->
                        <div class="btn-container">
                            <button name="update" type="submit">Update</button>
                        </div>
                    </form>

                </div>
            </div><!-- profile-edit modal -->

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
                                <img id="profile-image-photo" src="<?php echo $userDetails['profile_image']; ?>"
                                    alt="profile image" />
                                <img id="cam" src="../public/icons/camera.svg" alt="camera" />
                            </label>
                            <input class="hidden" type="file" name="profile-image" id="profile-image-input"
                                accept="image/*" />
                        </div>

                        <!-- name -->
                        <div class="input-container">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="<?php echo $userDetails['name']; ?>" required />
                        </div>

                        <!-- email -->
                        <div class="input-container">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="<?php echo $userDetails['email']; ?>"
                                required />
                        </div>

                        <!-- submit btn  -->
                        <div class="btn-container">
                            <button name="update" type="submit">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        <?php else: ?>
            <!-- create new question modal  -->
            <div class="modal closed">
                <div class="modal-content">
                    <div class="modal-close">
                        <img src="../public/icons/cross.svg" alt="close">
                    </div>

                    <div class="modal-title">Create New Question</div>

                    <!-- contents  -->
                    <form id="create-question" method="post">
                        <input type="hidden" id="user-id" name="user-id" value="<?php echo $userId; ?>" />
                        <div class="left">
                            <div class="question-title">
                                <label for="ques-title">Title</label>
                                <input type="text" id="ques-title" name="ques-title">
                            </div>
                            <div class="question-desc">
                                <label for="ques-desc">Description</label>
                                <textarea id="ques-desc" name="ques-desc"></textarea>
                            </div>
                            <div class="type">
                                <label for="ques-type">Type</label>
                                <select name="ques-type" id="ques-type">
                                    <option value="easy">Easy</option>
                                    <option value="medium">Medium</option>
                                    <option value="hard">Hard</option>
                                </select>
                            </div>
                            <div class="points">
                                <label for="ques-points">Points</label>
                                <input type="number" id="ques-points" name="ques-points">
                            </div>
                        </div>

                        <div class="right">
                            <div class="test-cases">
                                <label>Test Cases</label>
                                <div class="test-cases-container">
                                    <div class="test-case">
                                        <label>Input</label>
                                        <input type="text" name="input[]" placeholder="Input">
                                        <label>Output</label>
                                        <input type="text" name="output[]" placeholder="Output">
                                    </div>
                                </div>
                                <!-- add test case btn  -->
                                <!-- <div id="add-test-case" class="add-btn-container">
                                    <span class="add-btn">
                                        <span class="add-label">Add Test Cases</span>
                                        <img src="../public/icons/plus.svg" alt="plus">
                                    </span>
                                </div> -->
                                <div>
                                    <span></span>
                                </div>
                            </div>
                        </div>

                        <!-- submit btn  -->
                        <div class="btn-container">
                            <button type="submit">Create</button>
                        </div>
                    </form>

                </div>
            </div>
        <?php endif; ?>

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
                        echo "<a class='question-link' href='http://localhost/AI-Edufy/home?type=update&update=$question[id]'>";
                        include('../common/questionBox.php');
                        echo "</a>";
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
        <section class="side-section">

            <a  href="http://localhost/AI-Edufy/home?type=edit" class="edit-profile-btn">
                <img width="30px" height="30px" src="../public/icons/edit.svg" alt="edit proile" />
            </a>

            <div class="name-photo">
                <img alt="profile" src="<?php echo $userDetails['profile_image']; ?>" />
                <div class="username"><?php echo $userDetails['name']; ?></div>
                <div class="email"><?php echo $userDetails['email']; ?></div>
            </div>
        </section>

    </main>

</body>

</html>