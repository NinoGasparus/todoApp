<?php


include $_SERVER["DOCUMENT_ROOT"] . "scripts/universal/conn.php";
if($debug == true){
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

			
		//get ids of all accounts whose username AND email are matching to entered values. there should be 1 else one or both are wrong
		$query = "SELECT id FROM user WHERE username = '$username' AND email = '$email'"; 

		$res  = mysqli_query($conn, $query);

		if(mysqli_num_rows($res) !== 1){
			$status = 5;
			goto end;
		}
	
		

		//hash the passowrd though password_hash("password", PASSWORD_DEFAULT) could be used which is safer supposedly
		$password = md5($password);
		
		//obtain user's id from query 11 lines above
		$uid = mysqli_fetch_array($res)["id"];

	
		//update existing password
		$query = "UPDATE user SET password ='$password' WHERE id = '$uid'";
		
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

	 <link rel="stylesheet" href="styles/login.css">
	 <link rel="stylesheet" href="styles/root.css">
	 <link rel="stylesheet" href="styles/nav.css">
</head>

<body>
<div id="navbar">

	<div class="markDiv"><a href="/index.php" >Todo<sup>2</sup></a></div>


</div>


<div style="display:flex;height:91vh; align-items:space-around;">
<div id="loginbox">
	<h1> Reset your password</h1>
	
	<form action="" method="POST"> 
		<input type="text" placeholder="Enter your username"  name="username" required>
		<?php 
		if(isSet($status)){
			if($status == 1){ 
				echo "<span class='err'> Username not set</span>";
			}else if($status == 4){
				echo "<div class='err'> Passwords do not match</div>";
			}else if($status == 5){
				echo "<div class='err'>Wrong username and or email</div>";
			}

		}
		?>
		<input type="email" placeholder="Enter email address used at register"  name="email" required>
	
		<?php 
		if(isSet($status)){
			if($status == 2){ 
				echo "<div class='err'> Password not set</div>";
			}else if ($status == 3){ 
				echo "<div class='err'> Email not set </div>";

			}else if($status == 7){
				echo "<div class='err'> Something went wrong </div>";

			}
		} 
		?>
		
		<input type="password" placeholder="Chose new password" name="password" required>
		<input type="password" placeholder="Repeat the password" name="passwordverify" required>

		<?php 
		if(isSet($status)){
			if($status == 0){ 
				echo "<span class='err'> Password reset, you can now log in</span>";
			}

		}
		?>
	


		<button type="submit"> <p> Reset password </p></button>
	</form>

	<div id="accountActions">
		<a href="/login.php"> <div> Log in </div> </a> 
		<a href="/register.php"> <div> Register new account </div> </a>
	</div>		
</div>
</div>
</body>
</html>
