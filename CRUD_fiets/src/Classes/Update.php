<?php
namespace User\CrudFiets;

require_once __DIR__ . '/../../vendor/autoload.php';

use PDOException;

class Update {

    public static function find(int $id) {
        return Functions::getRecord($id);
    }

    public static function update(array $d): bool {
        try {
            $conn = Database::pdo();
            $stmt = $conn->prepare(
                "UPDATE " . Database::$table . " SET merk=:merk,type=:type,prijs=:prijs WHERE id=:id"
            );
            $stmt->execute([
                ':merk' => $d['merk'] ?? null,
                ':type' => $d['type'] ?? null,
                ':prijs'=> $d['prijs'] ?? null,
                ':id'   => $d['id'] ?? null
            ]);
            return $stmt->rowCount()===1;
        } catch(PDOException $e) {
            return false;
        }
    }

    public static function process(): array {
        if (!isset($_GET['id'])) {
            header("Location: ../index.php");
            exit;
        }

        $id = (int) $_GET['id'];
        $row = self::find($id);
        if (!$row) {
            header("Location: ../index.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['btn_wzg'])) {
            $success = self::update($_POST);
            echo "<script>alert('".($success ? "Fiets gewijzigd!" : "Fout bij wijzigen!")."');</script>";
            $row = self::find($id);
        }

        return $row;
    }
}

$row = Update::process();
?>

<!DOCTYPE html>
<html>
<body>
<h1>Wijzig fiets</h1>
<form method="post" action="">
    <label>Merk: <input name="merk" value="<?= htmlspecialchars($row['merk']) ?>" required></label><br>
    <label>Type: <input name="type" value="<?= htmlspecialchars($row['type']) ?>" required></label><br>
    <label>Prijs: <input type="number" name="prijs" value="<?= htmlspecialchars($row['prijs']) ?>" required></label><br>
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <button type="submit" name="btn_wzg">Wijzig</button>
</form>
<a href="../index.php">Terug naar overzicht</a>
</body>
</html>
