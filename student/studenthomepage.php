<?php

session_start();

if(!isset($_SESSION['userid'])){
	header("location:login.php");
	exit();
}

include("../includes/header.php");
include("studentsidebar.php");
include("../includes/navbar.php");
include("../includes/footer.php");


 ?>