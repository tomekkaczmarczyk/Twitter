<?php

require_once 'src/Tweet.php';
require_once 'src/User.php';
require_once 'app/dbConnection.php';
redirectIfNotLoggedIn();

if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['new_tweet'])) {
    $text = ($_POST['new_tweet']);
    $date = date('Y-m-d h:i:s');
    $tweet = new Tweet($user_id, $text, $date);
    $tweet->save($conn);
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['usersList'])) {
    redirect('app/users_list.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['main_site'])) {
    redirect('index.php');
}
?>

<html>
<head>
    <title>Twitter</title>
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="menu">

        <p>Zalogowano jako: <a href="app/userSite.php"><?php echo $loggedUser->getEmail(); ?></a></p>
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
    <div class="title">
        <h1>Witaj na stronie głównej.</h1>
    </div>

    <div class="form">
        <form method="post">
            <p>
                <label>Dodaj tweeta:<br>
                    <textarea name="new_tweet"></textarea>
                </label>
            </p>
            <p>
                <button type="submit" name="add_tweet" class="btn">Dodaj</button>
            </p>
        </form>
    </div>

    <div class="links">
        <h3>Wszystkie Tweety <a href="app/userSite.php"><?php echo $loggedUser->getEmail(); ?></a>:</h3>
        <?php
        $allTweets = $loggedUser->getAllTweets($conn);
        if ($allTweets) {
            foreach ($allTweets as $tweet) {
                echo "<p class='box'><a href='app/tweet_site.php?tweet_id={$tweet->getId()}'>{$tweet->getText()}</a></p>";
            }
        } else {
            echo "Nie masz jeszcze żadnych tweetów";
        }
        ?>
    </div>

</div>
</body>
</html>




