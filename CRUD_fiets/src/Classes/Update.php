<?php
require_once 'functions.php';
require_once __DIR__ . '/../Classes/Updater.php';

if (!isset($_GET['id'])) { echo "Geen id opgegeven"; exit; }
$id = (int) $_GET['id'];
$row = Updater::find($id);
if (!$row) { echo "Record niet gevonden"; exit; }

if (isset($_POST['btn_wzg'])) {
    if (Updater::update($_POST)) echo "<script>alert('Fiets is gewijzigd')</script>";
}

// Haal record voor form
$row = isset($_GET['id']) ? Updater::find((int)$_GET['id']) : null;
if (!$row) { echo "Geen id opgegeven"; exit; }
?>

<!DOCTYPE html>
<html>
<body>
  <h2>Wijzig Fiets</h2>
  <form method="post">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <label>Merk:<input name="merk" value="<?= $row['merk'] ?>" required></label><br>
    <label>Type:<input name="type" value="<?= $row['type'] ?>" required></label><br>
    <label>Prijs:<input type="number" name="prijs" value="<?= $row['prijs'] ?>" required></label><br>
    <button type="submit" name="btn_wzg">Wijzig</button>
  </form>
  <a href="..\index.php">Home</a>
</body>
</html>

