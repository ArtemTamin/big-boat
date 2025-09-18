<?php   
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postUrl = 'https://api.mtsbank.ru/online-stores-pos/v1/applications';
    $data = json_encode($_POST['data']);

    $ch = curl_init($postUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Client-id: online-stores-pos'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode == 200) {
        echo $response;
    } else {
        $errorDetails = curl_error($ch);
        echo json_encode([
            'error' => 'Request failed',
            'http_code' => $httpCode,
            'details' => $errorDetails
        ]);
    }

    curl_close($ch);
}
?>