<?php

include "components/conn.php"; 
if(debug == true){
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 
}
?>


<?php 

try{
	$phash = true;
	if(!empty($_POST)){
		
		//ALL NON 0 STATUSES ARE ERRORS AND WILL RETURN (throw - stop execution and load page as if script never ran) 


		//if username is not set or empty throw
		if($_POST["username"] == "" ||  !$_POST["username"]){
			$status = 2;
			goto end;
		}

		//if passowrd or password verify is not set or empty
		if($_POST["password"] =="" || !$_POST["password"] || $_POST["passwordverify"] == "" || !$_POST["passwordverify"]){
			$status = 1;
			goto end;
		}

		//if email is not set or empty
		if($_POST["email"] =="" || !$_POST["email"]){	
			$status = 3;
			goto end;
		}
		
		//sql prevention checks
		$username = $conn->real_escape_string($_POST["username"]);
		$password = $conn->real_escape_string($_POST["password"]);
		$passWRD  = $conn->real_escape_string($_POST["passwordverify"]);
		$email = $conn->real_escape_string($_POST["email"]);	

		//if entered passwords dont match
		if($password !== $passWRD){
			$status = 4;
			goto end;
		}

			
		//get ids of all accounts whose username is same to one entered, should be 0 if username is not taken already
		$query = "SELECT id FROM user WHERE username = '$username'";

		//if number of returns is different from 0 there is account and username is already taken
		if(mysqli_num_rows(mysqli_query($conn, $query)) != 0){
			$status = 5;
			goto end;
		}
	
		//same for email
		$query = "SELECT id FROM user WHERE email = '$email'";
		if(mysqli_num_rows(mysqli_query($conn, $query)) != 0){
			$status = 6;
			goto end;
		}
		
		

		//hash the passowrd though password_hash("password", PASSWORD_DEFAULT) could be used which is safer supposedly
		$password = md5($password);
		
		//store the password
		$query = "INSERT INTO user(username, email, password) VALUES('$username', '$email', '$password')";
		
		//if this fails well shit try again
		if(!mysqli_query($conn, $query)){
			$status = 7;
			goto end;
		}
		
		//all ran fine status 0 close connection and finish
		$status = 0;
		mysqli_close($conn);
		goto end;


	}
}
catch(Exception $e){
	echo "skill issue<br>";
	echo $e;
	die;
}
end:
?>
<!DOCTYPE html>
<html> 
<head> 
	<title> Advanced todo </title>


	<link rel="stylesheet" href="styles/root.css">
	<link rel="stylesheet" href="styles/nav.css">
	<link rel="stylesheet" href="styles/register.css">
</head>

<body>
<div id="navbar">
	<div class="markDiv"><a href="/index.php" >Todo<sup>2</sup></a></div>

</div>


<div style="display:flex;height:91vh; align-items:space-around;">
<div id="loginbox">
	<h1> Register </h1>
	<h3 style="padding-left:var(--gp)"> Create a free account </h3>
	<form action="" method="POST"> 
		<input type="text" placeholder="Chose an username"  name="username" required>
		<?php 
		if(isSet($status)){
			if($status == 1){ 
				echo "<span class='err'> Username not set</span>";
			}else if($status == 5){
				echo "<span class='err'> Username taken</span>";
			}

		} 
		?>
		<input type="email" placeholder="Enter your email address"  name="email" required>
		<?php 
		if(isSet($status)){
			if($status == 3){ 
				echo "<span class='err'> Email not set</span>";
			}else if($status == 6){
				echo "<span class='err'> Email already registered</span>";

			}
		} 
		?>
	
		<input type="password" placeholder="Enter your password" name="password" required>

		<?php 
		if(isSet($status)){
			if($status == 2){ 
				echo "<div class='err'> Password not set</div>"; 
			}else if($status == 4){
				echo "<div class='err'> Passwords do not match </div>";
			}
		} 
		?> 

		<input type="password" placeholder="Repeat the password"  name="passwordverify" required>

		<?php 
		if(isSet($status)){
			if($status == 7 ){ 
				echo "<div class='err'> Something went wrong</div>"; 
			}else if($status == 0){
				echo "<div class='err'> Account created sucessfully! Please Log in </div>";
			}
		} 
		?> 

		<button type="submit"><p> Create account </p></button>
	</form>

	<div id="accountActions">
		<a href="/passwordreset.php"> <div> Forgot password? </div> </a> 
		<a href="/login.php"> <div> Log in </div> </a>
	</div>		
</div>
</div>
</body>
</html>
