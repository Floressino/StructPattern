<?

    require('./models/product.php');

    class GenerateProducts {

        public static $names = array("Игровая мышь беспроводная","Компьютер","MacBook PRO","MacBook AIR","Клавиатура беспроводная", "Системный блок", "Игровой компьютерный экран");

        public static $descriptions = array("Очень полезный предмет", "Хорошая техника для вашего дома", "Этот товар понравится каждому");

        public static $pathImages = array("./images/gril_1.webp", "./images/comp_2.webp", "./images/1.jpg");


        public static function generateProduct($count) {
            
            $products = [];

            for ($i=0; $i < $count; $i++) { 

                $id = $i;
                $name = self::$names[random_int(0, count(self::$names)-1)];
                $description = self::$descriptions[random_int(0, count(self::$descriptions)-1)];
                $price = random_int(2000, 150000);
                $discount = random_int(0, 300);
                $pathImage = self::$pathImages[random_int(0, count(self::$pathImages)-1)];


                $product = new Product($id, $name, $description, $price, $discount, $pathImage);

                $products[] = $product;
            }

            return $products;
        }
    }

?>