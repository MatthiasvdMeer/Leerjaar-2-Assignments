<?php

require_once __DIR__ . '/dbconnect.php';
require_once __DIR__ . '/GoogleAuthenticator.php';


$ga = new PHPGangsta_GoogleAuthenticator();

$error = '';
$success = '';
$qrCodeUrl = '';
$secret = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Vul gebruikersnaam en wachtwoord in.';
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl('login2fa', $secret);

        $stmt = $pdo->prepare('INSERT INTO users (username, password, 2fa_secret) VALUES (:username, :password, :2fa_secret)');
        try {
            $stmt->execute([
                ':username' => $username,
                ':password' => $passwordHash,
                ':2fa_secret' => $secret,
            ]);
            $success = 'Gebruiker succesvol aangemaakt.';
        } catch (PDOException $e) {
            $error = 'Fout bij opslaan: ' . $e->getMessage();
            $qrCodeUrl = '';
            $secret = '';
        }
    }
}

?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label>
            Username:
            <input type="text" name="username" required>
        </label>
        <br>
        <label>
            Password:
            <input type="password" name="password" required>
        </label>
        <br>
        <input type="submit" value="Register">
    </form>

    <?php if ($qrCodeUrl): ?>

        <h3>Registratie succesvol! Scan deze QR code met Google Authenticator:</h3>

        <img src="<?php echo htmlspecialchars($qrCodeUrl); ?>" alt="QR Code"><br>

        <p>Sla de geheime sleutel op: <?php echo htmlspecialchars($secret); ?></p>

    <?php endif; ?>

    <a href="login.php">Login</a>
</body>
</html>