<?php
namespace User\CrudFiets;

require_once __DIR__ . '/../../vendor/autoload.php';

use PDOException;

$message = '';

class Insert {

    public static function insert(array $d): bool {
        $merk  = trim($d['merk'] ?? '');
        $type  = trim($d['type'] ?? '');
        $prijs = trim($d['prijs'] ?? '');

        if ($merk === '' || $type === '' || $prijs === '') {
            return false;
        }

        try {
            $conn = Database::pdo();
            $stmt = $conn->prepare(
                "INSERT INTO " . Database::$table . " (merk,type,prijs)
                 VALUES (:merk,:type,:prijs)"
            );
            $stmt->execute([
                ':merk'  => $merk,
                ':type'  => $type,
                ':prijs' => $prijs
            ]);
            return $stmt->rowCount() === 1;
        } catch(PDOException $e) {
            return false;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_ins'])) {
    $success = Insert::insert($_POST);
    $message = $success ? 'Fiets toegevoegd!' : 'Vul alle velden in!';
}
?>

<!DOCTYPE html>
<html>
<body>
<h1>Nieuwe fiets toevoegen</h1>

<?php if ($message): ?>
<script>alert('<?= htmlspecialchars($message) ?>');</script>
<?php endif; ?>

<form method="post" action="">
    <label>Merk: <input name="merk" required></label><br>
    <label>Type: <input name="type" required></label><br>
    <label>Prijs: <input type="number" name="prijs" required></label><br>
    <button type="submit" name="btn_ins">Toevoegen</button>
</form>

<a href="../index.php">Terug naar overzicht</a>
</body>
</html>
