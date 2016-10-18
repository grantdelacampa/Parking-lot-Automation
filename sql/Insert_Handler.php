<?php
/**
 * Created by IntelliJ IDEA.
 * User: Grant Delacampa
 * Date: 10/18/2016
 * Time: 3:10 PM
 */
$link =mysqli_connect("athena.csus.edu", "zainchevsky_user","zainchevsky_db","zainchevsky");
if(!$link)
    echo "Error unable to connect to MySQL";

function insertTo_user_table($phone, $user, $qr)
{
    global $link;
    $sql = "INSERT INTO user_table(phone_number, user_password, QRcode)
    VALUES($phone, $user, $qr)";

    if ($link->query($sql) === true) {
        echo "record created";
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
}

function insertTo_parking_jornal($charge, $number, $start, $end)
{
    global $link;
    $sql = "INSERT INTO parking_journal(money,user_phone_number,ts_start, ts_end)
    VALUES($charge, $number, $start, $end)";

    if ($link->query($sql) === true) {
        echo "Record Created";
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
}

function insertTo_parking_spot($id, $area, $spot, $is_taken, $phone_number, $floor)
{
    global $link;
    $sql = "INSERT INTO parking_spot(id, area, spot, is_taken, user_phone_number, floor)
    VALUES($id, $area, $spot, $is_taken, $phone_number, $floor)";

    if ($link->query($sql) === true) {
        echo "Record Created";
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
}

/**test functions*/
    insertTo_parking_spot(1234, 3, 24,1, 707, 3);
/**End Test*/
mysqli_close($link)
?>