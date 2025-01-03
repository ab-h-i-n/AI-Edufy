<?php

$questionId = $_GET['id'];
$userId = $_COOKIE['user_id'];
$userId = intval($userId);
$questionId = intval($questionId);

include_once('../utils/connect.php');

$hasCompleted = $user->completed_questions->select('*', "cq.learner_id=$userId AND cq.question_id=$questionId")->num_rows;

$result = $user->question->select('*', "id = $questionId");

$testcasesResult = $user->question->test_cases->select('*', "question_id = $questionId");

$questionDetails = $result->fetch_assoc();
$testcases = [];

$completedDetails;

if ($hasCompleted) {
    $completedDetails = $user->completed_questions->select('*', "cq.learner_id=$userId AND cq.question_id=$questionId")->fetch_assoc();
}

while ($row = $testcasesResult->fetch_assoc()) {
    array_push($testcases, $row);
}

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
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
    <title>Document</title>
</head>

<body id="question-page">

    <?php
    include('../users/learner/header.php');
    include('../common/Toast.php')
        ?>

    <main>
        <?php
        if ($hasCompleted):
            ?>

            <pre class="completed-ans hidden"><?php echo $completedDetails['answer']; ?></pre>

            <pre class="completed-lang hidden"><?php echo $completedDetails['language']; ?></pre>

        <?php endif; ?>
        <div class="top">
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
                <div class="quesiton-testcases">
                    <div id="alltestcases" class="hidden"><?php echo json_encode($testcases); ?></div>
                    <div class="testcase-title">Testcases</div>
                    <div class="testcase-container">
                        <?php
                        foreach ($testcases as $testcase) {
                            ?>
                            <div class="testcase">
                                <div class="testcase-input">
                                    <div class="testcase-label">Input : </div>
                                    <div class="testcase-value"><?php echo $testcase['input']; ?></div>
                                </div>
                                <div class="testcase-output">
                                    <div class="testcase-label">Output : </div>
                                    <div class="testcase-value"><?php echo $testcase['output']; ?></div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div>
                <?php if (!$hasCompleted): ?>
                    <button disabled class="complete">Completed</button>
                <?php endif; ?>
            </div>
        </div>

        <div class="activity-container">

            <iframe scrolling="no" id="oc-editor" frameBorder="0" src="https://onecompiler.com/embed/python?theme=dark&hideTitle=true&hideNewFileOption=true&hideNew=true&codeChangeEvent=true&hideStdin=true&fontSize=20&listenToEvents=true<?php if ($hasCompleted)
                echo '&hideLanguageSelection=true&hideRun=false';
            else
                echo "&hideRun=true" ?>"></iframe>

            <?php if (!$hasCompleted): ?>

                <div class="hint-container">
                    <div class="hint-header">
                        <div class="run">Run</div>
                        <div class="hint">Hint</div>
                        <div class="next-step">Next Step</div>
                    </div>
                    <div class="hint-content">
                        Click the hint button for hints!
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </main>

</body>

</html>