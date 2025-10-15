<?php

class Room
{
    private float $length;
    private float $width;
    private float $height;

    public function __construct(float $length, float $width, float $height){
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
    }
    public function getLength(): float{
        return $this->length;
    }
    public function getWidth(): float{
        return $this->width;
    }
    public function getHeight(): float{
        return $this->height;
    }
    public function getVolume(): float{
        return $this->length * $this->width * $this->height;
    }
    public function showDetails(): void{
        echo "Room: {$this->length}m x {$this->width}m x {$this->height}m, Volume: " . $this->getVolume() . " m³<br>";
    }
}

class House
{
    private int $numberOfFloors;
    private array $rooms = [];
    private float $pricePerM3 = 1500;

    public function __construct(int $numberOfFloors){
        $this->numberOfFloors = $numberOfFloors;
    }
    public function addRoom(Room $room): void{
        $this->rooms[] = $room;
    }
    public function getRooms(): array{
        return $this->rooms;
    }
    public function getTotalVolume(): float{
        $totalVolume = 0;
        foreach ($this->rooms as $room) {
            $totalVolume += $room->getVolume();
        }
        return $totalVolume;
    }
    public function getPrice(): float{
        return $this->getTotalVolume() * $this->pricePerM3;
    }
    public function showDetails(): void{
        echo "<br>";
        echo "Number of floors: " . $this->numberOfFloors . "<br>";
        echo "Number of rooms: " . count($this->rooms) . "<br>";
        foreach ($this->rooms as $room) {
            $room->showDetails();
        }
        echo "Total volume: " . $this->getTotalVolume() . " m³<br>";
        echo "Price: €" . number_format($this->getPrice(), 2, ',', '.') . "<br>";
        echo "<br><br>";
    }
}

// Example houses and rooms
$house1 = new House(2);
$house1->addRoom(new Room(5.0, 4.0, 2.5));  
$house1->addRoom(new Room(3.0, 4.0, 2.5));   
$house1->addRoom(new Room(6.0, 4.0, 2.5));  
$house2 = new House(1);
$house2->addRoom(new Room(4.0, 3.0, 2.5));  
$house2->addRoom(new Room(2.0, 3.0, 2.5));  

$house3 = new House(3);
$house3->addRoom(new Room(7.0, 5.0, 3.0));  
$house3->addRoom(new Room(4.0, 3.0, 2.5));   
$house3->addRoom(new Room(3.0, 3.0, 2.5));   
$house3->addRoom(new Room(2.0, 2.0, 2.5));   

$house1->showDetails();
$house2->showDetails();
$house3->showDetails();
?>
