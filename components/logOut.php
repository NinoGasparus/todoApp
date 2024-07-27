<?php
	try{
		session_start();
		session_destroy();
		
		$_SESSION["uid"] = -1;
		$_SESSION["username"] = "";
	
		if(isSet($_COOKIE["stay"])){
			setCookie("stay", "", time()-3600, "/");
		}
	
		session_unset();

		Header("Location:  /index.php");
	}catch(Exception $e){
		echo "Logging out failed, please clear your cookies and reopen the browser to log out";
	}

