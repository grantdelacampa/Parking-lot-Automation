<?php
/**
 * Created by IntelliJ IDEA.
 * User: Grant Delacampa
 * Date: 11/22/2016
 * Time: 7:11 PM
 */
try {
    include_once '../sql/SQL_Handler.php';
    $query = "SELECT * FROM parking_journal";
    //first pass just gets the column names
    print "<table> n";
    $result = read($query);
    //return only the first row (we only need field names)
    $row = $result->fetch(PDO::FETCH_ASSOC);
    print " <tr> n";
    foreach ($row as $field => $value){
        print " <th>$field</th> n";
    } // end foreach
    print " </tr> n";
    //second query gets the data
    $data = read($query);
    $data->setFetchMode(PDO::FETCH_ASSOC);
    foreach($data as $row){
        print " <tr> n";
        foreach ($row as $name=>$value){
            print " <td>$value</td> n";
        } // end field loop
        print " </tr> n";
    } // end record loop
    print "</table> n";
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
} // end try
?>