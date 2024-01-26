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
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>All Domains</title>
	
<?php include 'header.php'; ?>


<div class="container-fluid page__heading-container">
	<div class="page__heading">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a>
				</li>
				<li class="breadcrumb-item">Main Menu</li>
				<li class="breadcrumb-item active" aria-current="page">All Domains</li>
			</ol>
		</nav>
		<h1 class="m-0">All Domains</h1>
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
					<th>Username</th>
					<th>Domain</th>
					<th>Status</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
			    
			<?php

                $sql = mysqli_query($conn,"SELECT * from `custom` order by username desc");
                $sno = 1;
                while($row=mysqli_fetch_array($sql))
                {
                ?>
                
				<tr>
				    <td><?php echo $sno ?></td>
				    <td><?php echo $row['username']; ?></td>
				    <td><?php echo $row['domain']; ?></td>
				     <td><?php echo $row['status']; ?></td>
					<td><?php echo date("d-M-Y g:i A",strtotime($row['date'])); ?></td>
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