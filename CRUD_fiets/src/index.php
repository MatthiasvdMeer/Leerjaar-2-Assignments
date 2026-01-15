<?php
require_once __DIR__ . '/../vendor/autoload.php';

use User\CrudFiets\Functions;

$Crud = new Functions();
$Crud->crudMain();
