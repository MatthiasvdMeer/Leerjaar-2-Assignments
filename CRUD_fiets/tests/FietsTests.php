<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use User\CrudFiets\Database;
use User\CrudFiets\Insert;
use User\CrudFiets\Update;
use User\CrudFiets\Delete;
use User\CrudFiets\Functions;

final class FietsTests extends TestCase
{
    private static int $lastInsertId;

    /** 1️⃣ Test database connectie */
    public function testDatabaseConnection(): void
    {
        $pdo = Database::pdo();
        $this->assertInstanceOf(PDO::class, $pdo);
    }

    /** 2️⃣ Test Insert: nieuwe fiets toevoegen */
    public function testInsertValid(): void
    {
        $data = ['merk'=>'TestMerk','type'=>'TestType','prijs'=>123];
        $result = Insert::insert($data);
        $this->assertTrue($result);

        // Sla id op voor latere tests
        $conn = Database::pdo();
        self::$lastInsertId = (int)$conn->lastInsertId();
    }

    /** 3️⃣ Test Insert mislukt met lege array */
    public function testInsertEmptyArray(): void
    {
        $this->assertFalse(Insert::insert([]));
    }

    /** 4️⃣ Test Update: wijzig zojuist ingevoegde fiets */
    public function testUpdateValid(): void
    {
        $data = [
            'id'=>self::$lastInsertId,
            'merk'=>'UpdatedMerk',
            'type'=>'UpdatedType',
            'prijs'=>200
        ];
        $this->assertTrue(Update::update($data));
    }

    /** 5️⃣ Test GetRecord haalt juiste data op */
    public function testGetRecord(): void
    {
        $row = Functions::getRecord(self::$lastInsertId);
        $this->assertIsArray($row);
        $this->assertEquals('UpdatedMerk', $row['merk']);
    }

    /** 6️⃣ Test Update mislukt met niet-bestaand id */
    public function testUpdateNonExistentId(): void
    {
        $data = ['id'=>999999,'merk'=>'X','type'=>'Y','prijs'=>10];
        $this->assertFalse(Update::update($data));
    }

    /** 7️⃣ Test Delete: verwijder zojuist ingevoegde fiets */
    public function testDeleteValid(): void
    {
        $this->assertTrue(Delete::remove(self::$lastInsertId));
    }

    /** 8️⃣ Test Delete mislukt als id al verwijderd is */
    public function testDeleteAlreadyDeleted(): void
    {
        $this->assertFalse(Delete::remove(self::$lastInsertId));
    }

    /** 9️⃣ Test GetRecord na delete faalt */
    public function testGetRecordAfterDelete(): void
    {
        $row = Functions::getRecord(self::$lastInsertId);
        $this->assertFalse($row);
    }

    /** 🔟 Test getData retourneert altijd een array */
    public function testGetDataReturnsArray(): void
    {
        $rows = Functions::getData(Database::$table);
        $this->assertIsArray($rows);
    }
}
