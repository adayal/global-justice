<?php

require_once("GetDataMethods");

$ip = $_SESSION['SERVER_ADDR']; //get ip address of request
if (GetDataMethods::checkBlockedIPAddress($ip)) {
    header("index.php?=error='banned_ip_address'");
}
else {
    return true;
}
