
    <?

        require("./GenerateProducts.php");
        $products = GenerateProducts::generateProduct(5);

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="style.css" rel="stylesheet">
    <script>

        class Delivery {
            static calculatePriceDelivery() {
                return Math.round(Math.random() * (100 - 1 + 1) + 1)
            }
        }

        class Discount {
            static calculatePriceDiscount(){
                return Math.round(Math.random() * (50 - 1 + 1) + 1)
            }
        }

        class Order {
            static totalPrice = 0;
            static totalDiscount = 0;
            static totalDelivery = 0;

            static productList = [];

            static appendProductInOrder(product){
                Order.totalPrice += product.price;
                Order.totalDiscount += product.discount;
                Order.totalDelivery += product.delivery;
                this.productList.push(product);

                // Вывод окна с товаром в корзину
                var html = Order.getProductToHtmlFormat(product);
                let basket = document.getElementsByClassName("basket")[0].getElementsByClassName("product_list")[0];
                console.log(basket)
                basket.insertAdjacentHTML("beforeEnd", html);

                // Изменение данных о цене/доставке/скидке
                let price = document.getElementsByClassName("total_price")[0];
                price.innerHTML = '<div class="total_price"><b>Сумма заказа: </b>' + (Order.totalPrice - Order.totalDiscount + Order.totalDelivery) + ' руб. (С учетом скидки)</div>';

                let delivery = document.getElementsByClassName("total_delivery")[0];
                delivery.innerHTML = '<div class="total_delivery"><b>Цена на доставку: </b>' + Order.totalDelivery + ' руб. </div>';

                let discount = document.getElementsByClassName("total_discount")[0];
                discount.innerHTML = '<div class="total_discount"><b>Общая скидка: </b>' + Order.totalDiscount + ' руб. </div>';
            }

            static buyProduct(object) {

                object.delivery = Delivery.calculatePriceDelivery()
                object.discount = Discount.calculatePriceDiscount()
                console.log(object)
                Order.appendProductInOrder(object)

            }

            // Оплата
            static makeOrder(){
                console.log("make order")
                var price = {"price": Order.totalPrice-Order.totalDiscount+Order.totalDelivery, "bank": "QIWI"}
                console.log(price)
                $.ajax({
                    method: "POST",
                    url: 'Order.php',
                    dataType: "JSON",
                    data: price,
                    success: function(link) {
                        console.log(`success = ${link}`)
                        location.href = link

                    },
                    error: function(xhr, str) {
                        alert('Возникла ошибка: ' + xhr.responseCode)
                    }
                })
            }

            static getProductToHtmlFormat(product){
                return "<div class='product'>" +
                    "<div class='id' style='display: none;'>" + product.id + "</div>" +
                    "<div class='name'><b>" + product.name + "</b></div>" +
                    "<div class='image'><img src=" + product.pathImage + " alt='none'></div>" +
                    "<div class='description'>" + product.description + "</div>" +
                    "<div><b>Стоимость:</b> <span class='price'>" + product.price + "</span> руб.</div>" +
                    "<div><b>Скидка:</b> <span class='discount'>" + product.discount + "</span> руб.</div>" +
                    "</div>"
            }
        }

    </script>
</head>
<body>
    <h1 style="text-align: center;">MAGAZIN</h1>
    <div class="product_list">
        <?

            foreach ($products as $product) {

                $id = $product->id;
                $name = $product->name;
                $pathImage = $product->pathImage;
                $description = $product->description;
                $price = $product->price;
                $discount = $product->discount;

                $productJson = json_encode($product);

                echo "<div class='product'>
                        <div class='id' style='display: none;'>".$id."</div>
                        <div class='name'><b>".$name."</b></div>
                        <div class='image'><img src=".$pathImage." alt='none'></div>
                        <div class='description'>".$description."</div>
                        <div><b>Стоимость:</b> <span class='price'>".$price."</span> руб.</div>
                        <div><b>Скидка:</b> <span class='discount'>".$discount."</span> руб.</div>
                        <button onclick='Order.buyProduct($productJson)'>Buy</button>
                     </div>
                     ";

            }

        ?>

    </div>
    <h1 style="text-align: center;">Корзина</h1>
    <div class="basket">
        <div class="total_price"></div>
        <div class="total_delivery"></div>
        <div class="total_discount"></div>
        <div class="product_list"></div>
    </div>
    <?
        echo "<button onclick='Order.makeOrder()'>Оформить заказ</button>"
    ?>
</body>
    <script src="jquery-3.6.0.min.js"></script>
</html>