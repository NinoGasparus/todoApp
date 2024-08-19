<?php
include $_SERVER["DOCUMENT_ROOT"] . "/scripts/universal/conn.php";
include $_SERVER["DOCUMENT_ROOT"] . "/scripts/admin/sesCleaner.php";
if($debug == true){
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 
}
?>
<?php
	$status = 0;
	if(session_status() != PHP_SESSION_ACTIVE){
		session_start();
	}
	if(!isSet($_SESSION["uid"])){
		$status = 1;
		goto end;
	}
	

	if(!empty($_POST)){
		if(session_status() !== PHP_SESSION_ACTIVE){
			session_start();
		}
		if(!isSet($_SESSION["uid"]) || !isSet($_SESSION["username"])){
			$status = 1;
			goto end;
		}
		if(!isSet($_POST["oldPassword"])){
			$status = 2;
			goto end;
		}

		$uname	= $conn->real_escape_string($_SESSION["username"]);
		$uid 	= $conn->real_escape_string($_SESSION["uid"]);
		$testPassword = trim($conn->real_escape_string($_POST["oldPassword"]));
		if($testPassword == "" || trim($_POST["oldPassword"]) == ""){
			goto end;
		}
		$testQuery =  "SELECT password FROM user WHERE id = '$uid'";
		$res = mysqli_query($conn, $testQuery);
		
		if(mysqli_num_rows($res) != 1){
			$status = 3;
			goto end;
		}
		$realPassword = mysqli_fetch_array($res)["password"];
		
		if($realPassword != md5($testPassword)){
			$status = 4;
			goto end;
		}
		//Username changing
		if(isSet($_POST["uname"])){
			$uname = $conn->real_escape_string(trim($_POST["uname"]));
			if(trim($uname) != ""){
			$testQuery ="SELECT id FROM user WHERE username = '$uname'";
			$res = mysqli_query($conn, $testQuery);
			if(mysqli_num_rows($res) != 0){
				$status = 5;
				goto end;
			}
			$newName = $conn->real_escape_string($_POST["uname"]);
			$query = "UPDATE user SET username = '$newName' WHERE id = '$uid'";
			if(!mysqli_query($conn, $query)){
				$status = 6;
				goto end;	
			}
			}
			
		}
			
		//password updating
		if(isSet($_POST["password"]) && isSet($_POST["passwordVerify"])){
			if(trim($_POST["password"]) == "" || trim($_POST["passwordVerify"]) == ""){
				goto end;
			}
			$pwd1 = md5($conn->real_escape_string($_POST["password"]));
			$pwd2 = md5($conn->real_escape_string($_POST["passwordVerify"]));
			if($pwd1 != $pwd2){
				$status = 7;
				goto end;
			}

			$query = "UPDATE user SET password = '$pwd1' WHERE id = '$uid'";
			if(!mysqli_query($conn, $query)){
				$status = 8;
				goto end;
			}
			$query = "DELETE FROM cookies WHERE user_id = '$uid'";
			if(!mysqli_query($conn, $query)){
				$status = 8;
				goto end;
			}
			try{
				//Experimental
				clearSessions($uname);
				clearSessions($uid);
			}catch(Exception $e){
			}

		}else if(!isSet($_POST["password"]) || !isSet($_POST["passwordVerify"])){
			$status = 7;
			goto end;
		}
		
	}	



	end:
	if($status != 0){
		if($debug == true){
		#	echo $status;
		}else{
			Header("Location:  /err.php");
		}
	}

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
		<input  name="uname" placeholder ="Your new username" type="text">
		<input  name="password" placeholder="Your new password" type="password">
		<input  name="passwordVerify" placeholder = "Re enter your new password"  type="password">
		<input  name="oldPassword" placeholder ="Enter current password to save  changes" required type="password">
		<button type="submit"> <p> Save  changes </p></button>
	</form>
	<h1> <?php
       		if($status != 0){
			switch($status){
			case 0: echo "Saved  sucessfully, please relog";break;
			case 4: echo "Failed saving changes,  Password incorrect"; break;
			case 5: echo "Failed saving changes, Username  already exists!"; break;
			case 7: echo "Failed saving changes, Passwords do  not match!";break;
			default: echo  "Something went wrong,  try again later"; break;
			}	
		}
		?> 
	</h1>

</div>
</div>
</body>
</html>
