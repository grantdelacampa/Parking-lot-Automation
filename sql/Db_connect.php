<?php
/**
 * Created by IntelliJ IDEA.
 * User: Grant Delacampa
 * Date: 10/18/2016
 * Time: 9:06 PM
 */
include_once 'sql_config.php';

$link =mysqli_connect(HOST, USER, PASSWORD, DATABASE);
if(!$link)
    echo "Error unable to connect to MySQL";
?>