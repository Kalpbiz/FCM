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

if(isset($_GET['delete_id']))
{
$delete_id=bugRemoval($_GET['delete_id']);
$sql="SELECT push_api FROM users WHERE push_api='$delete_id'";
     $result=mysqli_query($conn,$sql);
     $count=mysqli_num_rows($result);
    if($count!=1) 
    {
        mysqli_query($conn,"DELETE FROM push_api WHERE id='".$delete_id."'");
    }
    else
    {
      echo "<script type='text/javascript'>
        alert('Api is in Use');
        </script>";  
    }

?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="assets/vendor/toastr.min.js"></script>
<link type="text/css" href="assets/vendor/toastr.min.css" rel="stylesheet">
<script>
      $(function () { //ready
          toastr.info('Deleted Successfully.');
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
    <title>View API</title>



<?php include 'header.php'; ?>

<div class="container-fluid page__heading-container">
	<div class="page__heading">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a>
				</li>
				<li class="breadcrumb-item">Tools</li>
				<li class="breadcrumb-item active" aria-current="page">View API</li>
			</ol>
		</nav>
		<h1 class="m-0">View API</h1>
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
					<th>Sender ID</th>
					<th>Email</th>
					<th>Status</th>
					<th>Delete</th>
				
				</tr>
			</thead>
			<tbody>
			    
			<?php

                $sql = mysqli_query($conn,"SELECT * from push_api order by id desc");
                $sno = 1;
                while($row=mysqli_fetch_array($sql))
                {
                ?>
                
				<tr>
				    <td><?php echo $sno ?></td>
				    <td><?php echo $row['sender_id']; ?></td>
				    <td><?php echo $row['email']; ?></td>
					<td><?php echo ucwords($row['status']); ?></td>
					
					<td><a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="material-icons">close</i></a></td>
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
    