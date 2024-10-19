<?php
include_once("../utils/connect.php");

$levels = $user->leaderboard->levels->select('*', '', "points_required ASC");
$levelsData = [];
if (mysqli_num_rows($levels) > 0) {
    while ($row = mysqli_fetch_assoc($levels)) {
        $levelsData[] = $row;
    }
}

?>

<body>
    <div class="contents">
        <div class="title-header">
            <div class="title"> Level Management </div>
            <div class="add-level">Add New</div>
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
                        <button id="<?php echo $level['id']; ?>" class="update update-level pill">Update</button>
                        <button id="<?php echo $level['id']; ?>" class="del del-level pill">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>