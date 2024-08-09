<div id="sidebar" style="display:flex; flex-direction: column">
<?php 
	if(empty($_GET)){
		echo '<button onClick="createTask()" id="createButton"> New </button>';
	}else if($_GET["displayMode"] != 1){
		header("Location: /index.php");
	}

 

?>
</div>
