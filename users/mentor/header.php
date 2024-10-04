<?php
$navItems = [
    [
        "text" => 'Home',
        "link" => '/AI-Edufy'
    ],
    [
        "text" => 'Leaderboard',
        "link" => '/AI-Edufy/leaderboard'
    ]
];

?>

<head>
    <script src="../scripts/header.js" defer></script>
</head>

<body>
    <header>
        <div class="container">
            <!-- logo  -->
            <img src="../public/logo.svg" alt="logo" class="logo" />

            <!-- center items  -->
            <div class="center-items">
                <?php foreach ($navItems as $navItem): ?>
                    <a class="item" href=<?php echo $navItem["link"]; ?>><?php echo $navItem["text"]; ?></a>
                <?php endforeach; ?>
            </div>

            <!-- right buttons  -->
            <?php $user = isset($_COOKIE["user_id"]) ?>
            <?php if ($user): ?>
                <form method="post" action="../api/auth/logout.php">
                    <button name="logout" class="pill">Logout</button>
                </form>
            <?php endif; ?>
        </div>
    </header>
</body>