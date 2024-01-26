<?php
session_start();

if(isset($_SESSION['myadminusername']))
{
    include '../config.php';
    $myusername = bugRemoval($_SESSION['myadminusername']);

    $sql="SELECT name FROM admin WHERE username='$myusername'";
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
if( isset($_POST['submit']) )
{
    if($_POST['id']=='' || $_POST['key']==''|| $_POST['email']=='')
    {
        echo "<script type='text/javascript'>
        alert('Looks like that you had left name as blank field');
        </script>";
    }
    else
    {
        mysqli_query($conn,"INSERT INTO `push_api`(`auth_key`, `sender_id`, `email`) VALUES ('".$_POST['key']."','".$_POST['id']."','".$_POST['email']."')");
        echo "<script type='text/javascript'>
        alert('Data Inserted');
        </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Api</title>
	
<?php include 'header.php'; ?>


<div class="container-fluid page__heading-container">
	<div class="page__heading">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a>
				</li>
				<li class="breadcrumb-item">Main Menu</li>
				<li class="breadcrumb-item active" aria-current="page">Add Api</li>
			</ol>
		</nav>
		<h1 class="m-0">Add Api</h1>
	</div>
</div>

<div class="container-fluid page__container">
    
    
    
     <div class="card card-form">
                            <div class="row no-gutters">
                                <div class="col-lg-4 card-body">
                                    <p><strong class="headings-color">Firebase Api</strong></p>
                                    <p class="text-muted">Kindly genrate Api from Firebase Console.</p>
                                </div>
                                <div class="col-lg-8 card-form__body card-body">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label for="id">Api Id:</label>
                                            <input type="text" class="form-control" id="id" name="id" placeholder="Enter Api Id">
                                        </div>
                                        <div class="form-group">
                                            <label for="key">Authorization Key:</label>
                                            <input type="text" class="form-control" id="key" name="key" placeholder="Enter Key">
                                        </div>
                                        <div class="form-group">
                                            <label for="Email">Reference Email:</label>
                                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">
                                        </div>
                                        <button type="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
    
    
    

    
</div>

<?php include 'footer.php'; ?>