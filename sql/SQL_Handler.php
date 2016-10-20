<?php
/**
 * Created by IntelliJ IDEA.
 * User: Grant Delacampa
 * Date: 10/20/2016
 * Time: 3:05 PM
 * Contains the following functions:
 * Read(S$QL)
 * wr() stands for write/remove
 * All accept MySQL code as input
 */

include_once 'Db_connect.php';


Function read($sql_command)
{
    global $link;
    $sql = $sql_command;                    /**allows variable commands to be sent to MySQL*/
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {

            /**Echos table date for testing purposes*/
            echo "id: " . $row["id"]. " - spot: " . $row["spot"]. " ". "<br>";
            /**run switch statement function to run through echo function's.*/

            /**returns row for implimentation in the system*/
            return $row;

        }
    } else {
        echo "0 results";
    }
}

/**Write and Read function*/
function wr($sql_command)
{
    global $link;
    $sql = $sql_command;
    if ($link->query($sql) === true) {
        echo "Records Altered";
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
}


mysqli_close($link)
?>