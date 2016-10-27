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
        . " VALUES ('$password', '$QR_code', '$email', '$fullName', '$cleanTelephone')";

    include_once '../sql/SQL_Handler.php';

    $DBResponse = alert($SQLQuery); // Run query, get results

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
