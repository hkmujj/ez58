<?php
/**
 * Created by PhpStorm.
 * User: gaoyi
 * Date: 7/11/17
 * Time: 3:51 PM
 */

if ($s_uid) {
    $row = $db->getRow("SELECT * FROM `{$db_mymps}member` WHERE userid = '{$s_uid}'");

    $lat = $_REQUEST['lat'] ? $_REQUEST['lat'] : '';
    $lng = $_REQUEST['lng'] ? $_REQUEST['lng'] : '';

    if($iflogin == 1 && $row['if_corp'] == 1) {
        if($lat && $lng) {
            $row_sync = $db->getRow("SELECT * FROM `{$db_mymps}coords_sync` WHERE userid = '{$s_uid}'");
            if ($row_sync) {
                $db->query("UPDATE `{$db_mymps}coords_sync` SET lat='{$lat}', lng='{$lng}', updatetime=".mktime()."
                                WHERE userid = '{$s_uid}'");
            } else {
                $db->query("INSERT INTO `{$db_mymps}coords_sync` (userid, lat, lng, updatetime)
                                  VALUES ('{$s_uid}', '{$lat}', '{$lng}', ".time().")");
            }
        }
    }

    if ($iflogin == 1) {
        $row_message = $db->getRow("SELECT * FROM `{$db_mymps}message_sync` WHERE touserid = '{$s_uid}' and isread=0");
        if($row_message) {
            echo json_encode(array('hasmessage'=>1));
        }

        $db->query("UPDATE `{$db_mymps}message_sync` SET isread=1
                                WHERE touserid = '{$s_uid}' and isread=0");
    }
}
