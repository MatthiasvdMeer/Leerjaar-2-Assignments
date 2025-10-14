<?php
session_start();
require_once 'classes/User.php';

if (isset($_POST['register-btn'])) {
    $user = new User(); // username wordt hier direct ingesteld
    $user->username = trim($_POST['username']);
    $user->setPassword($_POST['password']);

    // Valideer input
    $errors = $user->validateUser();

    // Als geen errors, registreer user
    if (count($errors) === 0) {
        $errors = $user->registerUser();
    }

    // Toon errors of redirect naar login
    if (count($errors) > 0) {
        $message = implode("\\n", $errors);
        echo "<script>alert('$message'); window.location='register_form.php';</script>";
    } else {
        echo "<script>alert('User registered successfully'); window.location='login_form.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h3>Register new user</h3>
    <hr>

    <form method="POST" action="">
        <div>
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username">
        </div>
        <div>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password">
        </div>
        <br>
        <div>
            <button type="submit" name="register-btn">Register</button>
        </div>
        <br>
        <a href="login_form.php">Login</a> | <a href="index.php">Home</a>
    </form>
</body>
</html>
