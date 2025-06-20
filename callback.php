<?php
// Get the raw JSON data
$mpesaResponse = file_get_contents('php://input');

// Save to file or log
file_put_contents('stk_response.json', $mpesaResponse, FILE_APPEND);

// Optionally decode and use
$data = json_decode($mpesaResponse, true);

// Return success to Safaricom
echo json_encode(['ResultCode' => 0, 'ResultDesc' => 'STK Callback received successfully']);
?>
