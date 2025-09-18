<?php
class House {

    private int $numberOfFloors;
    private int $numberOfRooms;
    private float $width;
    private float $height;
    private float $depth;
    private float $pricePerM3 = 850;

    public function __construct(int $numberOfFloors, int $numberOfRooms, float $width, float $height, float $depth) {
        $this->numberOfFloors = $numberOfFloors;
        $this->numberOfRooms = $numberOfRooms;
        $this->width = $width;
        $this->height = $height;
        $this->depth = $depth;
    }

    // Getter and setter for numberOfRooms
    public function getNumberOfRooms(): int {
        return $this->numberOfRooms;
    }

    public function setNumberOfRooms(int $numberOfRooms): void {
        $this->numberOfRooms = $numberOfRooms;
    }

    // Getter and setter for width
    public function getWidth(): float {
        return $this->width;
    }

    public function setWidth(float $width): void {
        $this->width = $width;
    }

    public function calculateVolume(): float {
        return $this->width * $this->height * $this->depth;
    }

    public function calculatePrice(): float {
        return $this->calculateVolume() * $this->pricePerM3;
    }

    public function showDetails(): void {
        echo "House details:<br>";
        echo "- Number of floors: {$this->numberOfFloors}<br>";
        echo "- Number of rooms: {$this->numberOfRooms}<br>";
        echo "- Dimensions: {$this->width}m × {$this->height}m × {$this->depth}m<br>";
        echo "- Volume: " . $this->calculateVolume() . " m³<br>";
        echo "- Price: €" . number_format($this->calculatePrice(), 2, ',', '.') . "<br><br>";
    }
}

$house1 = new House(3, 8, 8.0, 12.0, 10.0);
$house2 = new House(1, 4, 12.0, 9.0, 5.0);
$house3 = new House(2, 15, 22, 27, 8.0);

$house1->showDetails();
$house2->showDetails();
$house3->showDetails();
?>