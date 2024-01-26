<?php

session_start();

if( isset($_POST['myusername']) )
{
     include 'config.php';

     $myusername=bugRemoval($_POST['myusername']); 
     $mypassword=md5(bugRemoval($_POST['mypassword'])); 

     $sql="SELECT * FROM users WHERE username='$myusername' AND password='$mypassword'";
     $result=mysqli_query($conn,$sql);
     $count=mysqli_num_rows($result);
      

     if($count==1)
     {
         while( $row = mysqli_fetch_assoc( $result ) )
         {
             $status = bugRemoval($row['status']);
         }
        
         	
        if($status=='approved')
        {
          $_SESSION["myusername"]=$myusername;

          echo"<script type='text/javascript'>
          window.location.href='dashboard.php';
          </script>";
        }
        else
        {
            echo"<script type='text/javascript'>
            alert('Account is in pending state.');
          window.location.href='login.php';
          </script>";
        }
     }
     else
     {
          $sql="SELECT * FROM users WHERE email='$myusername' AND password='$mypassword'";
          $result=mysqli_query($conn,$sql);
          $count=mysqli_num_rows($result);

          if($count==1)
          {
               $sql="SELECT username FROM users WHERE email='$myusername'";
               $result=mysqli_query($conn,$sql);
               while( $row = mysqli_fetch_assoc( $result ) ) {
                	$myusername = bugRemoval($row['username']);
                }

               $_SESSION["myusername"]=$myusername;

               echo"<script type='text/javascript'>
               window.location.href='dashboard.php';
               </script>";
          }
          else
          {
               echo"<script type='text/javascript'>
               alert('The username or password you entered is incorrect');
               window.location.href='login.php';
               </script>";
          }
     }
}
else
{
     echo"<script type='text/javascript'>
     alert('Oops something went wrong');
     window.location.href='login.php';
     </script>";
}
?>