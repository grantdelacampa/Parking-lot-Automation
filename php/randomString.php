<?php

function RandomString($data)
{
    $Letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $timeStamp = date("misdHYs");
    $Unite = $Letters . $timeStamp . $data;
    $res = "";
    for ($i = 0; $i < 10; $i++)
        $res .= $Unite[mt_rand(0, strlen($Unite) - 1)];
    return $res;
}
