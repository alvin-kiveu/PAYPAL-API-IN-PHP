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

curl_close($ch);


$url = 'https://api-m.sandbox.paypal.com/v2/invoicing/invoices?total_required=true';
$chs = curl_init($url);
$headers = [
    "Content-Type: application/json",
    "Authorization: Bearer " . $access_token . ""
];
curl_setopt($chs, CURLOPT_HTTPHEADER, $headers);
curl_setopt($chs, CURLOPT_RETURNTRANSFER, true);
echo $results = curl_exec($chs);
curl_close($chs);
