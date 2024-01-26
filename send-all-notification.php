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






function notification($domain, $api, $message , $title , $icon , $link , $badge , $image)
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

    $sql = "SELECT token FROM tokens WHERE domain = '$domain'";
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
                        "image" => $image
                )
            );
            
             $url = 'https://fcm.googleapis.com/fcm/send';
                            
            $headers = array (
                    'Authorization: key=' . "$api",
                    'Content-Type: application/json'
            );
            
            $fields = json_encode ( $fields );
            
            $ch[$i] = curl_init($url);
            curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, true);

            curl_setopt ( $ch[$i], CURLOPT_URL, $url );
            curl_setopt ( $ch[$i], CURLOPT_POST, true );
            curl_setopt($ch[$i], CURLOPT_ENCODING,  '');
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
            curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
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
    $noti_result =  "Domain: ". $domain ." Success: ". array_sum($success) ." Failure: ". array_sum($failure)." Total Time Taken: " . round((microtime(true) - $start),2). "s<br>";
    return($noti_result);
}



if(isset($_POST['submit']))
{
  
        $title = bugRemoval($_POST['title']);
        $message = bugRemoval($_POST['message']);
        $url = bugRemoval($_POST['url']);
        $icon = bugRemoval($_POST['icon']);
        $badge = bugRemoval($_POST['badge']);
        $image = bugRemoval($_POST['image']);
        
        
        $sql1 = "SELECT domain FROM tokens WHERE domain != '' GROUP BY domain";
        $result1=mysqli_query($conn,$sql1);
        while( $row1 = mysqli_fetch_assoc( $result1 ) ) {
            $domain = $row1['domain'];
            $sql2 = "SELECT username FROM custom WHERE domain ='$domain'";
            $result2=mysqli_query($conn,$sql2);
            while( $row2 = mysqli_fetch_assoc( $result2 ) ) {
                $tmpusr = $row2['username'];
                $sql3 = "SELECT push_api FROM users WHERE username ='$tmpusr'";
                $result3=mysqli_query($conn,$sql3);
                while( $row3 = mysqli_fetch_assoc( $result3 ) ) {
                    $api_id = $row3['push_api'];
                    $sql4 = "SELECT auth_key FROM push_api WHERE id ='$api_id'";
                    $result4=mysqli_query($conn,$sql4);
                    while( $row4 = mysqli_fetch_assoc( $result4 ) ) {
                        $api = $row4['auth_key'];
                        $noti_result[] = notification($domain, $api, $message , $title , $icon , $url , $badge , $image);
                    }
                }
            }
        }
       
        
        
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
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Send Notification</title>
	
<?php include 'header.php'; ?>


<div class="container-fluid page__heading-container">
	<div class="page__heading">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a>
				</li>
				<li class="breadcrumb-item">Tools</li>
				<li class="breadcrumb-item active" aria-current="page">Send Notification</li>
			</ol>
		</nav>
		<h1 class="m-0">Send Notification</h1>
	</div>
</div>


<div class="container-fluid page__container">
	<div class="card card-form">
		<div class="row no-gutters">
			<div class="col-lg-12 card-form__body card-body">
			    
			    <?php
			    if(isset($noti_result))
			    {
			        foreach($noti_result as $not){
			            echo '<div class="alert alert-success"><strong>Success! </strong>'.$not.'</div>';
			        }
			    }
			    ?>
				<form action="" method="POST">
				    <hr>
					<p><strong class="headings-color">SEND NOTIFICATION</strong></p>
					<hr>
					<div class="form-group">
						<label for="title">Title:</label>
						<input type="text" class="form-control" id="title" name="title" placeholder="Enter Title .." required>
					</div>
					
					<div class="form-group">
						<label for="message">Message:</label>
						<textarea class="form-control" id="message" name="message" placeholder="Enter Message .." required></textarea>
					</div>
					
					<div class="form-group">
						<label for="url">URL:</label>
						<input type="text" class="form-control" id="url" name="url" placeholder="Enter URL .." required>
					</div>
					
					<!--Image Links Start -->
					<hr>
					<p><strong class="headings-color">Notification Images</strong></p>
					<hr>
					<div class="row">
            			<div class="col-lg-4">
        					<div class="form-group">
        						<label for="icon">Icon:</label>
        						<input type="text" class="form-control" id="icon" name="icon" placeholder="Enter Icon Link .." required>
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="form-group">
        						<label for="badge">Badge:</label>
        						<input type="text" class="form-control" id="badge" name="badge" placeholder="Enter Badge Link .." required>
        					</div>
        			    </div>
        			    <div class="col-lg-4">
        					<div class="form-group">
        						<label for="image">Image:</label>
        						<input type="text" class="form-control" id="image" name="image" placeholder="Enter Image Link .." required>
        					</div>
        				</div>
        			</div>
					<!--Image Links End-->
				
					
					<button type="submit" name="submit" value="Submit" class="btn btn-primary btn-lg">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>



<?php include 'footer.php'; ?>