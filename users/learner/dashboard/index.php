<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/learner-page.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js" type="module" defer></script>
    <script type="module" src="../scripts/learner.js" defer></script>
    <title>Document</title>
</head>

<body id="learner">

    <?php include_once('../users/learner/header.php') ?>

    <main>

        <section class="count-section">
            <div class="progress-container">
                <canvas id="progress-chart"></canvas>
                <div class="count-text">
                    <p><span id="solved-count">0</span>/3294</p>
                    <p>Solved</p>
                </div>
            </div>
            <div class="difficulty-stats">
                <p>Easy<br><span id="easy-count">4/826</span></p>
                <p>Medium<br><span id="medium-count">6/1723</span></p>
                <p>Hard<br><span id="hard-count">0/745</span></p>
            </div>
        </section>

        <section class="points-section">total points earned and rank</section>
        <section class="profile-section">profile</section>
        <section class="solved-questions-section">question u solved</section>

    </main>

</body>

</html>