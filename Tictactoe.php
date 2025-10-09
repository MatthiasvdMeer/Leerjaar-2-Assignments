<?php
// Namespace for the shapes - must be at the top
namespace ShapeGame;

// Abstract parent class Shape
abstract class Shape
{
    // Private properties with visibility and datatype
    private string $color;
    private int $x;
    private int $y;
    
    // Constructor
    public function __construct(string $color, int $x, int $y)
    {
        $this->color = $color;
        $this->x = $x;
        $this->y = $y;
    }
    
    // Getters
    public function getColor(): string
    {
        return $this->color;
    }
    
    public function getX(): int
    {
        return $this->x;
    }
    
    public function getY(): int
    {
        return $this->y;
    }
    
    // Setters
    public function setColor(string $color): void
    {
        $this->color = $color;
    }
    
    public function setX(int $x): void
    {
        $this->x = $x;
    }
    
    public function setY(int $y): void
    {
        $this->y = $y;
    }
    
    // Abstract draw method
    abstract public function draw(): string;
}

// Child class Square
class Square extends Shape
{
    private int $side;
    
    public function __construct(string $color, int $x, int $y, int $side)
    {
        parent::__construct($color, $x, $y);
        $this->side = $side;
    }
    
    public function getSide(): int
    {
        return $this->side;
    }
    
    public function setSide(int $side): void
    {
        $this->side = $side;
    }
    
    public function draw(): string
    {
        return '<svg width="120" height="120">
            <rect x="' . $this->getX() . '" y="' . $this->getY() . '" 
                  width="' . $this->side . '" height="' . $this->side . '" 
                  fill="' . $this->getColor() . '" stroke="black" stroke-width="2"/>
        </svg>';
    }
}

// Child class Circle
class Circle extends Shape
{
    private int $radius;
    
    public function __construct(string $color, int $x, int $y, int $radius)
    {
        parent::__construct($color, $x, $y);
        $this->radius = $radius;
    }
    
    public function getRadius(): int
    {
        return $this->radius;
    }
    
    public function setRadius(int $radius): void
    {
        $this->radius = $radius;
    }
    
    public function draw(): string
    {
        $centerX = $this->getX() + $this->radius;
        $centerY = $this->getY() + $this->radius;
        
        return '<svg width="120" height="120">
            <circle cx="' . $centerX . '" cy="' . $centerY . '" 
                    r="' . $this->radius . '" 
                    fill="' . $this->getColor() . '" stroke="black" stroke-width="2"/>
        </svg>';
    }
}

// Child class Rectangle
class Rectangle extends Shape
{
    private int $width;
    private int $height;
    
    public function __construct(string $color, int $x, int $y, int $width, int $height)
    {
        parent::__construct($color, $x, $y);
        $this->width = $width;
        $this->height = $height;
    }
    
    public function getWidth(): int
    {
        return $this->width;
    }
    
    public function getHeight(): int
    {
        return $this->height;
    }
    
    public function setWidth(int $width): void
    {
        $this->width = $width;
    }
    
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }
    
    public function draw(): string
    {
        return '<svg width="120" height="120">
            <rect x="' . $this->getX() . '" y="' . $this->getY() . '" 
                  width="' . $this->width . '" height="' . $this->height . '" 
                  fill="' . $this->getColor() . '" stroke="black" stroke-width="2"/>
        </svg>';
    }
}

// Child class Triangle
class Triangle extends Shape
{
    private int $base;
    private int $height;
    
    public function __construct(string $color, int $x, int $y, int $base, int $height)
    {
        parent::__construct($color, $x, $y);
        $this->base = $base;
        $this->height = $height;
    }
    
    public function getBase(): int
    {
        return $this->base;
    }
    
    public function getHeight(): int
    {
        return $this->height;
    }
    
    public function setBase(int $base): void
    {
        $this->base = $base;
    }
    
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }
    
    public function draw(): string
    {
        $x1 = $this->getX() + ($this->base / 2);
        $y1 = $this->getY();
        $x2 = $this->getX();
        $y2 = $this->getY() + $this->height;
        $x3 = $this->getX() + $this->base;
        $y3 = $this->getY() + $this->height;
        
        $points = "$x1,$y1 $x2,$y2 $x3,$y3";
        
        return '<svg width="120" height="120">
            <polygon points="' . $points . '" 
                     fill="' . $this->getColor() . '" stroke="black" stroke-width="2"/>
        </svg>';
    }
}

// Create objects with lowerCamelCase names
$redSquare = new Square("red", 10, 10, 80);
$greenCircle = new Circle("green", 10, 10, 40);
$blueRectangle = new Rectangle("blue", 10, 20, 100, 60);
$yellowTriangle = new Triangle("yellow", 10, 10, 80, 70);

$orangeSquare = new Square("orange", 10, 10, 80);
$purpleCircle = new Circle("purple", 10, 10, 40);
$greenRectangle = new Rectangle("green", 10, 20, 100, 60);
$redTriangle = new Triangle("red", 10, 10, 80, 70);

// Array with all shapes
$shapes = [
    $redSquare,
    $greenCircle,
    $blueRectangle,
    $yellowTriangle,
    $orangeSquare,
    $purpleCircle,
    $greenRectangle,
    $redTriangle
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OOP Assignment 3 - Three in a Row</title>
   
</head>
<body>
    <div class="container">
        <h1>Three in a Row - Shapes</h1>
        
        <h2>All Shapes:</h2>
        <div class="shapes-grid">
            <?php foreach ($shapes as $index => $shape): ?>
                <div class="shape-container">
                    <h3><?= get_class($shape) ?></h3>
                    <p>Color: <?= $shape->getColor() ?></p>
                    <p>Position: (<?= $shape->getX() ?>, <?= $shape->getY() ?>)</p>
                    
                    <?php if ($shape instanceof Square): ?>
                        <p>Side: <?= $shape->getSide() ?>px</p>
                    <?php elseif ($shape instanceof Circle): ?>
                        <p>Radius: <?= $shape->getRadius() ?>px</p>
                    <?php elseif ($shape instanceof Rectangle): ?>
                        <p>Width: <?= $shape->getWidth() ?>px</p>
                        <p>Height: <?= $shape->getHeight() ?>px</p>
                    <?php elseif ($shape instanceof Triangle): ?>
                        <p>Base: <?= $shape->getBase() ?>px</p>
                        <p>Height: <?= $shape->getHeight() ?>px</p>
                    <?php endif; ?>
                    
                    <?= $shape->draw() ?>
                </div>
            <?php endforeach; ?>
        </div>

</body>
</html>