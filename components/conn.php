<?php
	$conn = mysqli_connect("localhost", "phpuser", "password");
	mysqli_select_db($conn, "test");

	define('debug' ,true);
?>
