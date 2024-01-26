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
    <title>Dashboard</title>
	
<?php include 'header.php'; ?>


<div class="container-fluid page__heading-container">
	<div class="page__heading">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a>
				</li>
				<li class="breadcrumb-item">Main Menu</li>
				<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
			</ol>
		</nav>
		<h1 class="m-0">Dashboard</h1>
	</div>
</div>

<div class="container-fluid page__container">
    
    <?php
    $sql="SELECT count(*) as total FROM notifications WHERE username='$myusername'";
    $result=mysqli_query($conn,$sql);
    while( $row = mysqli_fetch_assoc( $result ) ) {
    	$total_notifactions = bugRemoval($row['total']);
    }
    
    
    
    $sql="SELECT count(*) as total FROM custom WHERE username='$myusername' && status='approved'";
    $result=mysqli_query($conn,$sql);
    while( $row = mysqli_fetch_assoc( $result ) ) {
    	$total_domains = bugRemoval($row['total']);
    }
    
    
    $sql="SELECT domain FROM custom WHERE username='$myusername'";
    $result=mysqli_query($conn,$sql);
    while( $row = mysqli_fetch_assoc( $result ) ) {
    	$domain[] = bugRemoval($row['domain']);
    }
    $domains = join("','",$domain);   
    $sql="SELECT count(*) as tokens FROM tokens WHERE domain in ('$domains')";
    $result=mysqli_query($conn,$sql);
    while( $row = mysqli_fetch_assoc( $result ) ) {
    	$total_tokens = number_format(bugRemoval($row['tokens']));
    }
    
    ?>
    <div class="row card-group-row">
        <div class="col-lg-4 col-md-6 card-group-row__col">
            <div class="card card-group-row__card card-body card-body-x-lg flex-row align-items-center">
                <div class="flex">
                    <div class="card-header__title text-muted mb-2">Total Notifications</div>
                    <div class="text-amount"><?php echo $total_notifactions; ?></div>
                </div>
                <div><i class="material-icons icon-muted icon-40pt ml-3">gps_fixed</i></div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 card-group-row__col">
            <div class="card card-group-row__card card-body card-body-x-lg flex-row align-items-center">
                <div class="flex">
                    <div class="card-header__title text-muted mb-2">Total Active Domains</div>
                    <div class="text-amount"><?php echo $total_domains; ?></div>
                </div>
                <div><i class="material-icons icon-muted icon-40pt ml-3">monetization_on</i></div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 card-group-row__col">
            <div class="card card-group-row__card card-body card-body-x-lg flex-row align-items-center">
                <div class="flex">
                    <div class="card-header__title text-muted mb-2">Total Tokens</div>
                    <div class="text-amount"><?php echo $total_tokens; ?></div>
                </div>
                <div><i class="material-icons icon-muted icon-40pt ml-3">perm_identity</i></div>
            </div>
        </div>
    </div>
    
    
    
    <?php
    $sql="SELECT push_api FROM users WHERE username='$myusername'";
    $result=mysqli_query($conn,$sql);
    while( $row = mysqli_fetch_assoc( $result ) ) 
    {
    	$push_api=bugRemoval($row['push_api']);
    }
    
    $sql="SELECT add_link,sender_id FROM push_api WHERE id='$push_api'";
    $result=mysqli_query($conn,$sql);
    while( $row = mysqli_fetch_assoc( $result ) )
    {
    	$sender_id = bugRemoval($row['sender_id']);
    	$add_link = bugRemoval($row['add_link']);
    }
    ?>
        
    <div class="alert alert-soft-warning d-flex align-items-center card-margin" role="alert">
        <i class="material-icons mr-3">error_outline</i>
        <div class="text-body"><strong>Notice:</strong> Please add the code given below to all your domains index file to make token working.</div>
    </div>

    
    <div class="card">
        <div class="card-header bg-white d-flex align-items-center">
            <h4 class="card-header__title mb-0">JS Code</h4>
        </div>
        <div class="card-body">
            <pre>
                &lt;script src="https://code.jquery.com/jquery-3.4.1.min.js">&lt;/script&gt;
                &lt;script src="https://www.gstatic.com/firebasejs/4.6.2/firebase.js">&lt;/script&gt;
                &lt;script&gt;
                $(document).ready(function() {
                    var domain = window.location.hostname;
                    var config = {
                        messagingSenderId: "<?php echo $sender_id; ?>",
                    };
                    firebase.initializeApp(config);
                    navigator.serviceWorker.register('firebase-messaging-sw.js')
                    
                     const messaging = firebase.messaging();
                    
                     messaging
                       .requestPermission()
                       .then(function () {
                         return messaging.getToken()
                       })
                       .then(function(token) {
                         
                         $.ajax({
                            url: '<?php echo $add_link; ?>',
                            type: 'get',
                            data: { token: token , domain: domain},
                            success: function(data) {
                               
                                     }
                            });
                       })
                       .catch(function (err) {
                        
                     });
                });
                &lt;/script&gt;
            </pre>
        </div>
    </div>
    
    
    <div class="alert alert-soft-warning d-flex align-items-center card-margin" role="alert">
        <i class="material-icons mr-3">error_outline</i>
        <div class="text-body"><strong>Notice:</strong> make a file named firebase-messaging-sw.js in root directory and copy code given below .</div>
    </div>
    
    
    <div class="card">
        <div class="card-header bg-white d-flex align-items-center">
            <h4 class="card-header__title mb-0">JS Code</h4>
        </div>
        <div class="card-body">
            <pre>
                
                importScripts('https://www.gstatic.com/firebasejs/3.9.0/firebase-app.js');
                importScripts('https://www.gstatic.com/firebasejs/3.9.0/firebase-messaging.js');
                
                // Initialize the Firebase app in the service worker by passing in the
                // messagingSenderId.
                firebase.initializeApp({
                   'messagingSenderId': '<?php echo $sender_id; ?>'
                });
                
                // Retrieve an instance of Firebase Messaging so that it can handle background
                // messages.
                const messaging = firebase.messaging();
                
                messaging.setBackgroundMessageHandler(function(payload) {
                  console.log('[firebase-messaging-sw.js] Received background message ', payload);
                  // Customize notification here
                  const notificationTitle = 'Background Message Title';
                  const notificationOptions = {
                    body: 'Background Message body.',
                    icon: '/itwonders-web-logo.png'
                  };
                
                  return self.registration.showNotification(notificationTitle,
                      notificationOptions);
                });
                
            </pre>
        </div>
    </div>
    
    
    
    
    
    
    
    
    
    
    
    
</div>

<?php include 'footer.php'; ?>