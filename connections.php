<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "pass";
$dbname = "demo";

$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if(!$con)
{
	die("Connection failed!");
}

?>