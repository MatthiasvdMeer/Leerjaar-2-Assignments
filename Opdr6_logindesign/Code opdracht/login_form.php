
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Login Pagina</title>
</head>
<body>
    <h2>Login</h2>
 <form method="post" action="">
        <label for="username">Gebruikersnaam:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Wachtwoord:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" name="login-btn" value="Login">
    </form>

    <p>Nog geen account? <a href="register_form.php">Registreer hier</a></p>

<?php
    require_once 'classes/User.php';

    if (isset($_POST['login-btn'])) {
        $user = new User();
        $user->username = $_POST['username'];
        $user->setPassword($_POST['password']);

        $errors = $user->validateUser();

        if (count($errors) == 0) {
            if ($user->loginUser()) {
                header("Location: index.php?login=success");
                exit;
            } else {
                echo "<p style='color:red;'>Login mislukt!</p>";
            }
        } else {
            foreach ($errors as $error) {
                echo "<p style='color:red;'>$error</p>";
            }
        }
    }
?>
</body>
</html>