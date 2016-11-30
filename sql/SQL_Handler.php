<?php
/**
 * Created by IntelliJ IDEA.
 * User: Grant Delacampa
 * Date: 10/20/2016
 * Time: 3:05 PM
 * Contains the following functions:
 * read(SQL query)
 * alert(SQL query) write/remove
 * All accept MySQL code as input
 */

include_once 'Db_connect.php';

$db_connection = connectToDB();

function read($sql_command)
{
    global $link; // Using global $link

    $db_result = $link->query($sql_command); // Run query

    if (!$db_result) {
        $response = array(
            'type' => 'error',
            'query' => $sql_command,
            'value' => 'Error: unable to run MySQL read query.',
            'mysqli_error' => mysqli_error($link),
            'mysqli_errno' => mysqli_errno($link)
        );
    } else {
        if ($db_result->num_rows > 0) {
            $records = array();
            while ($row = $db_result->fetch_assoc()) { // Output data of each row
                $records[] = $row;
            }
            $response = array(
                'type' => 'success',
                'value' => 'Successfully got data from DB.',
                'count' => $db_result->num_rows,
                'records' => $records
            );
        } else {
            $response = array(
                'type' => 'error',
                'value' => 'Error: no record.',
                'count' => 0,
            );
        }
    }
    return $response;
}

function alter($sql_command)
{
    global $link; // Using global $link

    $db_result = $link->query($sql_command); // Run query

    if (!$db_result) {
        $response = array(
            'type' => 'error',
            'query' => $sql_command,
            'value' => 'Error: unable to run MySQL alter query.',
            'mysqli_error' => mysqli_error($link),
            'mysqli_errno' => mysqli_errno($link)
        );
    } else {
        $response = array(
            'type' => 'success',
            'value' => 'Successfully changed data in DB.'
        );
    }
    return $response;
}
