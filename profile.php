<?php
session_start();

if(isset($_SESSION['myusername']))
{
    include 'config.php';
    $myusername = bugRemoval($_SESSION['myusername']);

    $sql="SELECT name FROM users WHERE username='$myusername'";
    $result=mysqli_query($conn,$sql);
    while( $row = mysqli_fetch_assoc( $result ) ) {
    	$name = bugRemoval($row['name']);
    }
}
else
{
     echo"<script type='text/javascript'>
     window.location.href='login.php';
     </script>";
     exit();
}




if( isset($_POST['name']) )
{
    if($_POST['name']=='' || $_POST['phno']=='')
    {
        echo "<script type='text/javascript'>
        alert('Looks like that you had left name as blank field');
        </script>";
    }
    else
    {
        mysqli_query($conn,"UPDATE users SET name='".$_POST['name']."', phone='".$_POST['phno']."',email='".$_POST['email']."' where username='".$myusername."'");
        echo "<script type='text/javascript'>
        alert('Your profile is updated');
        </script>";
    }
}


if( isset($_POST['pass']) )
{
    if($_POST['pass']=='' || $_POST['pass1']=='' || $_POST['pass2']=='')
    {
        echo "<script type='text/javascript'>
        alert('Looks like that you had left name as blank field');
        </script>";
    }
    else
    {
        if($_POST['pass1'] != $_POST['pass2'])
        {
            echo "<script type='text/javascript'>
            alert('Confirm Password Doesnt Match');
            </script>";
        }
        else
        {
            $sql="SELECT password FROM users WHERE username='$myusername'";
            $result=mysqli_query($conn,$sql);
            while( $row = mysqli_fetch_assoc( $result ) ) {
        	    $password = bugRemoval($row['password']);
            }
            
            if($password == MD5($_POST['pass']))
            {
                mysqli_query($conn,"UPDATE users SET password='".MD5($_POST['pass1'])."' where username='".$myusername."'");
                echo "<script type='text/javascript'>
                alert('Your Password is updated');
                </script>"; 
            }
            else
            {
                echo "<script type='text/javascript'>
                alert('Old Password Is Incorrect');
                </script>"; 
            }
        }
    }
}
     
     
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Profile</title>
	
<?php include 'header.php'; ?>


<div class="container-fluid page__heading-container">
	<div class="page__heading">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a>
				</li>
				<li class="breadcrumb-item">Main Menu</li>
				<li class="breadcrumb-item active" aria-current="page">Profile</li>
			</ol>
		</nav>
		<h1 class="m-0">Profile</h1>
	</div>
</div>

<?php
$sql="SELECT name,phone,email FROM users WHERE username='$myusername'";
    $result=mysqli_query($conn,$sql);
    while( $row = mysqli_fetch_assoc( $result ) ) {
    	$name = bugRemoval($row['name']);
    	$phone = bugRemoval($row['phone']);
    	$email = bugRemoval($row['email']);
    	
    }
?>
<div class="container-fluid page__container">
	<div class="card card-form">
		<div class="row no-gutters">
			<div class="col-lg-12 card-form__body card-body">
				<form action="" method="POST">
				    <hr>
					<p><strong class="headings-color">Change Profile Info</strong></p>
					<hr>
					<div class="form-group">
						<label for="name">Name:</label>
						<input type="text" class="form-control" id="name" value="<?php echo $name; ?>" name="name" placeholder="Mark Zuck" required>
					</div>
					<div class="form-group">
						<label for="phno">Phone Number:</label>
						<input type="text" class="form-control" id="phno" value="<?php echo $phone; ?>" name="phno" placeholder="9876543210" required>
					</div>
					<div class="form-group">
						<label for="phno">Email:</label>
						<input type="text" class="form-control" id="email" value="<?php echo $email; ?>" name="email" placeholder="Email" required>
					</div>
	
					
					<button type="submit" name="submit" value="Submit" class="btn btn-primary btn-lg">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>





<div class="container-fluid page__container">
	<div class="card card-form">
		<div class="row no-gutters">
			<div class="col-lg-12 card-form__body card-body">
				<form action="" method="POST">
				    <hr>
					<p><strong class="headings-color">Change Password</strong></p>
					<hr>
					<div class="form-group">
						<label for="pass">Current Password:</label>
						<input type="password" class="form-control" id="pass" name="pass" placeholder="Current Password" required>
					</div>
					<div class="form-group">
						<label for="pass1">New Password:</label>
						<input type="password" class="form-control" id="pass1" name="pass1" placeholder="New Password" required>
					</div>
					<div class="form-group">
						<label for="pass2">Confirm New Password:</label>
						<input type="password" class="form-control" id="pass2" name="pass2" placeholder="Confirm New Password" required>
					</div>
	
					
					<button type="submit" name="submit" value="Submit" class="btn btn-primary btn-lg">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>


<?php include 'footer.php'; ?>