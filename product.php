<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .card {
        border-radius: 15px;
        overflow: hidden;
        transition: 0.3s;
    }

    .card:hover {
        transform: scale(1.03);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .card img {
        height: 200px;
        object-fit: cover;
    }

    .price {
        font-weight: bold;
        color: #888;
        text-decoration: line-through;
    }

    .final-price {
        color: green;
        font-size: 20px;
        font-weight: bold;
    }
</style>
<?php


class Product
{
    private string $name;
    private  float $price;
    private string $brand;
    private string $image;
    private string $description;
    protected float $tax = 0.1;
    private float $discount;


    public function __construct(string $name, float $price, string $brand, string $image, string $description, float $discount)
    {
        $this->name = $name;
        $this->price = $price;
        $this->brand = $brand;
        $this->image = $image;
        $this->description = $description;
        $this->discount = $discount;
    }

    // public function __get(string $property)
    // {
    //     if ($property == 'name') {
    //         return $this->name;
    //     } elseif ($property == 'price') {
    //         return ($this->price - ($this->price * $this->discount)) . 'EGP';
    //     } elseif ($property == 'description') {
    //         return $this->description;
    //     }
    //     return 'Property not found';
    // }
    // public function __set(string $property, string|float $value)
    // {
    //     if ($property == 'name') {
    //         if (strlen($value) < 2) {
    //             echo 'Name must be more than 2 chars';
    //         }
    //     } elseif ($property == 'discount') {
    //         if ($value <= 0 && $value < 100) {
    //             echo 'discount must be more than 0 and less than 100 percent of product price';
    //         }else{

    //         }
    //     }
    // }

    public function getName(): string
    {
        return $this->name;
    }
    public function priceAfterDiscount(): float
    {
        return $this->price - ($this->price * $this->discount);
    }

    // public function getFinalPrice() {}

    public function getProductData(): array
    {
        return [
            'name' => $this->name,
            'brand' => $this->brand,
            'image' => $this->image,
            'description' => $this->description,
            'price' => $this->price,
            'priceAfterDiscount' => $this->priceAfterDiscount(),
            'finalPrice' => $this->calcPrice()
        ];
    }
    public function uploadImage(string $image)
    {
        $this->image = $image;
        echo "Uploaded Image : " . $image;
    }
    public function calcPrice(): float|string
    {
        $price = $this->priceAfterDiscount();
        if($price > 0){
            return $price + ($price * $this->tax);
        }else{
            return "Can't Calculate The Price";
        }
    }
}


class Book extends Product
{
    private array $publishers;
    private string $writer;
    private string $color;
    private string $supplier;
    private ?string $selectedPublisher = null;
    public function __construct(string $name, float $price, string $brand, string $image, string $description, float $discount, array $publishers, string $writer, string $color, string $supplier)
    {
        parent::__construct($name, $price, $brand, $image, $description, $discount);
        $this->publishers = $publishers;
        $this->writer = $writer;
        $this->color = $color;
        $this->supplier = $supplier;
    }

    // الطريقه دي لو هبعتله ال index بتاع ال publisher وده اللي شايفه منطقي
    //  بس التاسك مطلوب يبقا random

    // public function choosePublisher(int $index)
    // {
    //     if (isset($this->publishers[$index])) {
    //         $this->selectedPublisher = $this->publishers[$index];
    //     }
    // }




    public function choosePublisher()
    {
        if (!empty($this->publishers)) {
            $randomIndex = array_rand($this->publishers);
            $this->selectedPublisher = $this->publishers[$randomIndex];
        } else {
            echo "No Available Publishers";
        }
    }
    public function setPublisher(string $publisher)
    {
        if (in_array($publisher, $this->publishers)) {
            $this->selectedPublisher = $publisher;
        } else {
            echo "Publisher Not Found";
        }
    }
    public function addPublisher(string $publisher)
    {
        $this->publishers[] = $publisher;
    }
    public function getAllPublishers(): array|string
    {
        if (!empty($this->publishers)) {
            return $this->publishers;
        } else {
            return "No Available Publishers";
        }
    }
}
class BabyCar extends Product
{
    private float $age;
    private float $weight;
    private array $materials;
    protected float $tax = 0.2;
    private ?string $selectedMaterial = null;

    public function __construct(
        string $name,
        float $price,
        string $brand,
        string $image,
        string $description,
        float $discount,
        float $age,
        float $weight,
        array $materials,
        float $tax
    ) {
        parent::__construct($name, $price, $brand, $image, $description, $discount);
        $this->age = $age;
        $this->weight = $weight;
        $this->materials = $materials;
        $this->tax = $tax;
    }

    public function setMaterial(string $material){
        $this->materials[] = $material;
    }
    public function chooseMaterials(string $material)
    {
        if (in_array($material, $this->materials)) {
            $this->selectedMaterial = $material;
        } else {
            echo "Material Not Found";
        }
    }
    public function getMaterials(): array|string
    {
        if(!empty($this->materials)){
            return $this->materials;
        }else{
            return "No Available materials";
        }
    }
    public function calcPrice(): float|string
    {
        $price = $this->priceAfterDiscount();
        if($price > 0){
            return $price + ($price * $this->tax);
        }else{
            return "Can't Calculate The Price";
        }
    }
}



































$p1 = new Product('laptop', 10000, 'dell', 'laptop.jpeg', 'gaming laptop', 0.3);

$p2 = new Product('Mouse', 500, 'Z-Dragon', 'mouse.jpeg', 'Gaming Mouse', 0.5);

$p3 = new Product('Keyboard', 700, 'hp', 'keyboard.jpeg', 'Gaming Keyboard', 0.2);

$products = [$p1->getProductData(), $p2->getProductData(), $p3->getProductData()];

echo "<div class='container mt-5'><div class='row'>";

foreach ($products as $product) {

    echo "
    <div class='col-md-4 mb-4'>
        <div class='card h-100'>
            <img src='{$product['image']}' class='card-img-top'>

            <div class='card-body'>
                <h5 class='card-title'>{$product['name']}</h5>
                <p class='card-text'>{$product['description']}</p>

                <p class='price'>Price: {$product['price']} \$</p>
                <p>After Discount: {$product['priceAfterDiscount']} \$</p>
                <p class='final-price'>Final Price: {$product['finalPrice']} \$</p>

                <button class='btn btn-primary w-100'>Buy Now</button>
            </div>
        </div>
    </div>
    ";
}

echo "</div></div>";
