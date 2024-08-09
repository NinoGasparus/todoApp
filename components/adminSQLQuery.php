<?php

include "conn.php";
if($debug == true){			
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL); 
}



if(empty($_POST)){
	if($debug  == true){
		echo "emtpy POST";
	}else{
		Header("Location:  /err.php");
	}
}



$status = 0;

try{

	if(session_status()  !=  PHP_SESSION_ACTIVE){
		session_Start();
	}

	if(!isSet($_SESSION["uid"]) || !isSet($_SESSION["username"])){
		$status = 1;
		goto end;
	}

	$uid = $conn->real_escape_string($_SESSION["uid"]);
	$uname = $conn->real_escape_string($_SESSION["username"]);


	$query  =  "SELECT id FROM user WHERE id = '$uid' AND username= '$uname'";
	$res = mysqli_query($conn, $query);

	if(mysqli_num_rows($res) != 1){
		$status = 2;
		goto end;
	}
	
	if(!isSet($_POST["query"])){
		$status = 3;
		goto end;
	}
	
	$query = $conn->real_escape_string($_POST["query"]);
	$query = trim($query);
	
	if(strToLower($query) == "clear"){
		$_SESSION["res"] = "";
		goto end;
	}

	try{
		if (mysqli_query($conn, $query)){
        		$_SESSION["res"] .= "Query executed successfully.<br>";
   		}else{
        		$_SESSION["res"] .= "SQL error: " . $conn->error . "<br>";
		}
	}catch(Exception $e){

		$_SESSION["res"] .= $e. "</br>";
	}
}catch(Exception  $e){
	if($debug == true){
		echo "skill issue";
		echo $e;
	}
}



end:
if($debug == true){
	if($status == 0){
		Header("Location: /components/admin.php?display=2");	
	}
	if($status != 0){
		echo $status;
	}
}else{
	Header("Location: /err.php");
}
