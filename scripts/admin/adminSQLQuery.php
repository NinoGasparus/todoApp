<?php

include $_SERVER["DOCUMENT_ROOT"] . "/scripts/universal/conn.php";
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
	
	if( trim($_POST["query"]) == ""){
		Header("Location: /components/admin.php?display=2");
	}

	$query = $_POST["query"];
	//remove any leading or ending spaces
	$query = trim($query);
	//if last char is ; remove it (allows queries to end with ; and  stil be valid)
	$query = rtrim($query, ';');
	$type = strtoupper(strtok($query, " "));


	if(!isSet($_SESSION["res"]) || empty($_SESSION["res"])){
		$_SESSION["res"] == "";
	}


	if(strToLower($query) == "clear"){
		$_SESSION["res"] = "";
		goto end;
	}
	
	//query execution
	try{
		$res;
		$_SESSION["res"] .= $query . "<br>";
		if ($res =mysqli_query($conn, $query)){
			include "responses.php";
			switch($type){
				case 'SELECT':	$_SESSION["res"] .= resSelect($res); break;
				case 'DELETE':	$_SESSION["res"] .= resDelete($res,mysqli_affected_rows($conn)); break;
				case 'UPDATE':	$_SESSION["res"] .= resDelete($res,mysqli_affected_rows($conn)); break;
				case 'INSERT':	$_SESSION["res"] .= resInsert($res,mysqli_affected_rows($conn)); break;
				case 'DROP':	$_SESSION["res"] .= resDrop($res, mysqli_affected_rows($conn)); break;
				case 'ALTER':	$_SESSION["res"] .= resAlter($res, mysqli_affected_rows($conn)); break;
				case 'DESCRIBE':$_SESSION["res"] .= resDescribe($res, mysqli_affected_rows($conn)); break;
				default:	$_SESSION["res"] .= "<p style='color:green'>Query executed successfully.</p><br>";
			}

   		}else{
			$_SESSION["res"] .= "<p style='color:red'>SQL error: " . $conn->error . "</p><br>";
		}
	}catch(Exception $e){
		if($debug == true){
			$_SESSION["res"] .="<p style='color:red'>".$e. "</p></br>";
		}else{
			$_SESSION["res"] .= "<p style='color:red'>Something  went  wrong...</p></br>";
		}
	}
	if($debug == true){
			echo $query  . "<br>";
			#$status = 4;
	
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
