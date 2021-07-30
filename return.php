<?php
require __DIR__ .'/vendor/autoload.php';
require  __DIR__ .'/PayPalClient.php';
session_start();
$client = PayPalClient::client();

use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
// Here, OrdersCaptureRequest() creates a POST request to /v2/checkout/orders
// $response->result->id gives the orderId of the order created above
$request = new OrdersCaptureRequest($_SESSION["paypal_order_id"]);
$request->prefer('return=representation');
try {
    // Call API with your client and get a response for your call
    $response = $client->execute($request);

    // If call returns body in response, you can get the deserialized version from the result attribute of the response
    echo json_encode($response);
}catch (HttpException $ex) {
    echo $ex->statusCode;
    print_r($ex->getMessage());
}
