<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 
include "components/conn.php"; ?>


<?php 

try{
	$phash = true;
	if(!empty($_POST)){
		//ALL NON 0 STATUSES ARE ERRORS AND WILL RETURN (throw - stop execution and load page as if script never ran) 

		//ture if username is not set
		if($_POST["username"] == "" || !$_POST["username"]){
			$status = 2;
			goto end;
		}
		//ture if password is not set
		if($_POST["password"] =="" || !$_POST["password"]){
			$status = 1;
			goto end;
		}

		//sql inject attack prevention idk
		$password = $conn->real_escape_string($_POST["password"]);
		$username = $conn->real_escape_string($_POST["username"]);
			
		
		//does user exist expects exaclty 1 return
		$query = "SELECT id FROM user WHERE username = '$username'  OR email = '$username' LIMIT 1";
		
		$verifyID = mysqli_query($conn, $query);

		//if resoult is 0 lines user dont exist
		if(mysqli_num_rows($verifyID) == 0){
			$status = 4;
			goto end;
		}

		//get id of the user 
		$userID = mysqli_fetch_array($verifyID)["id"];

		//obtain MD5 hashed password of the user
		$query = "SELECT password, username FROM user WHERE id = '$userID' LIMIT 1";

		$pwd = mysqli_query($conn, $query);
		
		//if there is password stored there is something wrong
		if(mysqli_num_rows($pwd) == 0){
			$status = 5;
			goto end;
		}
		
		//if md5 of password entered is different from stored password status 6 wrong password 

		$row = mysqli_fetch_array($pwd);
		if(md5($password) !== $row["password"]){
			$status = 6;
			goto end;
		}
		$username =  $row["username"];

		//if stay is set (by checking the keep me logged in box)
		//
		//Keep me logged in works by:
		//-generating a token and giving it to client, and storing it in a DB
		//-token is than used instead of logging in
		//
		//On every request cookies (all cookies, stored by this site and that are allowed to be sent) are sent to server
		//
		//Token is used as a login key for a user. User gets the token stored in a cookie and when they load a page they send the token to server.
		//
		//Server when recieving the token checks if its valid (exists in the database of created valid tokens) if it is valid than start a session for that user
		//
		if(isSet($_POST["stay"])){
			//if it actually contains right value
			if($_POST["stay"] == "login"){

				//generate random hex string (hex 0-9 a-f) of randomly generated 64bytes of binary data. 
				$rngToken = bin2hex(random_bytes(64));
				
				//create and store a cookie with value of that token. Expires in 7 days (keeps you logged in for 7 days) domain wide "/"
				setCookie("stay", $rngToken, time() + 3600 * 24 * 7, "/");
				
				//store cookie in db as valid login token
				$query = "INSERT INTO cookies(user_id, value) VALUES ('$userID', '$rngToken')";
				mysqli_query($conn, $query);
			}
		}

		session_start();
		$_SESSION["uid"] =  $userID;
		$_SESSION["username"] = $username;
		

		//admin check

		$query =  "SELECT isAdmin FROM user WHERE id = '$userID'";
		$res =  mysqli_query($conn, $query);
		$isAdmin = mysqli_fetch_array($res)["isAdmin"];

		if($isAdmin == 1){
			$_SESSION["isAdmin"] = 1;
		}
		
		$status = 0;

		//if all went well you log in and get redirected to main page
		header('Location: /index.php');
		exit();
		$status = 0;
	}
}catch(Exception $e){
	echo "skill issue<br>";
	echo $e;
	die;
}
end:
mysqli_close($conn);
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
	<h1> Login </h1>
	
	<form action="" method="POST"> 
		<input type="text" placeholder="username or email"  name="username" required>
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
