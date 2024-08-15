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

include $_SERVER["DOCUMENT_ROOT"]."/components/nav.php";
?>

<div style="display:flex;height:91vh">

	<?php
		include "components/side.php";
		include "components/main.php";
		include "scripts/main/taskCreateMenu.php";
	?>


</div>


</body>
</html>
