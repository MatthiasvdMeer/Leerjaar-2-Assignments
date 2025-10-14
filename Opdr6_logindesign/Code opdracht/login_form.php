<?php
session_start();
require_once 'classes/User.php';

if (isset($_POST['login-btn'])) {
$user = new User($_POST['username']);
$user->setPassword($_POST['password']);

$errors = $user->validateUser();

if(count($errors) === 0){
    if(!$user->loginUser()){
        $errors[] = "Gebruikersnaam of wachtwoord incorrect";
    }
}

if(count($errors) > 0){
    $message = implode("\\n", $errors);
    echo "<script>alert('$message'); window.location='login_form.php';</script>";
} else {
    echo "<script>alert('Login succesvol!'); window.location='index.php';</script>";
}
}
?>

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
        <input type="text" id="username" name="username" ><br><br>

        <label for="password">Wachtwoord:</label><br>
        <input type="password" id="password" name="password" ><br><br>

        <input type="submit" name="login-btn" value="Login">
    </form>

    <p>Nog geen account? <a href="register_form.php">Registreer hier</a></p>
    <a href="index.php">Back Home</a>
</body>
</html>