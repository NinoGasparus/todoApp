<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 




try{
	$status = 0;
	session_start();
	if(!empty($_POST)){
		//ALL NON 0 STATUSES ARE ERRORS AND WILL RETURN (throw - stop execution and load page as if script never ran) 
			
		
	if(!$_POST["type"] || $_POST["type"] == ""){
		$status = 1;
		goto end;
		//type is missing
	}
	
	$validTypes = [1, 2, 3];

	if(!in_array($_POST["type"], $validTypes)){
		$status =   2;
		goto end;
		//type is not among valid types (intiges)
	}

	if(!isSet($_SESSION["uid"])){
		$status = 3;
		goto end;
		//user is not logged in, cant save.
	}
	$taskType = $_POST["type"];
	
	switch($taskType){
	case "1":createTask1();break;
	}



	}
	
}catch(Exception $e){
	echo "skill issue". $e;
}
end:

if($status != 0){
	$err = "";
	switch($status){
		case 1:  $err = "Type not set";break;
		case 2:  $err = "Type invalid";break;
		case 3:  $err = "User not logged in";break;
	}
	echo $err;
	
}else{
	echo "ok";
	Header("Location: /index.php");
}


function createTask1(){
		
		include "conn.php";
		$uid = $_SESSION["uid"];

		$taskTitle = $conn->real_escape_string($_POST["title"]);
		$taskDesc = $conn->real_escape_string($_POST["desc"]);
		$taskIm = $conn->real_escape_string($_POST["prio"]);
		$taskEnd = $conn->real_escape_string($_POST["date"]);

		
		$query = "INSERT INTO tasks(typeof, title, text,importance, user_id, ends) VALUES ('1', '$taskTitle', '$taskDesc', '$taskIm', '$uid', '$taskEnd')";
		$res = mysqli_query($conn, $query);
}

?>
