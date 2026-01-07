<?php
use PHPUnit\Framework\TestCase;

class FietsTests extends TestCase
{
    public function testDatabaseFileExists() { $this->assertFileExists(__DIR__ . '/../src/Classes/Database.php'); }
    public function testCrudFietsFileExists() { $this->assertFileExists(__DIR__ . '/../src/Classes/CrudFiets.php'); }
    public function testInserterContainsInsertMethod() {
        $s = (string) @file_get_contents(__DIR__ . '/../src/Classes/Inserter.php');
        $this->assertStringContainsString('public static function insert', $s);
    }
    public function testUpdaterContainsUpdateMethod() {
        $s = (string) @file_get_contents(__DIR__ . '/../src/Classes/Updater.php');
        $this->assertStringContainsString('public static function update', $s);
    }
    public function testDeleterContainsClass() {
        $s = (string) @file_get_contents(__DIR__ . '/../src/Classes/Delete.php');
        $this->assertStringContainsString('class Deleter', $s);
    }
    public function testFunctionsDefinesCrudTableFallback() {
        $s = (string) @file_get_contents(__DIR__ . '/../src/Classes/functions.php');
        $this->assertStringContainsString("define('CRUD_TABLE'", $s);
    }
    public function testInserterHasInsertHandlerClass() {
        $s = (string) @file_get_contents(__DIR__ . '/../src/Classes/Inserter.php');
        $this->assertStringContainsString('class InsertHandler', $s);
    }
    public function testSqlSchemaContainsFietsenTable() {
        $s = (string) @file_get_contents(__DIR__ . '/../ontwerp/fietsenmaker.sql');
        $this->assertStringContainsString('CREATE TABLE `fietsen`', $s);
    }
}