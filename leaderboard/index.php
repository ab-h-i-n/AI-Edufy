<?php
$role = $_COOKIE['role'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/global.css">
    <title>Leaderboard</title>
</head>

<body>

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

    </main>

</body>

</html>