<?php

require_once '../src/Tweet.php';
require_once '../src/User.php';
require_once '../src/Comment.php';
require_once '../src/Message.php';
require_once 'dbConnection.php';
redirectIfNotLoggedIn();

if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['usersList'])) {
    redirect('users_list.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['main_site'])) {
    redirect('../index.php');
}
?>

<html>
<head>
    <title>Użytkownicy</title>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class = "menu">

        <p>Zalogowano jako: <a href="userSite.php"><?php echo $loggedUser->getEmail();?></a></p>
        <form method="post">
            <ul>
                <li><button type="submit" name="logout" class="btn">Wyloguj</button></li>
                <li><button type="submit" name="usersList" class="btn">Lista użytkowników</button></li>
                <li><button type="submit" name="main_site" class="btn">Strona główna</button></li>
            </ul>
        </form>

    </div>

<div>
    <h3>Użytkownicy</h3>
    <div class="users_list">
    <?php
    $allUsers = User::getAllUsers($conn);

    foreach ($allUsers as $user) {
        if ($user != $loggedUser) {
            echo "<p><a href='otherUserSite.php?user={$user->getId()}'>" . $user->getEmail() . "</p></a>";
        }
    }

    ?>
    </div>
</div>
</div>
</body>
</html>
