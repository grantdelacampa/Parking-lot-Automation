<?php
/**
 * Created by IntelliJ IDEA.
 * User: Grant Delacampa
 * Date: 10/18/2016
 * Time: 9:06 PM
 */
include_once 'sql_config.php';

$link = '';

function connectToDB()
{
    global $link;
    $link = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (!$link)
        $response = array(
            'type' => 'error',
            'value' => 'Error: unable to connect to MySQL.',
            'error_details' => $link->error
        );
    else {
        $response = array(
            'type' => 'success',
            'value' => 'Successfully connected to MySQL.',
        );
    }
    return $response;
}
