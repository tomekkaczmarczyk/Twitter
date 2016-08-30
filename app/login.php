<?php

require_once '../src/User.php';
require_once 'dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) and isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $loggedUser = User::logIn($conn, $email, $password);
        if ($loggedUser) {
            $_SESSION['user_id'] = $loggedUser->getId();
            redirect('../index.php');
        } else {
            echo "Błędny e-mail lub hasło.<br>";
        }
    } else {
        echo "Błędny e-mail lub hasło.<br>";
    }
}
?>

<html>
<head>
    <title>Strona logowania</title>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="title">
        <h1>Witaj! Zaloguj się.</h1>
    </div>
    <div class="login">
        <form method="post">
            <p>
                <label for="mail">e-mail</label>
                <input type="email" name="email" placeholder="Wpisz e-mail">
            </p>
            <p>
                <label for="password">hasło</label>
                <input type="password" name="password" placeholder="Wpisz hasło">
            </p>
            <p>
                <button type="submit" name="login" class="btn">Zaloguj</button>
            </p>
            <p>
                <a href="registration.php">Jeśli nie masz konta zarejestruj się!</a>
            </p>
        </form>
    </div>
</div>
</body>
</html>

