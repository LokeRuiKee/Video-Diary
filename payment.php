<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51OWX4PJgoggQ8hJN85nfV9vGOcNfWtuv1GmvPA6HsYnMF2CiNEfDXXQ9iNFBABNRdV1vhEVm6at0Sbp3uyeyjhLA00dzJaiVf6');

header('Content-Type: application/json');

$checkout_session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => [[
    'price_data' => [
      'currency' => 'myr',
      'product_data' => [
        'name' => 'Video Diary Subscription',
      ],
      'unit_amount' => 1000,
    ],
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => 'http://localhost/AppDev/VideoDiary/video-diary-payment-success.html',
  'cancel_url' => 'http://localhost/AppDev/VideoDiary/video-diary-payment-cancel.html',
]);

echo json_encode(['id' => $checkout_session->id]);
?>