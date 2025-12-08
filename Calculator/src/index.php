<?php
require_once '../vendor/autoload.php';
use Project_Calculator\Classes\Calculator;


$calc = new Calculator();
echo $calc->add(5, 7); // 12
?>