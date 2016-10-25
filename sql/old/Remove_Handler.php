<?php
/**
 * Created by IntelliJ IDEA.
 * User: Grant Delacampa
 * Date: 10/18/2016
 * Time: 3:36 PM
 */

/**connects to database*/
include_once 'Db_connect.php';

function remove_from_user_table($phone, $user)
{
    global $link;
    $sql = "DELETE FROM user_table WHERE 
            (phone_number = $phone) AND 
            (user_password = $user)";
    if ($link->query($sql) === true) {
        echo "Records Deleted";
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
}

function remove_from_parking_spot($id, $area, $spot, $is_taken, $phone_number, $floor)
{
    global $link;
    $sql = "DELETE FROM parking_spot WHERE 
            (id = $id) AND 
            (area = $area)AND 
            (spot = $spot) AND 
            (is_taken = $is_taken) AND 
            (user_phone_number = $phone_number) AND 
            (floor= $floor)";
    if ($link->query($sql) === true) {
        echo "Records Deleted";
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
}

function remove_from_parking_journal($money, $user)
{
    global $link;
    $sql = "DELETE FROM parking_journal WHERE 
            (money = $money) AND 
            (user_phone_number = $user) AND";
    if ($link->query($sql) === true) {
        echo "Records Deleted";
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
}
/**test functions*/
remove_from_parking_spot(1234, 3, 24,1, 707, 3);
/**end test*/
mysqli_close($link)
?>
