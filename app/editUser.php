<?php

require_once '../src/Tweet.php';
require_once '../src/User.php';
require_once 'dbConnection.php';
redirectIfNotLoggedIn();
if ($_SERVER['REQUEST_METHOD'] === 'POST' and (isset($_POST['edit']))) {
    $text = $_POST['text'];
    $loggedUser->setDescription($text);
    $loggedUser->save($conn);
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
    <title>Edycja danych</title>
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
    <div class="title">
        <h1>Formularz edycji</h1>
    </div>
    <div>
    <p>Aktualny opis:</p>
        <p><?php echo $loggedUser->getDescription();?></p>
        <hr>
    <form action="#" method="post">
        <label>Wpisz nowy opis:
            <textarea name="text"></textarea>
        </label>
        <button type="submit" name="edit" class="btn">Zapisz</button>
    </form>
    </div>
</div>
</body>
</html>
