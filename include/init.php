<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include 'include/db_config.php';
include 'include/class.db.php';
$database = new DB();
?>