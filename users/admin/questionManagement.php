<?php
include_once("../utils/connect.php");

// fetch user details 
$questions = $user->getAllQuestions();

?>

<body>
    <div class="contents">
        <div class="title"> Question Management </div>
        <table class="questions-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Posted By</th>
                    <th>Points</th>
                    <th>Type</th>
                    <th>Test Cases</th>
                    <th class="actions-th">Actions</th>
                </tr>
            </thead>

            <?php foreach ($questions as $ques): ?>
                <tr>
                    <td>
                        <div class="ques-title"><?php echo $ques['title']; ?></div>
                    </td>
                    <td>
                        <div class="ques-desc"><?php echo $ques['description']; ?></div>
                    </td>
                    <td>
                        <div class="ques-mentor-name"><?php echo $ques['mentor_name']; ?></div>
                    </td>
                    <td>
                        <div class="ques-points"><?php echo $ques['points']; ?></div>
                    </td>
                    <td>
                        <div class="ques-type"><?php echo $ques['type']; ?></div>
                    </td>
                    <td>
                        <div class="ques-test-cases">

                            <ul>
                                <?php foreach ($ques['test_cases'] as $testCase): ?>
                                    <li>
                                        <span>Input : <?php echo $testCase['input'] ?></span>
                                        <br>
                                        <span>Output : <?php echo $testCase['output'] ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                        </div>
                    </td>
                    <td class="actions-td">
                        <button id="<?php echo $ques['id']; ?>" class="del del-ques pill">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>