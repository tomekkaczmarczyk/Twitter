<?php

require_once '../src/User.php';
require_once '../src/Message.php';
require_once 'dbConnection.php';
redirectIfNotLoggedIn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = ($_POST['new_message']);
    $date = date('Y-m-d h:i:s');
    $addresserId = $_POST['addreser'];
    $message = new Message($user_id, $addresserId, $text, $date);
    $message->save($conn);
    redirect('messagesSite.php');
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
    <title>Wiadomości</title>
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
        <form method="post">
            <p>
                <label>Do:
                    <select name="addreser">
                        <?php
                        $allUsers = User::getAllUsers($conn);
                        foreach ($allUsers as $user) {
                            $id = $user->getId();
                            if ($id != $user_id) {
                                echo "<option value='{$id}'>" . $user->getEmail() . "</option>";
                            }
                        }
                        ?>
                    </select>
                </label>
            </p>
            <p>
                <label>Treść wiadomości:<br>
                    <textarea name="new_message"></textarea>
                </label>
            </p>
            <p>
                <button type="submit" name="send_message">Wyślij</button>
            </p>
        </form>
    </div>
</div>
</body>
</html>
