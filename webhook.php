<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51OWX4PJgoggQ8hJN85nfV9vGOcNfWtuv1GmvPA6HsYnMF2CiNEfDXXQ9iNFBABNRdV1vhEVm6at0Sbp3uyeyjhLA00dzJaiVf6');

// Get the raw POST body
$input = @file_get_contents('php://input');
error_log('Received event: ' . $input); // Log the raw event

// Decode the JSON event
$event = json_decode($input);

// Check if $event is not null
if ($event !== null) {
    // Handle the checkout.session.completed event
    if (property_exists($event, 'type') && $event->type == 'checkout.session.completed') {
        $session = $event->data->object;

        // Check if customer ID exists
        if (property_exists($session, 'customer')) {
            $customerId = $session->customer;

            // Retrieve the customer object
            $customer = \Stripe\Customer::retrieve($customerId);

            // Check if customer email exists and is valid
            if (property_exists($customer, 'email') && filter_var($customer->email, FILTER_VALIDATE_EMAIL)) {
                $customerEmail = $customer->email;

                // Prepare the email
                $mail = new PHPMailer\PHPMailer\PHPMailer();
                $mail->setFrom('your-email@example.com', 'Your Name');
                $mail->addAddress($customerEmail);
                $mail->Subject = 'Payment Successful';
                $mail->Body = 'Your payment was successful. Thank you for your subscription.';

                // Send the email
                if (!$mail->send()) {
                    error_log('Mailer Error: ' . $mail->ErrorInfo);
                } else {
                    error_log('Email sent successfully to: ' . $customerEmail); // Log successful email sending
                }
            } else {
                error_log('Invalid or missing customer email'); // Log missing or invalid email
            }
        } else {
            error_log('Missing customer ID'); // Log missing customer ID
        }
    } else {
        error_log('Received non-completed session event: ' . $event->type); // Log non-completed session events
    }
} else {
    error_log('Failed to decode event'); // Log failed event decoding
}