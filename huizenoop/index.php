<?php


// TCR schoolopdracht:

// 1e Commit
// 1e change: display function zit in de class house
// 2e change: objecten worden dynamisch weergegeven
// 3e change: addRoom binnen class House wordt object Room geinstantieerd


//gemaakt door: Pascal Petri
//Datum: 22-09-2025

class Room {
    private string $name;
    private float $length;
    private float $width;
    private float $height;


    // 10,48   = > goed
    // A   => fout
    // pbject => fout
    // array => fout
    //@todo: nog implementeren
    protected function validator($getal){

    }


    public function __construct(string $name, float $length, float $width, float $height) {

        //@todo validator gebruiken
        if($this->validator($width)){

        }

        $this->name = $name;
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
    }

    public function getName(): string { return $this->name; }
    public function getLength(): float { return $this->length; }
    public function getWidth(): float { return $this->width; }
    public function getHeight(): float { return $this->height; }
    public function getVolume(): float { return $this->length * $this->width * $this->height; }
}


// Huis class
class House {
    private array $rooms = [];
    private float $pricePerCubicMeter;
    private string $name;

    public function __construct(string $name, float $pricePerCubicMeter) {
        $this->name = $name;
        $this->pricePerCubicMeter = $pricePerCubicMeter;
    }


    // Functie om huisgegevens netjes weer te geven
    public function displayHouse($oHouse) {
        echo "<hr>";
        echo "<h1>Huis: " . $oHouse->getName() . "</h1>\n";
        echo "Inhoud Kamers:\n";
        foreach ($oHouse->getRooms() as $room) {
            echo "• " . $room->getName() . " - Lengte: " . $room->getLength() . "m, <br/>" ;
            echo "Breedte: " . $room->getWidth() . "m, <br/>";
            echo "Hoogte: " . $room->getHeight() . "m\n<br/>";
        }
        echo "Volume Totaal: " . number_format($oHouse->getTotalVolume(), 2) . " m³\n<br/>";
        echo "Prijs van het huis: " . number_format($oHouse->getTotalPrice(), 0) . " Euro\n<br/>";
        echo "<br>";
    }


    public function addRoom(string $name, float $length, float $width, float $height): void {

        $oRoom = new Room($name, $length, $width, $height);
        $this->rooms[] = $oRoom;
    }


    public function getRooms(): array {
        return $this->rooms;
    }

    public function getTotalVolume(): float {
        $total = 0.0;
        foreach ($this->rooms as $room) {
            $total += $room->getVolume();
        }
        return $total;
    }

    public function getTotalPrice(): float {
        return $this->getTotalVolume() * $this->pricePerCubicMeter;
    }

    public function getName(): string {
        return $this->name;
    }
}

// --- Test code voor meerdere huisen ---

// Huizen
for($i =0; $i < 9; $i++){

    $randomKamer = rand(1,4);
    $oHouse = new House("Family House nr" . $i, 3000);

    for($j=0; $j<$randomKamer; $j++){

        $randomWidth = rand(1,10);
        $randomHeight = rand(1,10);
        $randomDepth = rand(1,15);

        $oHouse->addRoom("Random room:" . $j, $randomWidth, $randomHeight, $randomDepth);
    }

    $oHouse->displayHouse($oHouse);

    unset($oHouse);
}


/*
$oHouse1->addRoom(new Room("Living room", 5.2, 5.1, 5.5));
$oHouse1->addRoom(new Room("Bedroom", 4.8, 4.6, 4.9));
$oHouse1->addRoom(new Room("Bathroom", 5.9, 2.5, 3.1));

// Huis 2
$oHouse2 = new House("Luxury Villa", 500);
$oHouse2->addRoom(new Room("Living room", 8.0, 6.0, 5.5));
$oHouse2->addRoom(new Room("Master Bedroom", 6.5, 5.5, 4.9));
$oHouse2->addRoom(new Room("Bathroom", 4.0, 3.0, 3.2));
$oHouse2->addRoom(new Room("Guest Room", 5.0, 4.0, 4.5));

// Huis 3
$oHouse3 = new House("Small Cottage", 150);
$oHouse3->addRoom("Living room", 4.0, 3.5, 3.8);

$oHouse3->addRoom(new Room("Bedroom", 3.5, 3.0, 3.5));
$oHouse3->addRoom(new Room("Bathroom", 2.5, 2.0, 2.5
));
*/


// Alle huizen weergeven

//displayHouse($oHouse2);
//displayHouse($oHouse3);

//$oHouse1->displayHouse($oHouse1);

//of
//echo $oHouse3;