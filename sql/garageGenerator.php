<?php
/**
 * Created by IntelliJ IDEA.
 * User: Grant Delacampa
 * Date: 11/3/2016
 * Time: 11:33 AM
 */
/**
 * Documentation:
 *      Calls SQL_handler to speak with the database
 *      Accepts three values for floor number, spots, and quadrants
 *      Utilizes loops to build database alerts and "builds" a parking garage
 *      Contains:
 *          private function DBErrorHandler
 *
 * NOTES:
 * $link is established inside the first for loop to stop the MySQL timeout
 * at the end of the first for loop the connection is closed and the program sleeps
 * after 10 seconds the loop wakes and connects to the database once more it then
 * runs again repeating this one time for every floor.
 *
 */
set_time_limit(30);  //defaults 30s
$alpha = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
$floors = 4;
$spots = 100;
for ($i=1; $i <= $floors; $i++){
    $time_start = microtime(true);
    echo "connection established<br>";
    //$link = mysqli_connect("Athena.csus.edu", "zainchevsky_user", "zainchevsky_db", "zainchevsky");
        for ($k=1;$k<=$spots; $k++){
            $letter= toLetter($k); //converts the quad count to its corresponding letter
            //$letter = mysqli_real_escape_string($link,$letter);
            //echo 'floor: ' . $i . 'spot: ' . $k . 'area: ' . $letter . `<br>`;
            $SQLQuery = "INSERT INTO parking_spot (`floor`, `spot`, `area`)"
            . " VALUES ('$i', '$k', '$letter')";  //builds database
            $link->query($SQLQuery);
        }
    //mysqli_close($link); // Must close connection
    $time_end = microtime(true);
    $execution_time = $time_end - $time_start;
    echo 'Execution time:  '.$execution_time;
    if($i!=$floors) {
        echo "<br>connection closed now sleeping... please wait<br>";
        sleep(10);
    }
    else{
        echo "<br>Execution Finished Database propagated<br>";
    }
}


//outputs char a representation of a numeric input
function toLetter($var){
        global $alpha;
    //Scalar function for Quadrants of any size $var
        $quad1 = $var/4;
        $quad2 = $quad1*2;
        $quad3 = $quad1*3;
        $quad4 = $quad2*2;
    //Handles the conversion of $var int to Letter
    switch($var){
        case $var<=$quad1:
            return $alpha[0];
            break;
        case $var<=$quad2 && $quad1:
            return $alpha[1];
            break;
        case $var<=$quad3 && $var>$quad2:
            return $alpha[2];
            break;
        case $var<=$quad4 && $var>$quad3:
            return $alpha[3];
            break;
        default:
            return 'Error';
    }
}
?>