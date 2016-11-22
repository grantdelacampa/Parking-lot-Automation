<?php
// Headers to allow cross-domain communication
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
$data = file_get_contents("php://input"); // Get AJAX input
if ($data) { // If is it AJAX call with data
    $response = array();
    $json = json_decode($data);
    if (is_null($json)) { // Error: JSON not valid
        $response = array(
            'type' => 'error',
            'value' => 'Invalid JSON.'
        );
    } else {
        $response = getResponse($json);
    }
    header('content-type: application/json; charset=utf-8');
    $encoded = json_encode($response);
    exit($encoded);
} else { // Otherwise, error: Forbidden
    //echo $data;
    http_response_code(403);
    exit('HTTP/1.1 403 Forbidden');
}

function getResponse($json)
{
    switch ($json->request) {
        case 'add_user':
            include '../php/userFunctions.php';
            return addUser($json->data);
            break;
        case 'log_in':
            include '../php/userFunctions.php';
            return logIn($json->data);
            break;
        case 'check_session':
            include '../php/userFunctions.php';
            return checkSession($json->data);
            break;
        case 'click_qr_code':
            include '../php/parkingFunctions.php';
            return clickQRCode($json->data);
            break;
        default:
            return array(
                'type' => 'error',
                'value' => 'Invalid request.',
                'request' => $json->request
            );
    }
}
