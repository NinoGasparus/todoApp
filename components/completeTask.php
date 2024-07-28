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
	
	if(isSet($_POST["taskID"])){
		if($_POST["taskID"] != ""){
			session_start();
			if(!isSet($_SESSION["uid"])){
				$status = 2;
				goto end;
			}

			$uid = $conn->real_escape_string($_SESSION["uid"]);
			$query = "SELECT id FROM user WHERE id = '$uid'";
			$res = mysqli_query($conn, $query);
			if(mysqli_num_rows($res)  != 1){
				$status = 3;
				goto end;
			}

			$taskID = $conn->real_escape_string($_POST["taskID"]);
			$query = "UPDATE tasks SET complete = 1 WHERE taskId = '$taskID'";
			
			if(!mysqli_query($conn, $query)){
				$status = 4;
				goto end;
			}
			mysqli_close($conn);

		}
	}
}catch(Exception $e){
	$status = 5;
	mysqli_close($conn);
}
end:

	//status codes
	//1 missing request
	//2 no uid provided
	//3 more than 1ID hit
	//4 query failed
	//5 server error

	echo $status;
	if($status == 0){
		Header("Location: /index.php");
	}
