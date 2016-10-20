<?php
/**
 * Created by IntelliJ IDEA.
 * User: Grant Delacampa
 * Date: 10/18/2016
 * Time: 6:25 PM
 */
/**connects to database*/

/**TO DO
 * Implement echo statement to adjust and account for varied input in sql_command
 * change output to appropriate format for output in front end.
 * allow use with all DB tables and data*?
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
            echo "id: " . $row["id"]. " - spot: " . $row["spot"]. " ". "<br>";
            /**run switch statement function to run through echo function's.*/
        }
    } else {
        echo "0 results";
    }
}

/**test environemnt*/

/**variable command example to read data from MySql*/
read("SELECT id, area, spot FROM parking_spot");

/**end test environemnt*/
mysqli_close($link);

?>