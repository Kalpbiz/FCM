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
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>View Tokens</title>



<?php include 'header.php'; ?>

<div class="container-fluid page__heading-container">
	<div class="page__heading">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a>
				</li>
				<li class="breadcrumb-item">Tools</li>
				<li class="breadcrumb-item active" aria-current="page">View Tokens</li>
			</ol>
		</nav>
		<h1 class="m-0">View Tokens</h1>
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
					<th>Domain Name</th>
					<th>Total Tokens</th>
					<th>Approved On</th>
					<th>Check Domain</th>
				
				</tr>
			</thead>
			<tbody>
			    
			<?php

                $sql = mysqli_query($conn,"SELECT * from custom WHERE username='".$myusername."'  && status = 'approved' order by id desc");
                $sno = 1;
                while($row=mysqli_fetch_array($sql))
                {
                    $count = mysqli_num_rows(mysqli_query($conn,"SELECT domain from tokens WHERE domain='".$row['domain']."'"));
                ?>
                
				<tr>
				    <td><?php echo $sno ?></td>
				    <td><?php echo $row['domain']; ?></td>
					<td><?php echo $count; ?></td>
				    <td><?php echo date("d M Y",strtotime($row['date'])); ?></td>
					<td><a href="https://<?php echo $row['domain']; ?>" target="_blank" class="btn btn-primary">View</a></td>
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
    