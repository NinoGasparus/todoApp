<?php
include $_SERVER["DOCUMENT_ROOT"] . "/scripts/universal/conn.php";
if($debug == true){
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 
}
?>
<?php
	if(session_status() != PHP_SESSION_ACTIVE){
		session_start();
	}
	if(!isSet($_SESSION["uid"])){
		Header("Location:  /err.php");
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
		
		<button type="submit"> <p> Save  changes </p></button>
	</form>

</div>
</div>
</body>
</html>
