<?php

function clearSessions($y) {
	$sessionPath = ini_get('session.save_path');

	if($handle = opendir($sessionPath)){

		while ($file = readdir($handle)){
			if($file != "." && $file != ".."){
				$filePath = $sessionPath ."/" . $file;
                		session_id(str_replace("sess_", "", $file));
				session_start();
				
				if((isset($_SESSION['uid']) && $_SESSION['uid'] == $y) || (isset($_SESSION['username']) && $_SESSION['username'] == $y)){ 
					session_destroy();
					unlink($filePath);
				}
				
				session_write_close(); 
			}
		}
		
		closedir($handle);
	}
}

?>

