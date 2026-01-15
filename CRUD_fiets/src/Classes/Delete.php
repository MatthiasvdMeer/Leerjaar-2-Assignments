<?php
namespace User\CrudFiets;

require_once __DIR__ . '/../../vendor/autoload.php';

class Delete {

    public static function remove(int $id): bool {
        $conn = Database::pdo();
        $stmt = $conn->prepare("DELETE FROM " . Database::$table . " WHERE id=:id");
        $stmt->execute([':id'=>$id]);
        return $stmt->rowCount()===1;
    }

    public static function process(): void {
        if (!isset($_GET['id'])) {
            header("Location: ../index.php");
            exit;
        }

        $id = (int) $_GET['id'];
        $row = Functions::getRecord($id);
        if (!$row) {
            header("Location: ../index.php");
            exit;
        }

        $success = self::remove($id);
        echo "<script>alert('".($success ? "Fiets verwijderd!" : "Fout bij verwijderen!")."');</script>";
        header("Location: ../index.php");
        exit;
    }
}

Delete::process();
