<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/CrudFiets.php';
$config = __DIR__ . '/../crud_fiets/config.php';
if (file_exists($config)) {
    include_once $config;
} else if (!defined('CRUD_TABLE')) {
    define('CRUD_TABLE', 'fietsen'); // fallback als config ontbreekt
}

class CrudApp {
    public static function connectDb() {
        return Database::pdo();
    }

    public static function getData($table) {
        return $table === CRUD_TABLE
            ? CrudFiets::all()
            : Database::pdo()->query("SELECT * FROM $table")->fetchAll();
    }

    public static function getRecord(int $id) {
        return CrudFiets::find($id);
    }

    public static function insertRecord($post): bool {
        if (class_exists('Inserter') && method_exists('Inserter', 'insert')) {
            return Inserter::insert($post);
        }
        if (class_exists('CrudFiets') && method_exists('CrudFiets', 'insert')) {
            return CrudFiets::insert($post);
        }
        return false;
    }

    public static function updateRecord(array $row): bool {
        return CrudFiets::update($row);
    }

    public static function deleteRecord(int $id): bool {
        return CrudFiets::delete($id);
    }

    public static function crudMain(): void {
        echo "<h1>Crud Fietsen</h1>";
        echo "<nav><a href='Classes/Insert.php'>Toevoegen nieuwe fiets</a></nav><br>";

        $rows = self::getData(CRUD_TABLE);
        if (empty($rows)) { echo "Geen fietsen gevonden."; return; }

        echo "<table>";
        echo "<tr>";
        foreach (array_keys($rows[0]) as $h) echo "<th>{$h}</th>";
        echo "<th colspan=2>Actie</th></tr>";

        foreach ($rows as $r) {
            echo "<tr>";
            foreach ($r as $c) echo "<td>{$c}</td>";
            echo "<td>
                <form method='get' action='Classes/Update.php'>
                    <input type='hidden' name='id' value='{$r['id']}'>
                    <button type='submit'>Wzg</button>
                </form>
                </td>";
            echo "<td>
                    <form method='get' action='Classes/Delete.php'>
                      <input type='hidden' name='id' value='{$r['id']}'>
                      <button>Verwijder</button>
                    </form>
                  </td>";
            echo "</tr>";
        }

        echo "</table>";
    }
}


if (!function_exists('connectDb')) {
    function connectDb() { return CrudApp::connectDb(); }
}
if (!function_exists('getData')) {
    function getData($table) { return CrudApp::getData($table); }
}
if (!function_exists('getRecord')) {
    function getRecord($id) { return CrudApp::getRecord((int)$id); }
}
if (!function_exists('insertRecord')) {
    function insertRecord($post): bool { return CrudApp::insertRecord($post); }
}
if (!function_exists('updateRecord')) {
    function updateRecord($row): bool { return CrudApp::updateRecord($row); }
}
if (!function_exists('deleteRecord')) {
    function deleteRecord($id): bool { return CrudApp::deleteRecord((int)$id); }
}
if (!function_exists('crudMain')) {
    function crudMain(): void { CrudApp::crudMain(); }
}