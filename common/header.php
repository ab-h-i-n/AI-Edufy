<?php
$navItems = [
    [
        "text" => 'Home',
        "link" => '/AI-Edufy'
    ],
    [
        "text" => 'Leaderboard',
        "link" => '/AI-Edufy/leaderboard'
    ],
    [
        "text" => 'About Us',
        "link" => '/AI-Edufy/about-us'
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
             <?php if(!$user) : ?>
            <div>
                <a class="login-btn" href="/AI-Edufy/login"><button>LogIn</button></a>
                <a class="signup-btn" href="/AI-Edufy/signup"><button>Sign Up</button></a>
            </div>
            <?php endif; ?>
        </div>
    </header>
</body>