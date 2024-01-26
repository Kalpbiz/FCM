<?php
$a=0;
if(isset($_COOKIE['visited']))
{
    $a=1;
}
$subscribe = $_GET['subscribe'];

if($subscribe=="deny") {
   setcookie("visited", 'yes', time() + 31556926, "/");
   $a=1;
   
                }
if($subscribe=="accept") {
   setcookie("visited", 'yes', time()+31556926, "/"); 
   $a=1;
                  }
?>
<script>
    function allow()
    {
        window.open("http://www.google.com");
        window.location.href = '?subscribe=accept';
    }
    function block()
    {
        
        window.location.href = '?subscribe=deny';
    }
       
</script>
<html>
<head>
  <link rel="stylesheet" href="alert.css">  
</head>
<body>
<div <?php if($a==1){echo'style="visibility: hidden;"';} ?>>
    
<div id="push-popover-container" class="push-popover-container push-reset slide-down">
		<div id="push-popover-dialog" class="push-popover-dialog">
			<div id="normal-popover">
				<div class="popover-body">
					<div class="popover-body-icon">
						<img alt="notification icon" class="default-icon" src="data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%2239.5%22%20height%3D%2240.5%22%20viewBox%3D%220%200%2079%2081%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Ctitle%3Epush-Bell%3C%2Ftitle%3E%3Cg%20fill%3D%22%23BBB%22%20fill-rule%3D%22evenodd%22%3E%3Cpath%20d%3D%22M39.96%2067.12H4.12s-3.2-.32-3.2-3.36%202.72-3.2%202.72-3.2%2010.72-5.12%2010.72-8.8c0-3.68-1.76-6.24-1.76-21.28%200-15.04%209.6-26.56%2021.12-26.56%200%200%201.6-3.84%206.24-3.84%204.48%200%206.08%203.84%206.08%203.84%2011.52%200%2021.12%2011.52%2021.12%2026.56s-1.6%2017.6-1.6%2021.28c0%203.68%2010.72%208.8%2010.72%208.8s2.72.16%202.72%203.2c0%202.88-3.36%203.36-3.36%203.36H39.96zM27%2070.8h24s-1.655%2010.08-11.917%2010.08S27%2070.8%2027%2070.8z%22%2F%3E%3C%2Fg%3E%3C%2Fsvg%3E">
					</div>
					<div class="popover-body-message">We'd like to send you notifications for the latest news and updates.</div>
					<div class="clearfix"></div>
				</div>
				<div class="popover-footer">
					<button onclick="allow();" class="align-right primary popover-button" value="accept" id="accept" name="accept">Allow</button>
					<button onclick="block()" class="align-right secondary popover-button" value="block" id="block" name="block">No Thanks</button>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</body>
	</html>