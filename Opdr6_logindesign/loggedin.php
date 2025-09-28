<?php
session_start();
$loggedIn = isset($_SESSION["username"]);

// Handle logout
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>loggedin</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 400px; margin: 40px auto; border: 1px solid #ccc; padding: 20px; }
        .title { font-weight: bold; }
        .subtitle { margin-top: 10px; }
        a, button { text-decoration: none; color: #333; font-size: 16px; }
        button { padding: 5px 15px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Login and Registration</div>
        <div class="subtitle">Welcome to the HOME page!</div>
        <?php if (!$loggedIn): ?>
            <p>You are not logged in. Please login to continue.</p>
            <form action="login.php" method="get">
                <button type="submit">Login</button>
            </form>
        <?php else: ?>
            <p>You are logged in as: <strong><?= htmlspecialchars($_SESSION["username"]) ?></strong></p>
            <form action="loggedin.php" method="post">
                <button type="submit" name="logout">Logout</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>