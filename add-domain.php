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

if(isset($_POST['submit']))
{
    $domain = bugRemoval($_POST['domain']);
    
    $count = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `custom` WHERE domain = '$domain'"));
    
    if($count > 0)
    {
        echo '<script>alert("Domain Already Exist")</script>';
    }
    else
    {
        mysqli_query($conn,"INSERT INTO `custom`(`username`, `domain`, `status`, `date`) VALUES ('".$myusername."','".$domain."','pending',NOW())");  
        echo '<script>alert("Domain Added For Approval")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Domain</title>
	
<?php include 'header.php'; ?>


<div class="container-fluid page__heading-container">
	<div class="page__heading">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a>
				</li>
				<li class="breadcrumb-item">Tools</li>
				<li class="breadcrumb-item active" aria-current="page">Add Domain</li>
			</ol>
		</nav>
		<h1 class="m-0">Add Domain</h1>
	</div>
</div>

<div class="container-fluid page__container">
	<div class="card card-form">
		<div class="row no-gutters">
			<div class="col-lg-12 card-form__body card-body">
				<form action="" method="POST">
				     <div class="alert alert-soft-warning d-flex align-items-center card-margin" role="alert">
        <i class="material-icons mr-3">error_outline</i>
        <div class="text-body"><strong>Info:</strong> Don't use "www" or "http://" in front of domain.</div>
    </div>
				    <hr>
					<p><strong class="headings-color">Add Domain</strong></p>
					<hr>
					<div class="form-group">
						<label for="domain">Domain Link:</label>
						<input type="text" class="form-control" id="domain" name="domain" placeholder="example.com" required>
					</div>
	
					
					<button type="submit" name="submit" value="Submit" class="btn btn-primary btn-lg">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>


<?php include 'footer.php'; ?>