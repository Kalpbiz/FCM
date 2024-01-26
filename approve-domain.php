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
if(isset($_GET['approve_id']))
{
$approve_id=bugRemoval($_GET['approve_id']);
mysqli_query($conn,"UPDATE custom SET status='approved' WHERE id='".$approve_id."'");
?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="assets/vendor/toastr.min.js"></script>
<link type="text/css" href="assets/vendor/toastr.min.css" rel="stylesheet">
<script>
      $(function () { //ready
          toastr.info('Approved Successfully.');
      });
</script>
<?php
}


if(isset($_GET['disapprove_id']))
{
$disapprove_id=bugRemoval($_GET['disapprove_id']);
mysqli_query($conn,"UPDATE custom SET status='disapproved' WHERE id='".$disapprove_id."'");
?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="assets/vendor/toastr.min.js"></script>
<link type="text/css" href="assets/vendor/toastr.min.css" rel="stylesheet">
<script>
      $(function () { //ready
          toastr.info('Disapproved Successfully.');
      });
</script>
<?php
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Approve Domains</title>
	
<?php include 'header.php'; ?>


<div class="container-fluid page__heading-container">
	<div class="page__heading">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a>
				</li>
				<li class="breadcrumb-item">Main Menu</li>
				<li class="breadcrumb-item active" aria-current="page">Approve Domains</li>
			</ol>
		</nav>
		<h1 class="m-0">Approve Domains</h1>
	</div>
</div>

<div class="container-fluid page__container">
    
    
    
    
    
<div class="card card-form">
    <div class="row card-body">
    <div class="col col-md-12">
    <div class="table-responsive">          
        <table id="example" class="table table-bordered table-hover">
			<thead>
				<tr>
				    <th>S.No</th>
					<th>Userame</th>
					<th>Domain</th>
					<th>Disapprove</th>
					<th>Approve</th>
				</tr>
			</thead>
			<tbody>
			    
			<?php

                $sql = mysqli_query($conn,"SELECT * from `custom` WHERE status='pending' order by id desc");
                $sno = 1;
                while($row=mysqli_fetch_array($sql))
                {
                ?>
                
				<tr>
				    <td><?php echo $sno ?></td>
				    <td><?php echo $row['username']; ?></td>
				    <td><?php echo $row['domain']; ?></td>
				    <td><a href="?disapprove_id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="material-icons">close</i></a></td>
				    <td><a href="?approve_id=<?php echo $row['id']; ?>" class="btn btn-primary" onclick="return confirm('Are you sure?')"><i class="material-icons">check</i></a></td>
				</tr>
			<?php
			    $sno++;
                }
            ?>
			</tbody>
		</table>
    </div></div>
</div>
</div>
    
    
    
    
    
    
    
    
    
</div>

<?php include 'footer.php'; ?>