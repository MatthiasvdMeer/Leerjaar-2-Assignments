<?php
namespace User\CrudFiets;

use User\CrudFiets\Database;


$config = __DIR__ . '/../crud_fiets/config.php';
if (file_exists($config)) {
    include_once $config;
} elseif (!defined('CRUD_TABLE')) {
    define('CRUD_TABLE', 'fietsen');
}

use PDO; // <--- voeg dit toe
use PDOException;

class Functions
{
    /* ===== Hoofd CRUD overzicht ===== */
    public static function crudMain(): void
    {
        echo "<h1>Crud Fietsen</h1>";
        echo "<nav><a href='Classes/Insert.php'>Toevoegen nieuwe fiets</a></nav><br>";

        $rows = self::getData(CRUD_TABLE);
        if (empty($rows)) {
            echo "Geen fietsen gevonden.";
            return;
        }


        
        echo "<table border='1'>";
        

        echo "<tr>";
        foreach (array_keys($rows[0]) as $h) {
            echo "<th>{$h}</th>";
        }
        echo "<th colspan='2'>Actie</th></tr>";

        foreach ($rows as $r) {
            echo "<tr>";
            foreach ($r as $c) {
                echo "<td>{$c}</td>";
            }

            echo "<td>
                <form method='get' action='Classes/Update.php'>
                    <input type='hidden' name='id' value='{$r['id']}'>
                    <button type='submit'>Wijzig</button>
                </form>
            </td>";

            echo "<td>
                <form method='get' action='Classes/Delete.php'>
                    <input type='hidden' name='id' value='{$r['id']}'>
                    <button type='submit'>Verwijder</button>
                </form>
            </td>";

            echo "</tr>";
        }

        echo "</table>";
    }

    /* ===== Database ===== */
    private static function connectDb(): PDO
    {
        return Database::pdo();
    }

    /* ===== Alle records ===== */
    public static function getData(string $table): array
    {
        if ($table !== CRUD_TABLE) {
            throw new InvalidArgumentException('Ongeldige tabel');
        }

        $conn = self::connectDb();
        $stmt = $conn->query("SELECT * FROM $table");
        return $stmt->fetchAll();
    }

    /* ===== 1 record ===== */
    public static function getRecord(int $id)
    {
        $conn = self::connectDb();
        $stmt = $conn->prepare(
            "SELECT * FROM " . CRUD_TABLE . " WHERE id = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}
