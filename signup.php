<?php
session_start();

$myname = $myemail = $myusername = $phno = $mydomain = $mypassword1 = $mypassword2 = '';

if(isset($_SESSION['myusername']))
{
     echo"<script type='text/javascript'>
     window.location.href='dashboard.php';
     </script>";
     exit();
}

if( isset($_POST['signupp']) )
{
     include 'config.php';
	 

     $myname=bugRemoval($_POST['myname']);
	 $myemail=bugRemoval($_POST['myemail']);
     $myusername=bugRemoval($_POST['myusername']);
     $phno=bugRemoval($_POST['phno']);
     $mydomain=bugRemoval($_POST['mydomain']);
     $mypassword1=md5(bugRemoval($_POST['mypassword1']));
     $mypassword2=md5(bugRemoval($_POST['mypassword2']));

     if($mypassword1 != $mypassword2)
     {
          echo"<script type='text/javascript'>
          alert('Password do not match');
          window.location.href='signup.php';
          </script>";
     }
    
     else 
     {
          $sql="SELECT * FROM users WHERE username='$myusername' OR email='$myemail'";
          $result=mysqli_query($conn,$sql);
          $count=mysqli_num_rows($result);

          if($count==1)
          {
               echo"<script type='text/javascript'>
               alert('This Username or Email already exists');
               window.location.href='login.php';
               </script>";
          }
          else
          {
              $sql="INSERT INTO `users`(`name`, `email`, `username`, `phone`, `domain`, `status`, `password`, `push_api`) VALUES ('".$myname."','".$myemail."','".$myusername."','".$phno."','".$mydomain."','pending','".$mypassword1."','0')";
              $result=mysqli_query($conn,$sql);

              echo"<script type='text/javascript'>
              window.location.href='dashboard.php';
              </script>";
          }
     }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sign Up</title>

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

    <!-- Simplebar -->
    <link type="text/css" href="assets/vendor/simplebar.min.css" rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css" href="assets/css/app.css" rel="stylesheet">
    <link type="text/css" href="assets/css/app.rtl.css" rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css" href="assets/css/vendor-material-icons.css" rel="stylesheet">
    <link type="text/css" href="assets/css/vendor-material-icons.rtl.css" rel="stylesheet">

    <!-- Font Awesome FREE Icons -->
    <link type="text/css" href="assets/css/vendor-fontawesome-free.css" rel="stylesheet">
    <link type="text/css" href="assets/css/vendor-fontawesome-free.rtl.css" rel="stylesheet">

</head>

<body class="layout-login">





    <div class="layout-login__overlay"></div>
    <div class="layout-login__form bg-white" data-simplebar>
        <div class="d-flex justify-content-center mt-2 mb-5 navbar-light">
            <a href="index.php" class="navbar-brand" style="min-width: 0">
                <img class="navbar-brand-icon" src="assets/images/stack-logo-blue.svg" width="25" alt="Push Network">
                <span>Push Ad Network</span>
            </a>
        </div>

        <h4 class="m-0">Welcome!</h4>
        <p class="mb-5">Create Your Account With Us.</p>

        <div class="alert alert-soft-warning d-flex align-items-center card-margin" role="alert">
            <i class="material-icons mr-3">error_outline</i>
            <div class="text-body"><strong>Warning:</strong> Only approved for Websites with 100k monthly traffic and 0% Spam <a href="#">Learn More </a></div>
        </div>
        <form action="" method="POST">
            <div class="form-group">
                <label class="text-label" for="myname">Full Name:</label>
                <div class="input-group input-group-merge">
                    <input id="myname" type="text" required="" value="<?php echo $myname; ?>" name="myname" class="form-control form-control-prepended" placeholder="Mark Zuck">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="far fa-envelope"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="text-label" for="myemail">Email Address:</label>
                <div class="input-group input-group-merge">
                    <input id="myemail" type="text" required="" value="<?php echo $myemail; ?>" name="myemail" class="form-control form-control-prepended" placeholder="push@example.com">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="far fa-envelope"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="text-label" for="myusername">Username:</label>
                <div class="input-group input-group-merge">
                    <input id="myusername" type="text" required="" value="<?php echo $myusername; ?>" name="myusername" class="form-control form-control-prepended" placeholder="mark">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="far fa-envelope"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="text-label" for="phno">Phone:</label>
                <div class="input-group input-group-merge">
                    <input id="phno" type="text" required="" value="<?php echo $phno; ?>" name="phno" class="form-control form-control-prepended" placeholder="7001234567">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="far fa-envelope"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="text-label" for="mydomain">Primary Domain:</label>
                <div class="input-group input-group-merge">
                    <input id="mydomain" type="text" required="" value="<?php echo $mydomain; ?>" name="mydomain" class="form-control form-control-prepended" placeholder="example.com">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="far fa-envelope"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="text-label" for="mypassword1">Password:</label>
                <div class="input-group input-group-merge">
                    <input id="mypassword1" type="password" required="" value="" name="mypassword1" class="form-control form-control-prepended" placeholder="Enter your password">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-key"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="text-label" for="mypassword2">Confirm Password:</label>
                <div class="input-group input-group-merge">
                    <input id="mypassword2" type="password" required=""  value="" name="mypassword2" class="form-control form-control-prepended" placeholder="Confirm your password">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-key"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <button class="btn btn-primary mb-5" name="signupp" type="submit">Sign Up</button><br>
                <a href="#">Forgot password?</a> <br>
                Don't have an account? <a class="text-body text-underline" href="login.php">Login!</a>
            </div>
        </form>
    </div>


    <!-- jQuery -->
    <script src="assets/vendor/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/vendor/popper.min.js"></script>
    <script src="assets/vendor/bootstrap.min.js"></script>

    <!-- Simplebar -->
    <script src="assets/vendor/simplebar.min.js"></script>

    <!-- DOM Factory -->
    <script src="assets/vendor/dom-factory.js"></script>

    <!-- MDK -->
    <script src="assets/vendor/material-design-kit.js"></script>

    <!-- App -->
    <script src="assets/js/toggle-check-all.js"></script>
    <script src="assets/js/check-selected-row.js"></script>
    <script src="assets/js/dropdown.js"></script>
    <script src="assets/js/sidebar-mini.js"></script>
    <script src="assets/js/app.js"></script>

    <!-- App Settings (safe to remove) -->
    <script src="assets/js/app-settings.js"></script>





</body>

</html>