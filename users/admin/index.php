<?php
include_once("../utils/connect.php");

// fetch admin details 
$admin_id = $_COOKIE['user_id'];
$admin_result = $user->admin->select('*', 'id=1000');
$adminData;
if (mysqli_num_rows($admin_result) > 0) {
    $adminData = mysqli_fetch_assoc($admin_result);
}

// fetch user details 
$result = $user->users->select('*');
$userData = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $userData[] = $row;
    }
}


// sidemenu items 

$sideMenuItems = [
    [
        "icon" => "../public/icons/users.svg",
        "title" => "users",
        "path" => "/"
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
    <title>Document</title>
</head>

<body id="admin">

    <header>
        <div class="logo">
            <img src="../public/logo.svg" alt="logo" />
        </div>

        <div class="admin-info">
            <div class="email"><?php echo $adminData['email'] ?></div>
        </div>
    </header>

    <main>
        <div class="sidemenu">

            <?php foreach ($sideMenuItems as $items): ?>
                <div>
                    <img src="<?php echo htmlspecialchars($items['icon']) ?>" />
                </div>
            <?php endforeach; ?>

        </div>

        <div class="contents">
            <div class="title"> User Management </div>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>

                <?php foreach ($userData as $user): ?>
                    <tr>
                        <td>
                            <div class="image-name">
                                <div class="user-image"><img src="<?php echo htmlspecialchars($user['profile_image']); ?>">
                                </div>
                                <div class="user-name"><?php echo $user['name']; ?></div>
                            </div>
                        </td>
                        <td>
                            <div class="user-email"><?php echo $user['email']; ?></div>
                        </td>
                        <td>
                            <div class="user-role"><?php echo $user['role']; ?></div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

    </main>
</body>

</html>