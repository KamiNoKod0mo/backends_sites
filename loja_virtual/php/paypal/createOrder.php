<?php
require 'PayPalClient.php';
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

$client = PayPalClient::client();
$request = new OrdersCreateRequest();
$request->prefer('return=representation');
$request->body = [
    "intent" => "CAPTURE",
    "purchase_units" => [[
        "amount" => [
            "currency_code" => "BRL",
            "value" => "10.00"
        ]
    ]],
    "application_context" => [
        "cancel_url" => "https://seusite.com/cancel.php",
        "return_url" => "http://localhost/Projeto_etapa3/loja_virtual/fastlane/captureOrder.php"
    ]
];

try {
    $response = $client->execute($request);
    foreach ($response->result->links as $link) {
        if ($link->rel === 'approve') {
            header("Location: $link->href");
            exit;
        }
    }
} catch (HttpException $ex) {
    echo $ex->statusCode;
    print_r($ex->getMessage());
}
?>
