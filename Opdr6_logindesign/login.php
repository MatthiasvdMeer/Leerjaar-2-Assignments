<?php
session_start();
$message = "";

// Voeg de login functie toe
function login($username, $password) {
    $conn = new mysqli("localhost", "root", "", "userdb");
    if ($conn->connect_error) {
        return false;
    }
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        if (password_verify($password, $hashedPassword)) {
            $stmt->close();
            $conn->close();
            return true;
        }
    }
    $stmt->close();
    $conn->close();
    return false;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";
    if (login($username, $password)) {
        $_SESSION["username"] = $username;
        header("Location: loggedin.php");
        exit;
    } else {
        $message = "Invalid login!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 400px; margin: 40px auto; border: 1px solid #ccc; padding: 20px; }
        .title { font-weight: bold; }
        .subtitle { margin-top: 10px; }
        .form-group { margin-bottom: 10px; }
        .error { color: red; }
        a { text-decoration: none; color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Login</div>
        <div class="subtitle">Login here... </div><br>
        <?php if ($message): ?><div class="error"><?= $message ?></div><?php endif; ?>
        <form method="post">
            <div class="form-group">
                Username:<br>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                Password:<br>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <br>
        <form action="register.php" method="get" style="display:inline;">
            <button type="submit">Registration</button>
        </form>
    </div>
</body>
</html>