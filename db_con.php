<?php
session_start();
error_reporting(0);
global $con;
$con = mysqli_connect('localhost','root','','report_builder1') or die(mysqli_error());
define("path","http://localhost/report_builder/");
?>