<?php

function clickQRCode($data)
{
    $userQRCode = $data->qr_code;

    $SQLQuery = "SELECT * FROM parking_spot WHERE `qr_code` = '{$userQRCode}' ORDER BY `id` ASC;";

    include_once '../sql/SQL_Handler.php';

    $DBResponse = read($SQLQuery);

    if ($DBResponse['type'] == 'error' && !isset($DBResponse['count'])) {
        global $link;
        mysqli_close($link); // Must close connection
        return $DBResponse;
    }
    else {
        if($DBResponse['count'] > 0) { // There is a spot with this QR code, we need to kick it out
            $recordID = $DBResponse['records'][0]['id'];

            $SQLQuery2 = "UPDATE parking_spot SET `qr_code` = NULL, `is_taken` = 0 WHERE `id` = '{$recordID}';";
            $DBResponse2 = alter($SQLQuery2);

            if ($DBResponse2['type'] == 'error') {
                global $link;
                mysqli_close($link); // Must close connection
                return $DBResponse2;
            }
            else {
                $SQLQuery3 = "SELECT * FROM parking_journal WHERE `qr_code` = '{$userQRCode}';";
                $DBResponse3 = read($SQLQuery3);

                if ($DBResponse3['type'] == 'error') {
                    global $link;
                    mysqli_close($link); // Must close connection
                    return $DBResponse3;
                }
                else {
                    $records = $DBResponse3['records'];
                    $journalID = -1;
                    $startDate = '';
                    for($i = 0; $i < count($records); $i++) {
                        if($records[$i]['ts_end'] == NULL) {
                            $journalID = $records[$i]['id'];
                            $startDate = $records[$i]['ts_start'];
                            break;
                        }
                    }
                    if($journalID == -1) {
                        global $link;
                        mysqli_close($link); // Must close connection
                        return array(
                            'type' => 'error',
                            'value' => 'Error: nothing found in parking journal table!'
                        );
                    }
                    else {
                        $startDate = strtotime($startDate);
                        $currentTime = time();
                        $secondsPassed = $currentTime - $startDate;
                        $money = $secondsPassed / 180; // 1 hour = 360 seconds = 180 * 2 = $2

                        $SQLQuery4 = "UPDATE parking_journal SET `money` = '{$money}', `ts_end` = CURRENT_TIMESTAMP WHERE `id` = '{$journalID}';";
                        $DBResponse4 = alter($SQLQuery4);
                        global $link;
                        mysqli_close($link); // Must close connection

                        if ($DBResponse4['type'] == 'error')
                            return $DBResponse4;
                        else {
                            return array(
                                'type' => 'success',
                                'value' => 'Opted-out successfully!',
                                'do' => 'opt-out'
                            );
                        }
                    }
                }
            }
        }

        else { // Give space for this user
            $SQLQuery = "SELECT * FROM parking_spot WHERE `is_taken` = 0 ORDER BY `id` LIMIT 1;";
            $DBResponse = read($SQLQuery);

            if ($DBResponse['type'] == 'error' && !isset($DBResponse['count'])) {
                global $link;
                mysqli_close($link); // Must close connection
                return $DBResponse;
            }
            else {
                if($DBResponse['count'] < 1) {
                    global $link;
                    mysqli_close($link); // Must close connection
                    return array(
                        'type' => 'error',
                        'value' => 'Error: no more space available!'
                    );
                }
                else {
                    $spotID = $DBResponse['records'][0]['id'];
                    $SQLQuery2 = "UPDATE parking_spot SET `qr_code` = '{$userQRCode}', `is_taken` = 1 WHERE `id` = '{$spotID}';";
                    $DBResponse2 = alter($SQLQuery2);
                    if ($DBResponse2['type'] == 'error') {
                        global $link;
                        mysqli_close($link); // Must close connection
                        return $DBResponse2;
                    }
                    else {
                        $SQLQuery3 = "INSERT INTO `parking_journal` (`id`, `money`, `qr_code`, `ts_start`, `ts_end`) VALUES (NULL, '', '{$userQRCode}', CURRENT_TIMESTAMP, NULL);";
                        $DBResponse3 = alter($SQLQuery3);
                        global $link;
                        mysqli_close($link); // Must close connection

                        if ($DBResponse3['type'] == 'error')
                            return $SQLQuery3;
                        else {
                            return array(
                                'type' => 'success',
                                'value' => 'Opted-in successfully!',
                                'do' => 'opt-in',
                                'parking-info' => $DBResponse['records'][0]
                            );
                        }
                    }
                }
            }
        }
    }
}
