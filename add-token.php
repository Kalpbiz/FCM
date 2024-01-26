<?php
include 'config.php';
if(isset($_GET['token']) && isset($_GET['domain']))
{
    $token = bugRemoval($_GET['token']);
    $domain = bugRemoval($_GET['domain']);
    
    $count = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `tokens` WHERE token = '".$token."' "));
    
    if($count == 0)
    {
        mysqli_query($conn,"INSERT INTO `tokens`(`token`, `domain`, `time`) VALUES ('".$token."' , '".$domain."' , NOW()) ");  
    }
}
?>