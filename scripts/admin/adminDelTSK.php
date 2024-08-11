<?php
include $_SERVER["DOCUMENT_ROOT"] . "/scripts/universal/conn.php";
if($debug == true){
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 
}


$status = 0;
try{
	if(empty($_POST)){
		$status = 1;
		goto end;
	}
	if(!isSet($_POST["targetID"])){
		$status = 2;
		goto end;
	}

	$uid = $conn->real_escape_string($_POST["targetID"]);
	$query = "DELETE FROM tasks WHERE taskId = '$uid'";
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
		echo $status;
		Header("Location: /err.php");
	}
	else{
		Header("Location: /components/admin.php?display=1");
	}
?>
