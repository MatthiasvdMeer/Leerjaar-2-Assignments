<?php
require_once 'functions.php';
require_once __DIR__ . '/../Classes/Inserter.php';

// Verwerk eventueel POST
InsertHandler::process();

class Insert {
    public static function process(): void {
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_ins'])) {
    if (Inserter::insert($_POST)) {
        echo "<script>alert('Fiets is toegevoegd')</script>";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html>
<body>
  <h1>Insert Fiets</h1>
  <form method="post">
    <label>Merk:<input name="merk" required></label><br>
    <label>Type:<input name="type" required></label><br>
    <label>Prijs:<input type="number" name="prijs" required></label><br>
    <button type="submit" name="btn_ins">Insert</button>
  </form>
  <a href="..\index.php">Home</a>
</body>
</html>