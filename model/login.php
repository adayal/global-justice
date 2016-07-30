<?php
if (!isset($_SESSION))
    session_start();
require_once(dirname(__FILE__). "/VerifyLogin.php");
require_once("GetDataMethods.php");
require_once("SetDataMethods.php");
require_once(dirname(__FILE__). "/UserObject.php");
//require_once("VerifyBlockedIP.php");

if (isset($_POST) && $_POST['email'] != "" && $_POST['password'] != "") {
    if (GetDataMethods::verifyEmailPassword($_POST['email'], $_POST['password'])) {
        $_SESSION['IS_LOGIN_VALID'] = true;
        $_SESSION['USER'] = new UserObject(GetDataMethods::getUserId($_POST['email']));
        echo "true";
    }
    else {
        if (isset($_SESSION['NUM_ATTEMPTS'])) {
            $_SESSION['NUM_ATTEMPTS']++;
            if ($_SESSION['NUM_ATTEMPTS'] > 3) {
                SetDataMethods::setBlockedIPAddress($_SESSION['ip']);
            }
            var_dump($_SESSION['NUM_ATTEMPTS']);
        }
        else {
            $_SESSION['NUM_ATTEMPTS'] = 1;
        }
        echo "false";
    }
}
