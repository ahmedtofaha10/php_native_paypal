<?php
require __DIR__ .'/vendor/autoload.php';
require  __DIR__ .'/PayPalClient.php';

$client = PayPalClient::client();

// Construct a request object and set desired parameters
// Here, OrdersCreateRequest() creates a POST request to /v2/checkout/orders
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
$request = new OrdersCreateRequest();
$request->prefer('return=representation');
$items = [
    [
        "reference_id"  =>  "product_1",
        "amount" => [
            "value" => "150.00",
            "currency_code" => "USD"
        ]
    ],
    [
        "reference_id"  =>  "product_2",
        "amount" => [
            "value" => "90.00",
            "currency_code" => "USD"
        ]
    ],

];

$request->body = [
    "intent" => "CAPTURE",
    "purchase_units" => $items,
    "application_context" => [
        "cancel_url" => "http://localhost/PAYPAL/cancel.php",
        "return_url" => "http://localhost/PAYPAL/return.php"
    ]
];

try {
    // Call API with your client and get a response for your call
    $response = $client->execute($request);
    // If call returns body in response, you can get the deserialized version from the result attribute of the response
    print_r($response);
    session_start();
    $_SESSION["paypal_order_id"] = strval($response->result->id );
    foreach ($response->result->links as $link){
        if ($link->rel == "approve")
            header('location:'.$link->href);
    }
}catch (HttpException $ex) {
    echo $ex->statusCode;
    print_r($ex->getMessage());
}
