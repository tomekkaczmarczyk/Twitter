<?php

require_once '../src/Tweet.php';
require_once '../src/User.php';
require_once '../src/Comment.php';
require_once 'dbConnection.php';
redirectIfNotLoggedIn();


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $tweet_id = $_GET['tweet_id'];
    $otherUserId = $_GET['user'];
    $tweet = Tweet::getTweet($conn, $tweet_id);
    $otherUser = User::getUser($conn, $otherUserId);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['new_comment'])) {
    $tweet_id = $_POST['tweet_id'];
    $text = ($_POST['new_comment']);
    $date = date('Y-m-d h:i:s');
    $comment = new Comment($otherUserId, $tweet_id, $date, $text);
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
        <h3>To jest pojedynczy tweet</h3>
        <?php
        echo "<div class='box'><p class='tweet'>Tweet użytkownika: " . User::getUser($conn, $tweet->getUserId())->getEmail() . "</p>";
        echo "<p class='tweet'>Id tweeta: " . $tweet->getId() . "</p>";
        echo "<p class='tweet'>Data utworzenia: " . $tweet->getCreationDate() . "</p>";
        echo "<p class='tweet'>Treść tweeta:</p>";
        echo "<p class='tweet text'>" . $tweet->getText() . "</p>";
        ?>
    </div>
    <div>
        <h3>Komentarze do tweeta</h3>
        <?php
        $allComments = $tweet->getAllComments($conn);
        if ($allComments) {
            foreach ($allComments as $comment) {
                echo "<div class='box'><p class='comment'>Komentarz dodał: " . User::getUser($conn, $comment->getUserId())->getEmail() . "</p>";
                echo "<p class='comment'>Id komentarza: " . $comment->getId() . "</p>";
                echo "<p class='comment'>Data utworzenia: " . $comment->getCreationDate() . "</p>";
                echo "<p class='comment'>Treść komentarza:</p>";
                echo "<p class='comment text'>" . $comment->getText() . "</p></div>";
            }
        } else {
            echo "<div class='box'><p class='comment'>Ten tweet nie ma jeszcze komentarzy</p></div>";
        }
        ?>
    </div>

    <div>
        <form method="post">
            <label>Dodaj komentarz:
                <textarea name="new_comment"></textarea>
            </label>
            <button type="submit" name="tweet_id" class="btn" value="<?php echo $tweet_id; ?>">Dodaj</button>

        </form>

    </div>
</div>
</body>
</html>
