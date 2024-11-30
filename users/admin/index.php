<?php
include_once("../utils/connect.php");
include_once("../api/auth/logout.php");

// fetch admin details 
$admin_id = $_COOKIE['user_id'];
$adminData = $user->users->select('*', 'id = ' . $admin_id)->fetch_assoc();

// sidemenu items 

$sideMenuItems = [
    [
        "icon" => "../public/icons/users.svg",
        "title" => "users",
        "path" => "/AI-Edufy/home/"
    ],
    [
        "icon" => "../public/icons/question.svg",
        "title" => "questions",
        "path" => "/AI-Edufy/home/?content=questions"
    ],
    [
        "icon" => "../public/icons/level.svg",
        "title" => "levels",
        "path" => "/AI-Edufy/home/?content=levels"
    ]
];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/admin-page.css">
    <link rel="stylesheet" href="../styles/global.css">
    <script type="module" src="../scripts/global.js"></script>
    <script src="../scripts/admin.js" type="module" defer></script>
    <title>Document</title>
</head>

<body id="admin">
    <?php include('../common/Toast.php') ?>
    <header>
        <div class="logo">
            <img src="../public/logo.svg" alt="logo" />
        </div>

        <div class="admin-info">
            <div class="email"><?php echo $adminData['email'] ?></div>
            <form action="../api/auth/logout.php" method="post">
                <button name="logout" class="pill">Logout</button>
            </form>
        </div>
    </header>

    <main>
        <div class="sidemenu">

            <?php foreach ($sideMenuItems as $items): ?>
                <a href="<?php echo $items['path']; ?>" class="menu-item">
                    <img src="<?php echo htmlspecialchars($items['icon']) ?>" />
                </a>
            <?php endforeach; ?>

        </div>

        <?php
        $content = $_GET['content'] ?? 'none';

        switch ($content) {
            case 'questions':
                include('questionManagement.php');
                break;
            case 'levels':
                include('levelManagement.php');
                break;
            default:
                include('userManagement.php');
        }
        ?>

    </main>
</body>

</html>