<?php
class Inserter {
    public static function insert(array $d): bool {
        try {
            $conn = connectDb();
            $stmt = $conn->prepare(
                "INSERT INTO " . CRUD_TABLE . " (merk,type,prijs) VALUES (:merk,:type,:prijs)"
            );
            $stmt->execute([
                ':merk'  => $d['merk']  ?? null,
                ':type'  => $d['type']  ?? null,
                ':prijs' => $d['prijs'] ?? null,
            ]);
            return $stmt->rowCount() === 1;
        } catch (PDOException $e) {
            if (function_exists('sql_error')) sql_error($e, 'INSERT', $d);
            return false;
        }
    }
}

class InsertHandler {
    public static function process(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_ins'])) {
            if (Inserter::insert($_POST)) {
                echo "<script>alert('Fiets is toegevoegd')</script>";
            }
        }
    }
}