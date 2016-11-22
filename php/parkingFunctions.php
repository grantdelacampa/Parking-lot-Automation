<?php

function clickQRCode($data)
{
    $userQRCode = $data->qr_code;

    //run DB query SELECT * FROM `p_spot` WHERE qr_code = $userQRCode;
    //
    //if rows.count > 0
    //
    //  is_taken = false;
    //  qr_code = null;
    //  p_journal -> all records with this qr_code
    //      if any have ts_end == null
    //          ts_end = date
    //          calc Money -> put into `money`
    //else
    //
    //  look for closest !taken spot (SORT BY)
    //  if all is taken -> error
    //  else use that closest spot
    //      is taken = true
    //      qr_code =  $userQRCode
    //      p_journal
    //          qr code
    //          ts_start

    return 'clickQRCode()';
}
