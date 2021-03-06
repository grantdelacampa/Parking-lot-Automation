<?php

function clickQRCode($data)
{
    $userQRCode = $data->qr_code;

    $SQLQuery = "SELECT * FROM parking_spot WHERE `qr_code` = '{$userQRCode}' ORDER BY `id` ASC;";

    include_once '../sql/SQL_Handler.php';

    $DBResponse = read($SQLQuery);

    if ($DBResponse['type'] == 'error' && !isset($DBResponse['count'])) {
        closeDB();
        return $DBResponse;
    } else {
        if ($DBResponse['count'] > 0) { // There is a spot with this QR code, we need to kick it out
            $recordID = $DBResponse['records'][0]['id'];

            $SQLQuery2 = "UPDATE parking_spot SET `qr_code` = NULL, `is_taken` = 0 WHERE `id` = '{$recordID}';";
            $DBResponse2 = alter($SQLQuery2);

            if ($DBResponse2['type'] == 'error') {
                closeDB();
                return $DBResponse2;
            } else {
                $SQLQuery3 = "SELECT * FROM parking_journal WHERE `qr_code` = '{$userQRCode}' ORDER BY `id` DESC;";
                $DBResponse3 = read($SQLQuery3);

                if ($DBResponse3['type'] == 'error') {
                    closeDB();
                    return $DBResponse3;
                } else {
                    $records = $DBResponse3['records'];
                    $journalID = -1;
                    $startDate = '';
                    for ($i = 0; $i < count($records); $i++) {
                        if ($records[$i]['ts_end'] == NULL) {
                            $journalID = $records[$i]['id'];
                            $startDate = $records[$i]['ts_start'];
                            break;
                        }
                    }
                    if ($journalID == -1) {
                        closeDB();
                        return array(
                            'type' => 'error',
                            'value' => 'Error: nothing found in parking journal table!'
                        );
                    } else {
                        $startDate = strtotime($startDate);
                        $currentTime = time();
                        $secondsPassed = $currentTime - $startDate;
                        $money = $secondsPassed / 1800; // 1 hour = 3600 seconds = 1800 * 2 = $2

                        $SQLQuery4 = "UPDATE parking_journal SET `money` = '{$money}', `ts_end` = CURRENT_TIMESTAMP WHERE `id` = '{$journalID}';";
                        $DBResponse4 = alter($SQLQuery4);
                        closeDB();

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
        } else { // Give space for this user
            $SQLQuery = "SELECT * FROM parking_spot WHERE `is_taken` = 0 ORDER BY `id` LIMIT 1;";
            $DBResponse = read($SQLQuery);

            if ($DBResponse['type'] == 'error' && !isset($DBResponse['count'])) {
                closeDB();
                return $DBResponse;
            } else {
                if ($DBResponse['count'] < 1) {
                    closeDB();
                    return array(
                        'type' => 'error',
                        'value' => 'Error: no more space available!'
                    );
                } else {
                    $spotID = $DBResponse['records'][0]['id'];
                    $SQLQuery2 = "UPDATE parking_spot SET `qr_code` = '{$userQRCode}', `is_taken` = 1 WHERE `id` = '{$spotID}';";
                    $DBResponse2 = alter($SQLQuery2);
                    if ($DBResponse2['type'] == 'error') {
                        closeDB();
                        return $DBResponse2;
                    } else {
                        $SQLQuery3 = "INSERT INTO `parking_journal` (`id`, `money`, `qr_code`, `ts_start`, `ts_end`) VALUES (NULL, '', '{$userQRCode}', CURRENT_TIMESTAMP, NULL);";
                        $DBResponse3 = alter($SQLQuery3);
                        closeDB();

                        if ($DBResponse3['type'] == 'error')
                            return $SQLQuery3;
                        else {
                            return array(
                                'type' => 'success',
                                'value' => 'Opted-in successfully!',
                                'do' => 'opt-in',
                                'parking_info' => $DBResponse['records'][0],
                                'ts' => date("Y-m-d H-i-s")
                            );
                        }
                    }
                }
            }
        }
    }
}

function checkParkingStatus($data)
{
    $userQRCode = $data->qr_code;

    $SQLQuery = "SELECT * FROM parking_journal WHERE `qr_code` = '{$userQRCode}' ORDER BY `id` DESC;";
    include_once '../sql/SQL_Handler.php';
    $DBResponse = read($SQLQuery);

    if ($DBResponse['type'] == 'error' && !isset($DBResponse['count'])) {
        closeDB();
        return $DBResponse;
    } else {
        if ($DBResponse['count'] < 1) {
            return array(
                'type' => 'success',
                'value' => 'User never parked.'
            );
        } else {
            $records = $DBResponse['records'];
            $isFound = false;
            $current = '';
            for ($i = 0; $i < count($records); $i++) {
                if ($records[$i]['ts_end'] == NULL) {
                    $isFound = true;
                    $current = $records[$i];
                    break;
                }
            }
            if (!$isFound) {
                return array(
                    'type' => 'success',
                    'value' => 'User is not opted-in.'
                );
            } else {
                $SQLQuery2 = "SELECT * FROM parking_spot WHERE `qr_code` = '{$userQRCode}' ORDER BY `id` ASC;";
                $DBResponse2 = read($SQLQuery2);
                closeDB();

                if ($DBResponse2['type'] == 'error' && !isset($DBResponse2['count'])) {
                    closeDB();
                    return $DBResponse2;
                } else {
                    if ($DBResponse2['count'] < 1) {
                        return array(
                            'type' => 'error',
                            'value' => 'Strange error, user has active record in parking journal, but s/he is not found on parking lot.'
                        );
                    } else {
                        $current['area'] = $DBResponse2['records'][0]['area'];
                        $current['spot'] = $DBResponse2['records'][0]['spot'];
                        $current['floor'] = $DBResponse2['records'][0]['floor'];
                        return array(
                            'type' => 'success',
                            'value' => 'User is indeed opted-in!',
                            'parking_info' => $current
                        );
                    }
                }
            }
        }
    }
}
