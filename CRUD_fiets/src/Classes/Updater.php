<?php
class Updater {
    public static function find(int $id) {
        $conn = connectDb();
        $stmt = $conn->prepare("SELECT * FROM " . CRUD_TABLE . " WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function update(array $d): bool {
        try {
            $conn = connectDb();
            $stmt = $conn->prepare(
                "UPDATE " . CRUD_TABLE . " SET merk = :merk, type = :type, prijs = :prijs WHERE id = :id"
            );
            $stmt->execute([
                ':merk'  => $d['merk']  ?? null,
                ':type'  => $d['type']  ?? null,
                ':prijs' => $d['prijs'] ?? null,
                ':id'    => $d['id']    ?? null,
            ]);
            return $stmt->rowCount() === 1;
        } catch (PDOException $e) {
            if (function_exists('sql_error')) sql_error($e, 'UPDATE', $d);
            return false;
        }
    }
}