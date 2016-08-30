<?php

require_once '../src/Tweet.php';
require_once '../src/User.php';
require_once '../src/Comment.php';
require_once 'dbConnection.php';
redirectIfNotLoggedIn();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $tweet_id = $_GET['tweet_id'];
    $tweet = Tweet::getTweet($conn, $tweet_id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['new_comment'])) {
    $tweet_id = $_POST['tweet_id'];
    $text = ($_POST['new_comment']);
    $date = date('Y-m-d h:i:s');
    $comment = new Comment($user_id, $tweet_id, $date, $text);
    $comment->save($conn);
    redirect("tweet_site.php?tweet_id={$tweet_id}");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['usersList'])) {
    redirect('users_list.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['main_site'])) {
    redirect('../index.php');
}
?>

<html>
<head>
    <title>Strona tweeta</title>
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

<div class='box tweet_box'>
    <?php
    echo "<p class='tweet data'>" . $tweet->getCreationDate() . "</p>";
    echo "<p class='tweet autor'>Autor: " . User::getUser($conn, $tweet->getUserId())->getEmail() . "</p>";
    echo "<p class='tweet text'>" . $tweet->getText() . "</p>";
    ?>
</div>
    <h3>Komentarze:</h3>
<div class='comment'>

    <?php
    $allComments = $tweet->getAllComments($conn);
    if ($allComments) {
        foreach ($allComments as $comment) {
            echo "<p class='comment data'>" . $comment->getCreationDate() . "</p>";
            echo "<p class='comment autor'>Autor: " . User::getUser($conn, $comment->getUserId())->getEmail() . "</p>";
            echo "<p class='comment text'>" . $comment->getText() . "</p><hr class='tweet_end'>";
        }
    } else {
        echo "<p class='comment'>Ten tweet nie ma jeszcze komentarzy</p>";
    }
    ?>
</div>

<div>
    <form method="post">
        <label>Dodaj komentarz do tweeta:
            <textarea name="new_comment"></textarea>
        </label>
            <button type="submit" name="tweet_id" value="<?php echo $tweet_id;?>">Dodaj</button>
    </form>

</div>
</div>

</body>
</html>
