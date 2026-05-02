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
        if ($price > 0) {
            return $price + ($price * $this->tax);
        } else {
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

    public function getProductData(): array
    {
        $data = parent::getProductData();
        $data['publishers'] = $this->publishers;
        $data['writer'] = $this->writer;
        $data['color'] = $this->color;
        $data['supplier'] = $this->supplier;
        $data['selectedPublisher'] = $this->selectedPublisher;
        return $data;
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

    public function setMaterial(string $material)
    {
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
        if (!empty($this->materials)) {
            return $this->materials;
        } else {
            return "No Available materials";
        }
    }
    public function calcPrice(): float|string
    {
        $price = $this->priceAfterDiscount();
        if ($price > 0) {
            return $price + ($price * $this->tax);
        } else {
            return "Can't Calculate The Price";
        }
    }

    public function getProductData(): array
    {
        $data = parent::getProductData();
        $data['age'] = $this->age;
        $data['weight'] = $this->weight;
        $data['materials'] = $this->materials;
        $data['selectedMaterial'] = $this->selectedMaterial;
        return $data;
    }
}

class Gift extends Product
{
    private string $recipientName;
    private string $message;
    private string $wrapperColor;
    private float $wrappingCost;
    private bool $isSurprise = false;
    private string $occasion;
    private string $deliveryDate;



    public function __construct(
        string $name,
        float $price,
        string $brand,
        string $image,
        string $description,
        float $discount,
        string $recipientName,
        string $message,
        string $wrapperColor,
        float $wrappingCost,
        // bool $isSurprise,
        string $occasion,
        string $deliveryDate
    ) {
        parent::__construct($name, $price, $brand, $image, $description, $discount);
        $this->recipientName = $recipientName;
        $this->message = $message;
        $this->wrapperColor = $wrapperColor;
        $this->wrappingCost = $wrappingCost;
        // $this->isSurprise = $isSurprise;
        $this->occasion = $occasion;
        $this->deliveryDate = $deliveryDate;
    }

    public function setRecipientName(string $recipientName)
    {
        if (strlen($recipientName) >= 2) {
            $this->recipientName = $recipientName;
        } else {
            echo "Recipient Name must be More Than 2 chars";
        }
    }
    public function getRecipientName()
    {
        return $this->recipientName;
    }

    public function setMessage(string $message)
    {
        if (strlen($message) >= 5) {
            $this->message = $message;
        } else {
            echo "Message must be More Than 5 chars";
        }
    }
    public function getMessage()
    {
        return $this->message;
    }
    public function makeSurprise()
    {
        $this->isSurprise = true;
        return "The Gift is surprise";
    }


    public function setWrapper(string $color, float $cost)
    {
        $this->wrapperColor = $color;
        if ($cost > 0) {
            $this->wrappingCost = $cost;
        } else {
            echo "Invalid Wrapping Cost";
        }
    }
    public function calcPrice(): float|string
    {
        return parent::calcPrice() + $this->wrappingCost;
    }
    public function getProductData(): array
    {
        $data = parent::getProductData();

        $data['recipientName'] = $this->recipientName;
        $data['message'] = $this->message;
        $data['wrapper'] = $this->wrapperColor;
        $data['surprise'] = $this->isSurprise;
        $data['deliveryDate'] = $this->deliveryDate;
        $data['finalPrice'] = $this->calcPrice();

        return $data;
    }
}



$p1 = new Product('Laptop', 10000, 'Dell', 'laptop.jpeg', 'Gaming Laptop', 0.2);

$book1 = new Book(
    'Clean Code',
    300,
    'Prentice Hall',
    'book.jpeg',
    'Programming Book',
    0.1,
    ['Pub1', 'Pub2', 'Pub3'],
    'Robert C. Martin',
    'White',
    'Amazon'
);

$book1->choosePublisher();

$babyCar1 = new BabyCar(
    'Baby Stroller',
    2000,
    'Chicco',
    'babycar.jpeg',
    'Comfortable Baby Car',
    0.15,
    2,
    10,
    ['Plastic', 'Metal'],
    0.2
);

$babyCar1->chooseMaterials('Metal');

$gift1 = new Gift(
    'Gift Box',
    500,
    'unknown',
    'gift.jpeg',
    'Birthday Gift Box',
    0.3,
    'Ali',
    'Happy Birthday My Friend',
    'red',
    50,
    'birthday',
    '23-05-2003'
);
$gift1->makeSurprise();


$products = [$p1, $book1, $babyCar1, $gift1];


echo "<div class='card-body d-flex flex-column h-100'><div class='row'>";

foreach ($products as $product) {
    $data = $product->getProductData();

    echo "
    <div class='col-md-4 mb-4'>
        <div class='card'>
            <img src='{$data['image']}' class='card-img-top'>

            <div class='card-body'>
                <h5 class='card-title'>{$data['name']}</h5>
                <p class='card-text'>{$data['description']}</p>

                <p class='price'>Price: {$data['price']} \$</p>
                <p>After Discount: {$data['priceAfterDiscount']} \$</p>
                <p class='final-price'>Final Price: {$data['finalPrice']} \$</p>";

    if ($product instanceof Book) {
        echo "
            <p><strong>Writer:</strong> {$data['writer']}</p>
            <p><strong>Publisher:</strong> {$data['selectedPublisher']}</p>
        ";
    } elseif ($product instanceof BabyCar) {
        echo "
            <p><strong>Age:</strong> {$data['age']} years</p>
            <p><strong>Selected Material:</strong> {$data['selectedMaterial']}</p>
            <p><strong>Available Materials:</strong>
        ";


        foreach ($data['materials'] as $m) {
            echo "<span class='badge bg-secondary me-1'>{$m}</span>";
        }

        echo "</p>";


    } elseif ($product instanceof Gift) {
        echo "
                    <p><strong>Recipient Name:</strong> {$data['recipientName']} years</p>
                    <p><strong>Message:</strong> {$data['message']}</p>
                    <p><strong>Delivery Date:</strong> {$data['deliveryDate']}</p>
                    <p><strong>Wrapper Color:</strong> {$data['wrapper']}</p>
                ";
    } else {
        echo "</br>";
        echo "</br>";
        echo "</br>";
    }



    echo "</div>
            <div class='card-footer bg-white border-0'>
            <button class='btn btn-primary w-100'>Buy Now</button>
        </div>
        </div>
    </div>
    ";
}

echo "</div></div>";
