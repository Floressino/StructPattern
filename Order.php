<?php

    $amount = $_POST['price'];
    $bankName = $_POST['bank'];
    $bank = null;

    interface PaymentAdapter{
        public function pay($amount);
    }

    class QiwiBank implements PaymentAdapter {
        public function pay($amount)
        {

            require('./vendor/qiwi/bill-payments-php-sdk/src/BillPayments.php');

            $SECRET_KEY = 'eyJ2ZXJzaW9uIjoiUDJQIiwiZGF0YSI6eyJwYXlpbl9tZXJjaGFudF9zaXRlX3VpZCI6InU1bXh2ai0wMCIsInVzZXJfaWQiOiI3OTUxNjA4NTg2NCIsInNlY3JldCI6ImJkZDA1YzJjMDU5ODEzMTczZGUxMTllNDYxZGQ1NDRkOWRmOTc0MjI0MzM2MzBmMzdiYjEzOTkxYjFiZjY5ZmIifX0=';
            $PUBLIC_KEY = '48e7qUxn9T7RyYE1MVZswX1FRSbE6iyCj2gCRwwF3Dnh5XrasNTx3BGPiMsyXQFNKQhvukniQG8RTVhYm3iPxzwatT2caRQUn7D6zmdQeQdUPvxN2SSeqpnnzXRGr8YTwCM4eJHzcVGJh9uHmkkWY3B19GgJNAh4waGwLgurXMR2fXxDppR4SbJQNtMJe';

            $params = [
                'publicKey' => $PUBLIC_KEY,
                'amount' => $amount,
                'billId' => 'cc961e8d-d4d6-4f02-b737-' . random_int(100000000000, 999999999999),
                'customFields' => [
                    'themeCode' => "Dmytryi-AjBubnviyC"
                ],
                "phone" => "79516085864",
                "lifetime" => "2025-12-10T09:02:00+03:00",
                "successUrl" => "http://structpattern/Result.php"
            ];


            $billPayments = new Qiwi\Api\BillPayments($SECRET_KEY);
            $link = $billPayments->createPaymentForm($params);

            echo json_encode($link);
        }
    }

    class AnotherBank implements PaymentAdapter {
        public function pay($amount)
        {
            // todo ...
        }
    }

    switch ($bankName){
        case "QIWI":{
            $bank = new QiwiBank();
            $bank->pay($amount);
        }
        case "ANOTHE":{
            $bank = new AnotherBank();
            $bank->pay($amount);
        }

    }


?>