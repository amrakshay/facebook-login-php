<?php 
	session_start();
    unset($_SESSION['FBID']);
    unset($_SESSION['FULLNAME']);
    unset($_SESSION['EMAIL']);
	header("Location: index.php"); // you can enter home page here ( Eg : header("Location: " ."http://www.krizna.com"); 
?>