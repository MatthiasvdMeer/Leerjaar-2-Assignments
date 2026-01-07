<?php
class CrudFiets {
    public static function all(): array {
        return Database::pdo()->query("SELECT * FROM " . CRUD_TABLE)->fetchAll();
    }

    public static function find(int $id) {
        $stmt = Database::pdo()->prepare("SELECT * FROM " . CRUD_TABLE . " WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function insert(array $d): bool {
        try {
            $stmt = Database::pdo()->prepare(
                "INSERT INTO " . CRUD_TABLE . " (merk,type,prijs) VALUES (:merk,:type,:prijs)"
            );
            $stmt->execute([':merk'=>$d['merk'], ':type'=>$d['type'], ':prijs'=>$d['prijs']]);
            return $stmt->rowCount() === 1;
        } catch (PDOException $e) {
            sql_error($e, 'INSERT', $d);
            return false;
        }
    }

    public static function update(array $d): bool {
        $stmt = Database::pdo()->prepare(
            "UPDATE " . CRUD_TABLE . " SET merk=:merk, type=:type, prijs=:prijs WHERE id=:id"
        );
        $stmt->execute([':merk'=>$d['merk'],':type'=>$d['type'],':prijs'=>$d['prijs'],':id'=>$d['id']]);
        return $stmt->rowCount() === 1;
    }

    public static function delete(int $id): bool {
        $stmt = Database::pdo()->prepare("DELETE FROM " . CRUD_TABLE . " WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() === 1;
    }
}