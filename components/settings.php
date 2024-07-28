<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 
include "conn.php"; ?>

<?php

?>


<!DOCTYPE html>
<html> 
<head> 
	<title> Advanced todo </title>

	 <link rel="stylesheet" href="/styles/login.css">
	 <link rel="stylesheet" href="/styles/root.css">
	 <link rel="stylesheet" href="/styles/nav.css">
</head>

<body>
<div id="navbar">

	<div class="markDiv"><a href="/index.php" >Todo<sup>2</sup></a></div>


</div>


<div style="display:flex;height:91vh; align-items:space-around;">
<div id="loginbox">
	<h1> Settings </h1>
	
	<form action="" method="POST"> 
		<input type="text" placeholder="Chose a new username"  name="username" required>
		<?php 
		if(isSet($status)){
			if($status == 1){ 
				echo "<span class='err'> Username not set</span>";
			}else if($status == 4){
				echo "<div class='err'> User does not exist</div>";
			}else if($status == 5){
				echo "<div class='err'> Password does not exist</div>";
			}

		}
		?>
		
		<input type="password" placeholder="password" name="password" required>
		<?php 
		if(isSet($status)){
			if($status == 2){ 
				echo "<div class='err'> Password not set</div>";
			}else if ($status == 3){ 
				echo "<div class='err'> Bad input format </div>";

			}else if($status == 6){
				echo "<div class='err'> Password incorrect </div>";

			}else if($status == 0){
			}
		} 
		?>
		<div class="err" id="stay" >
			Stay logged in
			<input type="checkbox" name="stay" value="login" >
		</div>
		<button type="submit"> <p> Log in </p></button>
	</form>

	<div id="accountActions">
		<a href="/passwordreset.php"> <div> Forgot password? </div> </a> 
		<a href="/register.php"> <div> Register new account </div> </a>
	</div>		
</div>
</div>
</body>
</html>
