<?php
// Headers to allow cross-domain communication
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

if (!isset($_GET['qr_code'])) {
    echo 'Error';
} else {

    $data = (object)array('qr_code' => $_GET['qr_code']);

    include '../php/parkingFunctions.php';
    $result = clickQRCode($data);

    echo $result['value'];

}

