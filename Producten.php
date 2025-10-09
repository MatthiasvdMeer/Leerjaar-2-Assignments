<?php

abstract class Product
{
    protected string $name;
    protected float $purchasePrice;
    protected int $tax;
    protected string $description;
    protected string $category;
    protected float $profit;

    public function __construct(
        string $name,
        float $purchasePrice,
        int $tax,
        string $description,
        float $profit,
        string $category
    ) {
        $this->name = $name;
        $this->purchasePrice = $purchasePrice;
        $this->tax = $tax;
        $this->description = $description;
        $this->profit = $profit;
        $this->category = $category;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getCategory(): string {
        return $this->category;
    }

    public function getSalePrice(): float {
        $taxAmount = ($this->tax / 100) * $this->purchasePrice;
        return $this->purchasePrice + $taxAmount + $this->profit;
    }

    abstract public function getProductInfo(): string;
}

// Music class
class Music extends Product
{
    private string $artist;
    private array $tracks;

    public function __construct(
        string $name,
        float $purchasePrice,
        int $tax,
        string $description,
        float $profit,
        string $artist,
        array $tracks
    ) {
        parent::__construct($name, $purchasePrice, $tax, $description, $profit, "Music");
        $this->artist = $artist;
        $this->tracks = $tracks;
    }

    public function getProductInfo(): string {
        return "Artiest: " . htmlspecialchars($this->artist) . "<br>Nummers: " . htmlspecialchars(implode(", ", $this->tracks)) . "<br>Omschrijving: " . htmlspecialchars($this->description);
    }
}

// Film class
class Film extends Product
{
    private string $quality;

    public function __construct(
        string $name,
        float $purchasePrice,
        int $tax,
        string $description,
        float $profit,
        string $quality
    ) {
        parent::__construct($name, $purchasePrice, $tax, $description, $profit, "Film");
        $this->quality = $quality;
    }

    public function getProductInfo(): string {
        return "Kwaliteit: " . htmlspecialchars($this->quality) . "<br>Omschrijving: " . htmlspecialchars($this->description);
    }
}

// Game class
class Game extends Product
{
    private string $genre;
    private string $hardwareRequirements;

    public function __construct(
        string $name,
        float $purchasePrice,
        int $tax,
        string $description,
        float $profit,
        string $genre,
        string $hardwareRequirements
    ) {
        parent::__construct($name, $purchasePrice, $tax, $description, $profit, "Game");
        $this->genre = $genre;
        $this->hardwareRequirements = $hardwareRequirements;
    }

    public function getProductInfo(): string {
        return "Genre: " . htmlspecialchars($this->genre) . "<br>Minimale hardware: " . htmlspecialchars($this->hardwareRequirements) . "<br>Omschrijving: " . htmlspecialchars($this->description);
    }
}

// ProductList class
class ProductList
{
    private array $products = [];

    public function addProduct(Product $product): void {
        $this->products[] = $product;
    }

    public function renderTable(): void {
        echo "<table border='1'>";
        echo "<tr><th>Naam</th><th>Categorie</th><th>Verkoopprijs</th><th>Informatie</th></tr>";
        foreach ($this->products as $product) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($product->getName()) . "</td>";
            echo "<td>" . htmlspecialchars($product->getCategory()) . "</td>";
            echo "<td>€" . number_format($product->getSalePrice(), 2) . "</td>";
            echo "<td>" . $product->getProductInfo() . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

// Voorbeeldproducten toevoegen
$productList = new ProductList();
$productList->addProduct(new Music("Greatest Hits", 10, 9, "Verzamelalbum", 5, "Queen", ["Bohemian Rhapsody", "Don't Stop Me Now"]));
$productList->addProduct(new Film("Inception", 15, 21, "Sciencefiction film", 7, "Blu-ray"));
$productList->addProduct(new Game("Cyberpunk 2077", 30, 21, "Futuristische RPG", 15, "RPG", "Windows 10, GTX 1060, 8GB RAM"));

// Tabel tonen
$productList->renderTable();
?>

<style>
    table{
        width: 70%;
        text-align: center;
    }
    th{
        background-color: #000000ff;
        color: white;
    }
    td {
        background-color: #006775ff;
    }
</style>