<?php
$message = "";

// Zet de functie hierboven in deze file
function register($username, $password, $email = null) {
    $conn = new mysqli("localhost", "root", "", "userdb");
    if ($conn->connect_error) {
        return "Database connection failed!";
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        $conn->close();
        return "Username already exists.";
    }
    $stmt->close();

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashedPassword, $email);
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $stmt->close();
        $conn->close();
        return "Registration failed.";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";
    $email = $_POST["email"] ?? null;
    $result = register($username, $password, $email);
    if ($result === true) {
        $message = "Registration successful!";
    } else {
        $message = $result;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
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
        <div class="title">Registration</div>
        <div class="subtitle">Register here...</div><br>
        <?php if ($message): ?><div class="error"><?= $message ?></div><?php endif; ?>
        <form method="post">
            <div class="form-group">
                Username:<br>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                Email:<br>
                <input type="email" name="email">
            </div>
            <div class="form-group">
                Password:<br>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        <br>
    <form action="login.php" method="get" style="display:inline;">
        <button type="submit">to login</button>
    </form>
    </div>
</body>
</html>