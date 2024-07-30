<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 



include "conn.php"; 
$status = 0;
try{
	if(empty($_POST)){
		$status = 1;
		goto end;
	}
	if(!isSet($_POST["newPassword"]) || !isSet($_POST["targetID"])){
		$status = 2;
		goto end;
	}
	if($_POST["newPassword"] == "" || $_POST["targetID"] == ""){
		$status = 3;
		goto end;
	}
	
	$newPWD = $conn->real_escape_string($_POST["newPassword"]);
       		
	$uid =    $conn->real_escape_string($_POST["targetID"]);
	$query = "SELECT username FROM user WHERE id = '$uid'";
	
	$res = mysqli_query($conn, $query);
	if(mysqli_num_rows($res) != 1){
		$status = 4;
		goto end;
	}
	
	$password = md5($newPWD);

	$query = "UPDATE user SET password = '$password' WHERE id = '$uid'";
	mysqli_query($conn, $query);
	
	mysqli_close($conn);
	
}catch(Exception $e){
	echo "skill issue" . $e;
}
end:

	//stat codes
//1 missing request;
//2 bad request;
//3 empty field
//4 something wrong with user id
//
//	
//	
	if($status != 0){	
		Header("Location: /err.php");
	}
	else{
		Header("Location: /components/admin.php");
	}
?>
