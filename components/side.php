<div id="sidebar" style="display:flex; flex-direction: column">
<?php 
	if(empty($_GET) && basename($_SERVER["PHP_SELF"])){
		echo '<button onClick="createTask()" id="createButton"> New </button>';
	}

 

?>
</div>
