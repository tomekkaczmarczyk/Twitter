<?php

require_once '../src/Tweet.php';
require_once '../src/User.php';
require_once 'dbConnection.php';
redirectIfNotLoggedIn();
if ($_SERVER['REQUEST_METHOD'] === 'GET' and isset($_GET['user'])) {
    $otherUserId = $_GET['user'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['usersList'])) {
    redirect('users_list.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['main_site'])) {
    redirect('../index.php');
}

$otherUser = User::getUser($conn, $otherUserId);

?>

<html>
<head>
    <title>Strona użytkownika</title>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="menu">

        <p>Zalogowano jako: <a href="userSite.php"><?php echo $loggedUser->getEmail(); ?></a></p>
        <form method="post">
            <ul>
                <li>
                    <button type="submit" name="logout" class="btn">Wyloguj</button>
                </li>
                <li>
                    <button type="submit" name="usersList" class="btn">Lista użytkowników</button>
                </li>
                <li>
                    <button type="submit" name="main_site" class="btn">Strona główna</button>
                </li>
            </ul>
        </form>

    </div>
    <div>
        <h1>
            To jest strona użytkownika: <a href="userSite.php"><?php echo $otherUser->getEmail(); ?></a>.
        </h1>
    </div>
    <div>
        <p>Informacje:</p>
        <p><?php echo $otherUser->getDescription(); ?></p>

    </div>
    <div>
        <h3>Wszystkie Tweety <?php echo $otherUser->getEmail(); ?>:</h3>
        <?php
        $allTweets = $otherUser->getAllTweets($conn);
        if ($allTweets) {
            foreach ($allTweets as $tweet) {
                echo "<a href='tweet_site.php?user={$otherUserId}&tweet_id={$tweet->getId()}'><p>{$tweet->getText()}</p></a>";
            }
        } else {
            echo "Użytkownik nie napisał jeszcze żadnego Tweeta";
        }

        ?>
    </div>
</div>
</body>
</html>
