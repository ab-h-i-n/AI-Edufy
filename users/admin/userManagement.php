<?php
include_once("../utils/connect.php");

// fetch user details 
$result = $user->users->select('*' , 'role != "admin"');
$userData = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $userData[] = $row;
    }
}

?>

<body>
    <div class="contents">
        <div class="title"> User Management </div>
        <table class="users-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="actions-th">Actions</th>
                </tr>
            </thead>

            <?php foreach ($userData as $user): ?>
                <tr>
                    <td>
                        <div class="image-name">
                            <div class="user-image">
                                <img class="profile-image" src="<?php echo base64($user['profile_image']); ?>">
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
                    <td class="actions-td">
                        <button id="<?php echo $user['id']; ?>" class="del del-user pill">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>