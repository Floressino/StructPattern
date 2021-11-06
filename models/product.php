<?

    class Product {
        public $id;
        public $name;
        public $description;
        public $price;
        public $discount;
        public $pathImage;

        public function __construct($id, $name, $description, $price, $discount, $pathImage){
            $this->id = $id;
            $this->name = $name;
            $this->description = $description;
            $this->price = $price;
            $this->discount = $discount;
            $this->pathImage = $pathImage;
        }
    }

?>