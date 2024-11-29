<?php

include_once("../utils/connect.php");

$role = $_COOKIE['role'] ?? '';
$userId = $_COOKIE['user_id'] ?? '';

$leaderboard = $user->leaderboard->select('*', '', 'points_earned DESC');

$leaderboardData = [];

if (mysqli_num_rows($leaderboard) > 0) {
    while ($row = mysqli_fetch_assoc($leaderboard)) {
        $leaderboardData[] = $row;
    }
}

foreach ($leaderboardData as $key => $data) {
    $learner = $user->users->select('email , profile_image , name', "id = {$data['learner_id']}")->fetch_assoc();
    $leaderboardData[$key]['email'] = $learner['email'];
    $leaderboardData[$key]['profile_image'] = $learner['profile_image'];
    $leaderboardData[$key]['name'] = $learner['name'];
}

foreach ($leaderboardData as $key => $data) {
    $level = $user->leaderboard->levels->select('level_title', "points_required <= {$data['points_earned']}", 'points_required DESC')->fetch_assoc();
    $leaderboardData[$key]['level_title'] = $level['level_title'];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/leaderboard.css">
    <title>Leaderboard</title>
</head>

<body id="leaderboard">
    <?php
    if ($role == 'mentor') {
        include '../users/mentor/header.php';
    } else if ($role == 'learner') {
        include '../users/learner/header.php';
    } else {
        include '../common/header.php';
    }
    ?>

    <main class="container">

        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Profile</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Points</th>
                    <th>Level</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaderboardData as $key => $data) : ?>
                    <tr>
                        <td class="rank">#<?php echo $key + 1 ?></td>
                        <td class="user-image">
                            <img src="<?php echo base64($data['profile_image']); ?>" alt="profile" />
                        </td>
                        <td class="user-name"><?php echo $data['name'] ?> <?php if($data['learner_id'] == $userId) echo "(You)"; ?></td>
                        <td class="user-email"><?php echo $data['email'] ?></td>
                        <td class="user-points"><?php echo $data['points_earned'] ?></td>
                        <td class="level-title"><?php echo $data['level_title'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </main>

</body>

</html>