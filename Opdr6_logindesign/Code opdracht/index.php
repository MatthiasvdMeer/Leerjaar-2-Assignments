<?php
session_start();
    // Functie: programma login OOP 
    // Auteur: Studentnaam

    // Initialisatie
	require_once 'classes/User.php';
	$user = new User();

    if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
        $user->logout();
}

    
    $isLoggedIn = isset($_SESSION['username']);
?>

<!DOCTYPE html>

<html lang="en">

<body>
    <h3>PDO Login and Registration</h3>
    <hr/>
    <h3>Welcome op de HOME-pagina!</h3>
    <br/>

<?php if (!$isLoggedIn): ?>
    <a href="login_form.php">Ga naar de inlogpagina</a>
<?php endif; ?>

<?php
    $user->isLoggedin();
?>

    

</body>
</html>