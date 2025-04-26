<?php
require_once 'includes/config.php';
require_once 'includes/auth_functions.php';

session_start();
session_destroy();
header("Location: login.php");
exit();
?>