<?php
$ch = curl_init();
$clientId = 'paste here your client id';
$secret = 'paste here your secrete';
curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSLVERSION, 6); //NEW ADDITION
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $secret);
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
$result = curl_exec($ch);
$json = json_decode($result);
$access_token =  $json->access_token;

$paymentcurl = curl_init();

$payment_url = 'https://api.sandbox.paypal.com/v1/payments/payment';

$headers = array(
    "Content-Type: application/json",
    "Authorization: Bearer " . $access_token . ""
);
$data = '{
    "transactions": [{
    "amount": {
        "currency":"USD",
        "total":"12"
    },
    "description":"Deposit on optim"
    }],
    "payer": {
        "payment_method":"paypal"
    },
    "intent":"sale",
    "redirect_urls": {
        "cancel_url":"http://myurl.com/cancel.php",
        "return_url":"http://myurl.com/return.php"
    }
}';

curl_setopt($paymentcurl, CURLOPT_URL, $payment_url);
curl_setopt($paymentcurl, CURLOPT_VERBOSE, true);
curl_setopt($paymentcurl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($paymentcurl, CURLOPT_POST, true);
curl_setopt($paymentcurl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($paymentcurl, CURLOPT_POSTFIELDS, $data);

$resultpayment = curl_exec($paymentcurl);
$jsonresponse = json_decode($resultpayment);
$redirect = $jsonresponse->links[1]->href;
echo "<script>window.location.href='" . $redirect . "'; </script>";
curl_close($paymentcurl);
