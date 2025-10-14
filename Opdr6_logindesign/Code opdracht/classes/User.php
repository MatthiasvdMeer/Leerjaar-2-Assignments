<?php

class User {
    public string $username;
    private string $password;
    public string $email = "";

    // Constructor met optioneel username
    public function __construct(string $username = "") {
        $this->username = trim($username);
    }

    // Setter voor password
    public function setPassword(string $password): void {
        $this->password = $password;
    }

    // Database connectie
    private function dbConnect(): PDO {
        $host = "localhost";
        $dbname = "login";
        $user = "root";
        $pass = "";

        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $conn;
        } catch (PDOException $e) {
            die("Database connectie mislukt: " . $e->getMessage());
        }
    }

    // Input validatie
    public function validateUser(): array {
    $errors = [];
    if (empty($this->username)) {
        $errors[] = "Username is verplicht";
    } else if (strlen($this->username) < 3 || strlen($this->username) > 50) {
    $errors[] = "Username moet tussen 3 en 50 tekens zijn.";
}

    if (empty($this->password)) {
        $errors[] = "Wachtwoord is verplicht";
    }

    return $errors;
}

    // Registratie
    public function registerUser(): array {
        $errors = [];
        $conn = $this->dbConnect();

        // Check of username al bestaat
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username");
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $errors[] = "Gebruikersnaam bestaat al";
        } else {
            // Sla nieuwe user op met gehasht wachtwoord
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO user (username, password, email) VALUES (:username, :password, :email)");
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':email', $this->email);
            $stmt->execute();
        }

        return $errors;
    }

    // Login
    public function loginUser(): bool {
    $conn = $this->dbConnect();

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username");
    $stmt->bindParam(':username', $this->username);
    $stmt->execute();

    $user = $stmt->fetch();

    if ($user && isset($user['password']) && password_verify($this->password, $user['password'])) {
        // Sla veilige sessie-info op
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];

        // LET OP: plaintext wachtwoord opslaan — alleen voor lokaal testen/schoolopdracht
        $_SESSION['password_plain'] = $this->password;

        // Regenerate session id om session fixation te verminderen
        if (function_exists('session_regenerate_id')) {
            session_regenerate_id(true);
        }

        return true;
    }

    return false;
}

    // Check of gebruiker ingelogd is
    public function isLoggedIn(): bool {
        return isset($_SESSION['username']);
    }

public function showUser(): void {
    if (!$this->isLoggedIn()) {
        echo '<a href="login_form.php">Ga naar de inlogpagina</a>';
        return;
    }

    $plain = $_SESSION['password_plain'] ?? '';

    echo "Gebruikersnaam: " . htmlspecialchars($_SESSION['username']) . "<br>";
    echo "Email: " . htmlspecialchars($_SESSION['email']) . "<br>";
    echo "Wachtwoord: " . htmlspecialchars($plain) . "<br>";
    echo '<a href="index.php?logout=true">Log out</a>';
}

    // Logout
    public function logout(): void {
        $_SESSION = [];
        session_destroy();
        header("Location: login_form.php");
        exit;
    }
}
?>
