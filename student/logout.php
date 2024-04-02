<?php
require_once "../core/UserCtrl.php";

UserCtrl::logout();
header("location: /student/login.php");
exit();