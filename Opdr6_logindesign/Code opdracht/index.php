<?php
session_start();
// Functie: programma login OOP 
// Auteur: Studentnaam

require_once 'classes/User.php';
?>

<!DOCTYPE html>
<html lang="en">
<body>
    <h3>PDO Login and Registration</h3>
    <hr/>
    <h3>Welcome op de HOME-pagina!</h3>
    <br/>
    

<?php
$user = new User();

if (isset($_SESSION['username'])) {
    $user->showUser(); 
} else {
    echo "Je bent niet ingelogd. <a href='login_form.php'>Klik hier om in te loggen</a>.";
}
    $user->isLoggedin();

    if (isset($_GET['logout'])) {
    $user->logout();
}
?>
</body>
</html>