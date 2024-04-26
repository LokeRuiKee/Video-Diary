<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51OWX4PJgoggQ8hJN85nfV9vGOcNfWtuv1GmvPA6HsYnMF2CiNEfDXXQ9iNFBABNRdV1vhEVm6at0Sbp3uyeyjhLA00dzJaiVf6');

$email = 'lokeruikee@gmail.com';

// Try to find an existing customer with the same email
$existingCustomers = \Stripe\Customer::all(['email' => $email]);

if (count($existingCustomers->data) > 0) {
    // Use the first existing customer
    $customer = $existingCustomers->data[0];

    // Delete extra customers
    for ($i = 1; $i < count($existingCustomers->data); $i++) {
        $extraCustomer = $existingCustomers->data[$i];
        $extraCustomer->delete();
    }
} else {
    // Create a new customer
    $customer = \Stripe\Customer::create([
      'description' => 'Loke Rui Kee', // Replace with customer name
      'email' => $email,
    ]);
}

?>