<?php
namespace Project_calculator\Classes;
class Calculator {

    public function add($getal1, $getal2){ 
        return $getal1 + $getal2;
}
    public function subtract($a, $b) {

    return $a - $b;

}

public function multiply($a, $b) {

    return $a * $b;

}
public function divide($a, $b) {

    if ($b == 0) {

        // Geen exception: geef null terug bij delen door nul
        return null;

    }

    return $a / $b;

}
}
?>
