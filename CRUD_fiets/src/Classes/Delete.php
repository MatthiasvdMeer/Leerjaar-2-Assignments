<?php
// auteur: Vul hier je naam in
// functie: verwijder een fiets op basis van de id
include 'functions.php';

class Deleter {
    public static function delete(int $id): bool {
        $conn = connectDb();
        $stmt = $conn->prepare("DELETE FROM " . CRUD_TABLE . " WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return ($stmt->rowCount() === 1);
    }
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    if (Deleter::delete($id)) {
        echo '<script>alert("Fietscode: ' . $id . ' is verwijderd")</script>';
        echo "<script>location.replace('../index.php');</script>";
    } else {
        echo '<script>alert("Fiets is NIET verwijderd")</script>';
    }
}
?>

