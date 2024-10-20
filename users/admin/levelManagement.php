<?php
include_once("../utils/connect.php");

$levels = $user->leaderboard->levels->select('*', '', "points_required ASC");
$levelsData = [];
if (mysqli_num_rows($levels) > 0) {
    while ($row = mysqli_fetch_assoc($levels)) {
        $levelsData[] = $row;
    }
}

$updateId = $_GET['update'] ?? null;

$level = null;

if ($updateId) {
    $level = $user->leaderboard->levels->select('*', "id=$updateId")->fetch_assoc();
}

?>

<body>
    <?php if (!$updateId): ?>
        <!-- add new level modal  -->
        <div class="modal closed">
            <div class="modal-content">
                <div class="modal-close">
                    <img src="../public/icons/cross.svg" alt="close">
                </div>

                <div class="modal-title">Add New Level</div>

                <!-- contents  -->
                <form id="level-form" method="post">
                    <div class="level-title">
                        <label for="level-title">Title</label>
                        <input type="text" id="level-title" name="level_title">
                    </div>
                    <div class="level-points">
                        <label for="level-points">Points Required</label>
                        <input type="number" id="level-points" name="level_points">
                    </div>

                    <!-- submit btn  -->
                    <div class="btn-container">
                        <button type="submit">Add</button>
                    </div>
                </form>

            </div>
        <?php else: ?>
            <!-- update level modal  -->
            <div class="modal">
                <div class="modal-content">
                    <div class="modal-close">
                        <img src="../public/icons/cross.svg" alt="close">
                    </div>

                    <div class="modal-title">Update Level</div>

                    <!-- contents  -->
                    <form id="level-form" method="post">
                        <input type="hidden" name="level_id" value="<?php echo $level['id'] ?>">
                        <div class="level-title">
                            <label for="level-title">Title</label>
                            <input type="text" id="level-title" name="level_title"
                                value="<?php echo $level['level_title'] ?>">
                        </div>
                        <div class="level-points">
                            <label for="level-points">Points Required</label>
                            <input type="number" id="level-points" name="level_points"
                                value="<?php echo $level['points_required'] ?>">
                        </div>

                        <!-- submit btn  -->
                        <div class="btn-container">
                            <button type="submit">Update</button>
                        </div>
                    </form>

                </div>
            <?php endif; ?>
        </div>
        <div class="contents">
            <div class="title-header">
                <div class="title"> Level Management </div>
                <div class="add-level modal-open">
                    <span class="add-btn">
                        <span class="add-label">Add New Level</span>
                        <img src="../public/icons/plus.svg" alt="plus">
                    </span>
                </div>
            </div>
            <table class="levels-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>Points Required</th>
                        <th class="actions-th">Actions</th>
                    </tr>
                </thead>
                <?php foreach ($levelsData as $level): ?>
                    <tr>
                        <td>
                            <div class="level-id"><?php echo $level['id']; ?></div>
                        </td>
                        <td>
                            <div class="level-title"><?php echo $level['level_title']; ?></div>
                        </td>
                        <td>
                            <div class="level-points"><?php echo $level['points_required']; ?></div>
                        </td>

                        <td class="actions-td">
                            <a href="http://localhost/AI-Edufy/home/?content=levels&update=<?php echo $level['id']; ?>">
                                <button id="<?php echo $level['id']; ?>" class="update update-level pill">Update</button>
                            </a>
                            <button id="<?php echo $level['id']; ?>" class="del del-level pill">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
</body>