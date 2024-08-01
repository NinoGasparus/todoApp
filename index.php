<?php

include "components/conn.php";
if(debug == true){
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
}
?>

<!DOCTYPE html>
<html>
<head> 
<title> Advanced todo </title>

<link rel="stylesheet" href="styles/root.css">
<link rel="stylesheet" href="styles/main.css">
<link rel="stylesheet" href="styles/nav.css">
<link rel="stylesheet" href="styles/task.css">




<script src="js/task.js"></script>
<script src="js/listeners.js"></script>
</head>

<body>
<?php 
include "components/nav.php";
?>

<div style="display:flex;height:91vh">

	<?php
	
		include "components/side.php";
		include "components/main.php";
		include "components/taskCreateMenu.php";
	?>


</div>


</body>
</html>
