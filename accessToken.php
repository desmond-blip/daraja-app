<?php
header('Content-Type: application/json');

// Replace with your app credentials
$consumerKey = 'xtv6pMmMtwnnAzGeLHhoJ2jZwTDPGlkA2ZJkIbLcw';
$consumerSecret = 'yACsCUxP6TninAzD3lgfziDi8fWbl0mLrYrc5ERQAaoWAvKW4beUYOqrkC23D51XE';

// Daraja endpoint
$url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
// Use production endpoint when going live
// $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

// Encode credentials
$credentials = base64_encode($consumerKey . ':' . $consumerSecret);

// Initialize curl
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Execute
$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

// Handle response
if ($httpCode == 200) {
    echo $response; // Already in JSON format with "access_token" and "expires_in"
} else {
    echo json_encode([
        'error' => 'Failed to generate token',
        'status_code' => $httpCode,
        'details' => json_decode($response, true)
    ]);
}
?>

