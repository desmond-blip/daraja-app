<?php
header('Content-Type: application/json');

// Get token
$tokenResponse = file_get_contents('http://localhost/mpesa-api/accessToken.php');
$tokenData = json_decode($tokenResponse);
$accessToken = $tokenData->access_token ?? null;

if (!$accessToken) {
    echo json_encode(['error' => 'Unable to fetch access token']);
    exit;
}

// Config
$BusinessShortCode = '174379';
$Passkey = 'YOUR_PASSKEY';
$Timestamp = date('YmdHis');
$Password = base64_encode($BusinessShortCode . $Passkey . $Timestamp);

// User inputs
$PhoneNumber = $_POST['phone'] ?? '254746268041';
$Amount = $_POST['amount'] ?? 1;

$curl_post_data = [
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $Password,
    'Timestamp' => $Timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $Amount,
    'PartyA' => $PhoneNumber,
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => $PhoneNumber,
    'CallBackURL' => 'https://yourdomain.com/mpesa-api/callback.php',
    'AccountReference' => 'Mpesa Test',
    'TransactionDesc' => 'STK Push test'
];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken
]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($curl_post_data));

$response = curl_exec($curl);
curl_close($curl);
echo $response;
