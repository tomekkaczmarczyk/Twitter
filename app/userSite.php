<?php

require_once '../src/Tweet.php';
require_once '../src/User.php';
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

    <h1>
        To jest strona użytkownika: <a href="userSite.php"><?php echo $loggedUser->getEmail(); ?></a>.
    </h1>
    <div>
        <p>Informacje:</p>
        <p><?php echo $loggedUser->getDescription(); ?></p>
        <form action="editUser.php">
            <button class="btn" type="submit">Edytuj informacje</button>
        </form>
        <hr>
    </div>

    <div class="links">
        <h3>Wszystkie Tweety <a href="userSite.php"><?php echo $loggedUser->getEmail(); ?></a>:</h3>
        <?php
        $allTweets = $loggedUser->getAllTweets($conn);
        if ($allTweets) {
            foreach ($allTweets as $tweet) {
                echo "<p class='box'><a href='tweet_site.php?tweet_id={$tweet->getId()}'>{$tweet->getText()}</a></p>";
            }
        } else {
            echo "Nie masz jeszcze żadnych tweetów";
        }

        ?>
    </div>
    <div>
        <form action="messagesSite.php">
            <button type="submit" class="btn" name="messages">Zobacz wiadomości</button>
        </form>
    </div>
</div>
</body>
</html>
