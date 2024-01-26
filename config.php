<?
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

$host = "localhost"; 
$username = "kalpclou_fcmp"; 
$password = "ItzKalp1@"; 
$dbname = "kalpclou_fcmp";

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
    $txt = "connection error\n";
    fwrite($myfile, $txt);
    $txt = "Jane Doe\n";
    fwrite($myfile, $txt);
    fclose($myfile);
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_query($conn,"SET NAMES utf8");
	
?>

<?php 
function bugRemoval($variable)
{
return(mysqli_real_escape_string($GLOBALS['conn'],$variable));
}

?>