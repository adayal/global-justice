<?php
if (!isset($_SESSION))
    session_start();
if (isset($_SESSION) && isset($_SESSION['IS_LOGIN_VALID'])) {
    header("dashboard.php");
}
else {
    return false;
}
