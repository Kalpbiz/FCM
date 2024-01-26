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






function notification($domain , $message , $title , $icon , $link , $badge , $image)
{
    set_time_limit(0);
    @ini_set('zlib.output_compression', 0);
    @ini_set('implicit_flush', 1);
    @ob_end_clean();
    ignore_user_abort(TRUE);
    
    global $conn;
    $start = microtime(true);
    $success = array();
    $failure = array();
    $tokens = array();
    $noti_result = array();
    
    $sql = "SELECT token FROM tokens where domain='".$domain."' LIMIT 20000";
    $result=mysqli_query($conn,$sql);
        
    $totalCounter  = mysqli_num_rows($result);
    $counter = 0;
    
    $i = 0;

    $ch = array();
    $master = curl_multi_init();

    while( $row = mysqli_fetch_assoc( $result ) ) {
      
       array_push($tokens, $row['token']);
       $counter++; 
       
       if(count($tokens)  == 1000 || count($tokens) == $totalCounter )
       {
            $i++;
            $fields = array (
                'registration_ids' =>  (
                            $tokens
                    ),
                'notification' => array (
                        "body" => $message,
                        "title" => $title,
                        "icon" => $icon,
                        "click_action" => $link,
                        "badge" => $badge,
                        "image" => $image
                )
            );
            
             $url = 'https://fcm.googleapis.com/fcm/send';
                            
            $headers = array (
                    'Authorization: key=' . "AAAA3DzTek8:APA91bGFsHz12CSvKV78uvv3d3QWsqQY3cQaDXiL5XhU8KOcrbeRFgZXJ21NKAuGvFdGebokcoLawY642UtavgVFAS9w0XzuR0fsCBqOtnGgfp6oN1L6DJSrVIsm6MT2Ypp6RMbFG1gQ",
                    'Content-Type: application/json'
            );
            
            $fields = json_encode ( $fields );
            
            $ch[$i] = curl_init($url);
            curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, true);

            curl_setopt ( $ch[$i], CURLOPT_URL, $url );
            curl_setopt ( $ch[$i], CURLOPT_POST, true );
            curl_setopt($ch[$i], CURLOPT_ENCODING,  '');
            curl_setopt($ch[$i], CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
            curl_setopt ( $ch[$i], CURLOPT_HTTPHEADER, $headers );
            curl_setopt ( $ch[$i], CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch[$i], CURLOPT_POSTFIELDS, $fields );
            curl_multi_add_handle($master, $ch[$i]);
            
            unset($tokens);
           $tokens = array();
           $totalCounter = $totalCounter - $counter;
         
        }
    }
    
    
	$running = null;
	do 
	{
		curl_multi_exec($master,$running);
	} while ($running > 0);
    	
    $node_count = $i;	
    for($i = 1; $i <= $node_count; $i++)
    {
        $results = curl_multi_getcontent  ( $ch[$i]  );
        $results = json_decode($results);
        array_push($success,$results->success);
        array_push($failure,$results->failure);
        flush();
    }
    
    //echo "<br><br>GRAND TOTAL:<br>";
    $noti_result =  "Success: ". array_sum($success) ." Failure: ". array_sum($failure)." Total Time Taken: " . round((microtime(true) - $start),2). "s<br>";
    return($noti_result);
}



if(isset($_POST['submit']))
{
    $domain = bugRemoval($_POST['domain']);
    $sql="SELECT domain FROM custom WHERE username='$myusername' && domain ='$domain' && status='approved'";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) == 0)
    {
        echo '<script>alert("Nice Try Dude!!!")</script>';
    }
    else
    {
    
        $count = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `notifications` WHERE username='".$myusername."' && domain='".$domain."' && time >= DATE_SUB(CURDATE(), INTERVAL 0 DAY)"));
                    
        if($count >= 3)
        {
            echo '<script>alert("Your Limit Exceeded")</script>';
        }
        else
        {
        $title = bugRemoval($_POST['title']);
        $message = bugRemoval($_POST['message']);
        $url = bugRemoval($_POST['url']);
        $icon = bugRemoval($_POST['icon']);
        $badge = bugRemoval($_POST['badge']);
        $image = bugRemoval($_POST['image']);
        
        mysqli_query($conn,"INSERT INTO `notifications`(`username`, `domain`, `title`, `message`, `url`, `icon`, `badge`, `image`, `time`) VALUES ('".$myusername."','".$domain."','".$title."','".$message."','".$url."','".$icon."','".$badge."','".$image."',NOW())");   
    
        $noti_result = notification($domain , $message , $title , $icon , $url , $badge , $image);
        
       
        
        
?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="assets/vendor/toastr.min.js"></script>
<link type="text/css" href="assets/vendor/toastr.min.css" rel="stylesheet">
<script>
      $(function () { //ready
          toastr.info('Notification Sent Successfully.');
      });
</script>
<?php
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>View History</title>
	
<?php include 'header.php'; ?>


<div class="container-fluid page__heading-container">
	<div class="page__heading">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a>
				</li>
				<li class="breadcrumb-item">Tools</li>
				<li class="breadcrumb-item active" aria-current="page">View History</li>
			</ol>
		</nav>
		<h1 class="m-0">View History</h1>
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
					<th>Title</th>
					<th>Message</th>
					<th>URL</th>
					<th>Icon</th>
					<th>Badge</th>
					<th>Image</th>
					<th>Time</th>
				
				</tr>
			</thead>
			<tbody>
			    
			<?php

                $sql = mysqli_query($conn,"SELECT * from notifications WHERE username='".$myusername."' order by id desc");
                $sno = 1;
                while($row=mysqli_fetch_array($sql))
                {
                ?>
                
				<tr>
				    <td><?php echo $sno ?></td>
				    <td><?php echo $row['domain']; ?></td>
				    <td><?php echo $row['title']; ?></td>
				    <td><?php echo $row['message']; ?></td>
				    <td><?php echo $row['url']; ?></td>
				    <td><img src="<?php echo $row['icon']; ?>" height="30px"></td>
				    <td><img src="<?php echo $row['badge']; ?>" height="30px"></td>
				    <td><img src="<?php echo $row['image']; ?>" height="30px"></td>
				    <td><?php echo $row['time']; ?></td>
				    
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