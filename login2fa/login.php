<?php
require_once __DIR__ . '/dbconnect.php';
require_once __DIR__ . '/GoogleAuthenticator.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$ga = new PHPGangsta_GoogleAuthenticator();

$error = '';
$success = '';
$show2fa = false;

// Stap 1: username + password (niet de 2fa form)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password']) && !isset($_POST['2fa_code'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Vul gebruikersnaam en wachtwoord in.';
    } else {
        // haal gebruiker uit de database
        $stmt = $pdo->prepare('SELECT id, password, `2fa_secret` FROM users WHERE username = :username');
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
    $error = 'Onjuiste gebruikersnaam of wachtwoord.';
} else {
    $_SESSION['2fa_user_id'] = $user['id'];
    $_SESSION['2fa_secret'] = $user['2fa_secret'];

    // redirect met step=2 zodat de 2FA-form via GET getoond wordt
    header('Location: ' . $_SERVER['PHP_SELF'] . '?step=2');
    exit;
}
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['2fa_code'])) {
    // haal invoer veilig op
    $raw = $_POST['2fa_code'];
    $code = trim((string)$raw);

    // negeer lege submits (bv. browser herstuurt vorige POST) — toon geen foutmelding meteen
    if ($code === '') {
        // geen actie; laat formulier opnieuw zien
    } elseif (!preg_match('/^\d{6}$/', $code)) {
        $error = 'Voer een geldige 6-cijferige code in.';
    } else {
        // bepaal secret (session of fallback via hidden user-id)
        $secret = $_SESSION['2fa_secret'] ?? null;
        if (!$secret && !empty($_POST['2fa_user_id'])) {
            $stmt = $pdo->prepare('SELECT `2fa_secret` FROM users WHERE id = :id');
            $stmt->execute([':id' => $_POST['2fa_user_id']]);
            $row = $stmt->fetch();
            $secret = $row['2fa_secret'] ?? null;
        }

        if (empty($secret)) {
            $error = 'Geen geldige 2FA-sessie. Log opnieuw in.';
        } else {
            $valid = $ga->verifyCode($secret, $code, 2);
            if ($valid) {
                $_SESSION['user_id'] = $_SESSION['2fa_user_id'] ?? $_POST['2fa_user_id'];
                unset($_SESSION['2fa_user_id'], $_SESSION['2fa_secret']);
                $success = 'Succesvol ingelogd.';
            } else {
                $error = 'Onjuiste 2FA-code.';
            }
        }
    }
}
$step = isset($_GET['step']) ? $_GET['step'] : '';
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
        <p><a href="protected.php">Ga naar beveiligde pagina</a> of <a href="logout.php">Log uit</a></p>
    <?php endif; ?>

    <?php if (empty($step) && empty($_SESSION['2fa_user_id']) && empty($success)): ?>
        <!-- Stap 1: username + password -->
        <form method="post" action="">
            <label>Username:
                <input type="text" name="username" required>
            </label>
            <br>
            <label>Password:
                <input type="password" name="password" required>
            </label>
            <br>
            <input type="submit" value="Login">
        </form>
        <p><a href="registreren.php">Register</a></p>

<?php elseif (($step === '2' || !empty($_SESSION['2fa_user_id'])) && empty($success)): ?>
        <!-- Stap 2: 2FA code invoeren -->
        <p>Voer de 6-cijferige code uit je authenticator-app in:</p>
        <form method="post" action="">
            <input type="hidden" name="2fa_user_id" value="<?php echo htmlspecialchars($_SESSION['2fa_user_id'] ?? ''); ?>">
            <label>2FA code:
                <input type="text" name="2fa_code" pattern="\d{6}" inputmode="numeric" required>
            </label>
            <br>
            <input type="submit" value="Verifieer 2FA">
        </form>
    <?php endif; ?>
</body>
</html>