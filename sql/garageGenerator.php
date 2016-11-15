<?php
/**
 * Created by IntelliJ IDEA.
 * User: Grant Delacampa
 * Date: 11/3/2016
 * Time: 11:33 AM
 */
/**
 * Documentation:
 *      Alters PHP timeout to 60s.
 *      Calls Db_connect to speak with the database.
 *      omitted SQL_Handler to prevent redundant calls.
 *      Accepts two values for floor number, and spots.
 *      Utilizes loops to build database alerts and "builds" a parking garage
 *      Contains:
 *          private function DBErrorHandler
 *          private function toLetter($var)
 *
 */

include_once '../sql/Db_connect.php';

set_time_limit(60);  //PHP standardized timeout is 25 or 30s
$alpha = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
//array MUST consist of elements in single quotations
$floors = 4;
$spots = 100;
connectToDB();

for ($i=1; $i <= $floors; $i++){
    //$time_start = microtime(true); //start timer
        for ($k=1;$k<=$spots; $k++){
            $letter= toLetter($k); //converts the spot count to quadrants then to its corresponding letter
            $SQLQuery = "INSERT INTO parking_spot (`floor`, `spot`, `area`)"
            . " VALUES ('$i', '$k', '$letter')";  //builds database
            $link->query($SQLQuery);
        }
    //$time_end = microtime(true); //end timer
    //$execution_time = $time_end - $time_start; //calculate run time
    //echo "<br>" . 'Execution time:  '.$execution_time . "<br>";
}

closeDB();

//outputs char as representation of a numeric input
function toLetter($var){
        global $alpha;
        global $spots;
    //Handles the conversion of $var int to Letter
    switch($var){
        case $var <= $spots * .25:  //for 1 to 25 print A
            return $alpha[0];
            break;
        case ($var <= $spots * .50) && ($var > $spots * .25): //for 26 to 50 print B
            return $alpha[1];
            break;
        case ($var <= $spots * .75) && ($var > $spots * .50): //for 51 to 75 print C
            return $alpha[2];
            break;
        case ($var <= $spots) && ($var > $spots * .75): //for 76 to 100 print D
            return $alpha[3];
            break;
        default:
            return 'Error'; //Sends error into MySQL table when $var<0 or $var>100
    }
}
?>