<?php
include $_SERVER["DOCUMENT_ROOT"] . "/scripts/universal/conn.php";
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
		if(!isSet($_SESSION["uid"])){
			$status = 2;
			goto end;	
		}

		$uid = $conn->real_escape_string($_SESSION["uid"]);
		
		$query = "SELECT id FROM user WHERE id = '$uid'";
		if(mysqli_num_rows(mysqli_query($conn, $query)) != 1){
			$status = 3;
			goto  end;
		}
		
		if(!isSet($_POST["oldPassword"])){
			$status  = 4;
			goto end;
		}
		if(trim($_POST["oldPassword"]) == ""){
			$status = 5;
			goto end;
		}

		$query = "SELECT password FROM user  WHERE id = '$uid'";
		$res  = mysqli_query($conn, $query);
		$password = mysqli_fetch_array($res)["password"];
		
		if($password  !=  md5($_POST["oldPassword"])){
			$status =  6;
			goto end;
		}

		//all ok

		if(isSet($_POST["uname"]) && $_POST["uname"] != ""){
			$uname = $conn->real_escape_string($_POST["uname"]);

			$query = "UPDATE user SET username  = '$uname' WHERE id = '$uid'";
			try{
				mysqli_query($conn, $query);
				
			}catch(Exception $e){	
				$status = 7;
				goto end;	
			}
		}

		if(isSet($_POST["password"]) && isSet($_POST["passwordVerify"])){
			if($conn->real_escape_string($_POST["password"]) != $conn->real_escape_string($_POST["passwordVerify"])){
				$status = 8;
				goto end;
			}
			$NewPWD = md5($conn->real_escape_string($_POST["password"]));
			$query = "UPDATE  user SET password = '$NewPWD' WHERE id = '$uid'";
			try{
				mysqli_query($conn, $query);
				
			}catch(Exception $e){	
				$status =  9;
				goto end;	
			}
	
		}
	
	}	



	end:
	if($status != 0){
		if($debug == true){
			echo $status;
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
			case 6: echo "Failed saving changes,  Password incorrect"; break;
			case 7: echo "Failed saving changes, Username  already exists!"; break;
			case 8: echo "Failed saving changes, Passwords do  not match!";break;
			default: echo  "Something went wrong,  try again later"; break;
			}	
		}
		?> 
	</h1>

</div>
</div>
</body>
</html>
