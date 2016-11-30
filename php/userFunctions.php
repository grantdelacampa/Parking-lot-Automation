<?php

/*
 * - Get `POST`ed data
 * - Run SQL query that will write `POST`ed data to `DB`
 * - Return result
 */
function addUser($data)
{
    $email = $data->email;
    $fullName = $data->fullName;
    $telephone = $data->telephone;
    $password = $data->password;

    include_once '../php/randomString.php';
    $cleanTelephone = str_replace(str_split(' -()'), '', $telephone); // Remove some chars
    $QR_code = RandomString($cleanTelephone);

    $SQLQuery = "INSERT INTO user_table (`password`, `qr_code`, `email`, `full_name`, `phone_number`)"
        . " VALUES ('$password', '$QR_code', '$email', '$fullName', '$cleanTelephone');";

    include_once '../sql/SQL_Handler.php';

    $DBResponse = alter($SQLQuery); // Run query, get results
    global $link;
    mysqli_close($link); // Must close connection

    if ($DBResponse['type'] == 'error') // Handle error
        return array(
            'type' => 'error',
            'value' => 'Can\'t create user, DB error.',
            'error_details' => $DBResponse
        );
    else
        return array(
            'type' => 'success',
            'value' => 'Successfully created user!',
            'db_details' => $DBResponse
        );
}

/*
 * - Check if session is there
 * - Return result
 */
function checkSession($data)
{
    session_id($data->session_id);
    session_start();
    if (!isset($_SESSION['user']))
        return array(
            'type' => 'error',
            'value' => 'Empty session, user is not logged in.'
        );
    else
        return array(
            'type' => 'success',
            'value' => 'User is logged in!',
            'session' => $_SESSION['user']
        );
}

/*
 * - Check if user exists in DB table and password is correct
 * - Return result
 */
function logIn($data)
{
    $telephone = trim($data->telephone);
    $password = trim($data->password);

    $SQLQuery = "SELECT * FROM user_table WHERE `phone_number` = '{$telephone}' AND `password` = '{$password}';";

    include_once '../sql/SQL_Handler.php';

    $DBResponse = read($SQLQuery); // Run query, get results
    global $link;
    mysqli_close($link); // Must close connection

    if ($DBResponse['type'] == 'error')
        return array(
            'type' => 'error',
            'value' => 'No such user or wrong combination.',
            'db_response' => $DBResponse
        );
    else {
        session_start();
        if (session_status() == PHP_SESSION_ACTIVE) {
            $_SESSION['user'] = $telephone;
            return array(
                'type' => 'success',
                'value' => 'Successfully initialized user session.',
                'session_id' => session_id(),
                'user' => array(
                    'full_name' => $DBResponse['records'][0]['full_name'],
                    'email' => $DBResponse['records'][0]['email'],
                    'qr_code' => $DBResponse['records'][0]['qr_code']
                )
            );
        } else {
            return array(
                'type' => 'error',
                'value' => 'Can\'t initialize session.'
            );
        }
    }
}

function logOut($data)
{
    session_id($data->session_id);
    session_start();
    if (session_status() == PHP_SESSION_ACTIVE) {
        session_destroy();      //destroys the session
        return array(
            'type' => 'success',
            'value' => 'User session terminated'
        );
    } else {
        return array(
            'type' => 'error',
            'value' => 'No user session in progress'
        );
    }
}
