<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="/styles/root.css">
	<link rel="stylesheet" href="/styles/main.css">
	<link rel="stylesheet" href="/styles/nav.css">
	<link rel="stylesheet" href="/styles/admin.css">
<script src="/js/nav.js"></script>
<script src="/js/admin/admin.js"></script>
<script src="/js/admin/listeners.js"></script>
</head>

<body>
<?php
include $_SERVER["DOCUMENT_ROOT"] . "/components/nav.php";
session_write_close();
?>
<div id="main">
	<div id="sidebar">
		<button onClick="showPanel(1,this)" class="panelSelector" id="selector0">Edit users </button>
		<button onClick="showPanel(2,this)" class="panelSelector" id="selector1">Search tasks</button>
		<button onClick="showPanel(3,this)" class="panelSelector" id="selector2">Database access</button>
	</div>
	<div id="panel">
		<?php 
			include "../scripts/admin/userPanel.php";
			include "../scripts/admin/taskPanel.php";
			include "../scripts/admin/sqlPanel.php";
		?>
		
	</div>

</div>
</body>
</html>

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
try{
	//Disabled for causing issues, on reloading the page POST req. is missing.
	/*if(empty($_POST)){
		$status =  1;
		goto end;
	}*/

	
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
	if($debug ==true){
		echo "err" . $e;
	}else{
		Header("Location: /err.php");
	}
}

end:
//status codes
//1 empty post request
//2 missing uid
//3 admin variable not set
//4 not admin 
//
if($status != 0){
	if($debug == true){
		echo $status;
	}else{
		Header("Location: /err.php");
	}
}else{

}

?>




