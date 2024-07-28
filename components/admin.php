<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="/styles/root.css">
	<link rel="stylesheet" href="/styles/main.css">
	<link rel="stylesheet" href="/styles/nav.css">
	<link rel="stylesheet" href="/styles/admin.css">
<script>

document.addEventListener('DOMContentLoaded', function(){
	const userActionsButton = document.getElementById("usermenu");
	const userActionsMenu = document.getElementById("userActions");
	
	let timeout;

	userActionsMenu.addEventListener("mouseover", function(){
		clearTimeout(timeout);
		userActionsMenu.style.display = "flex";

	})
	userActionsMenu.addEventListener("mouseout", function(){
		timeout = setTimeout(()=>{
			userActionsMenu.style.display = "none";
		},100)
	})

	userActionsButton.addEventListener("mouseover", function(){
		userActionsMenu.style.display = "flex";
	})
	
	userActionsButton.addEventListener("mouseout", function(){
		timeout = setTimeout(()=>{
			userActionsMenu.style.display = "none";
		},100)
	})

}) 


</script>

</head>

<body>
<?php
include "nav.php";
session_write_close();
?>
<div id="main">
	<div id="sidebar">
		<button>Edit users </button>
		<button>Search tasks</button>
		<button>Blank</button>
	</div>
	<div id="panel">
		sometjhing	
	</div>

</div>
</body>
</html>


<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 
include "conn.php";
?>
<?php
$status = 0;
try{
	if(empty($_POST)){
		$status =  1;
		goto end;
	}

	session_start();
	if(!isSet($_SESSION["uid"])){
		$status = 2;
		goto end;
	}
	if(!isSet($_SESSION["isAdmin"])){
		$status =3;
		goto end;
	}

	$uid = $conn->real_escape_string($_SESSION["uid"]);

	$query = "SELECT isAdmin FROM user WHERE id = '$uid'";
	$res = mysqli_query($conn, $query);
	$isAdmin = mysqli_fetch_array($res)["isAdmin"];
	if($isAdmin != 1){
		$status =  4;
		goto end;
	}
	session_write_close();
			
}catch(Exception $e){
	echo "err" . $e;
}

end:
//status codes
//1 empty post request
//2 missing uid
//3 admin variable not set
//4 not admin 
//
if($status != 0){
	Header("Location: /err.php");
}else{

}

?>


