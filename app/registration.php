<?php

require_once '../src/User.php';
require_once 'dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) and isset($_POST['password'])) {
        $id = -1;
        $email = $conn->real_escape_string($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $description = $conn->real_escape_string($_POST['description']);
        $isActive = true;
        $user = new User($email, $password, $description, $isActive);
        $user->save($conn);
        redirect('login.php');
    }
}
?>

<html>
<head>
    <title>Formularz rejestracji</title>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="title">
        <h1>Witaj! Zarejestruj się.</h1>
    </div>
    <div class="login">
        <form method="post">
            <p>
                <label for="mail">Email:</label>
                <input type="email" name="email" placeholder="Wpisz email">
            </p>
            <p>
                <label for="password">Hasło:</label>
                <input type="password" name="password" placeholder="Wpisz hasło">
            </p>
            <p>
                <label for="description">Informacje o sobie:</label>
                <textarea name="description" placeholder="Dodaj opis"></textarea>
            </p>
            <p>
                <button type="submit" class="btn" name="register">Zarejestruj</button>
            </p>
            <p><a href="login.php">Jeśli masz już konto przejdź do strony logowania.</a></p>
    </div>
    </form>

</div>
</body>
</html>
