<?php
    // Functie: classdefinitie User 
    // Auteur: Studentnaam

    class User{

    // Eigenschappen 
    public string $username = "";
    public string $email = "";
    private string $password = "";

    // Voeg dbConnect toe
    private function dbConnect() {
        $servername = "localhost";
        $dbname = "login";
        $user = "root";
        $pass = "";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $conn;
        } catch(PDOException $e) {
            die("Database connectie mislukt: " . $e->getMessage());
        }
    }

        public function setPassword(string $password): void {
    $this->password = $password;
}

        public function registerUser() : array {
        $errors = [];
        $conn = $this->dbConnect();

        if($this->username != ""){
            // Check user exist in database
            $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username");
            $stmt->bindParam(':username', $this->username);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                array_push($errors, "Username bestaat al.");
            } else {
                // username opslaan in tabel user
                $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO user (username, password, email) VALUES (:username, :password, :email)");
                $stmt->bindParam(':username', $this->username);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':email', $this->email);
                $stmt->execute();
            } 
        }
        return $errors;
    }

public function showUser(): void {
    echo "Username: " . htmlspecialchars($this->username) . "<br>";
    echo "Email: " . htmlspecialchars($this->email) . "<br>";
}

function validateUser(){
    $errors=[];

    if (empty($this->username)){
        array_push($errors, "Invalid username");
    } else if (strlen($this->username) < 3 || strlen($this->username) > 50) {
        array_push($errors, "Username moet tussen 3 en 50 tekens zijn.");
    }

    if (empty($this->password)){
        array_push($errors, "Invalid password");
    }

    return $errors;
}

public function loginUser(): bool {
    $conn = $this->dbConnect();

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username");
    $stmt->bindParam(':username', $this->username);
    $stmt->execute();
    
    $user = $stmt->fetch();
    if ($user && password_verify($this->password, $user['password'])) {
        session_start();
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['password'] = $this->password; // Let op: wachtwoord in sessie is niet veilig!
        return true;
    
    } else {
        return false;
    }
   
}

        // Check if the user is already logged in
        public function isLoggedin(): bool {
            // Check if user session has been set
            
            return false;
        }

        public function getUser(string $username): bool {
            // Connect database

		    // Doe SELECT * from user WHERE username = $username

            if (false){
                //Indien gevonden eigenschappen vullen met waarden uit de SELECT
                $this->username = 'Waarde uit de database';
                return true;
            } else {
                return false;
            }   
        }

        public function logout(){
            session_start();
            // remove all session variables
           

            // destroy the session
            

        }


    }

?>