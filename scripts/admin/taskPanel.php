<div id="cp2" class="panel">
	<h2>Task view </h2>
	<table>

		<tr>
		<td>Type</td>
		<td>Creation time</td>
		<td>Importance</td>
		<td>Comleted</td>
		<td>ID</td> 
		<td>Author</td>
		<td>Delete</td>
	</tr>
	<?php 
		loadTasks();
	?>	
</table>
</div>	


<?php
function loadTasks(){	
	include $_SERVER["DOCUMENT_ROOT"] . "/scripts/universal/conn.php";
	if($debug == true){
		ini_set('display_errors', '1');
		ini_set('display_startup_errors', '1');
		error_reporting(E_ALL); 
	}
	$status = 0;
	
	if(session_status() != PHP_SESSION_ACTIVE){
		session_start();
	}
		if(!isSet($_SESSION["uid"])){
		$status =  2;	
		goto end;
	}
	$uid = $conn->real_escape_string($_SESSION["uid"]);
	$query = "SELECT isAdmin FROM user WHERE id = '$uid'";
	$res = mysqli_query($conn, $query);
	$isAdmin = mysqli_fetch_array($res)["isAdmin"];
	if($isAdmin != 1){
		$status = 4;
		goto end;	
	
	}
	
	$query = "SELECT tasks.typeof, tasks.timeCreated, tasks.importance, tasks.complete, tasks.taskId, user.username, tasks.user_id  FROM tasks  LEFT JOIN user ON tasks.user_id = user.id";
		$res = mysqli_query($conn, $query);
		$row; 
	$rowCounter = 1;
		while($row = mysqli_fetch_array($res)){
		$type = $row["typeof"];
		$creationTime = $row["timeCreated"];
		$importance= $row["importance"];
		$completed = $row["complete"];
		$tid = $row["taskId"];
		$author =  $row["username"];
		
	echo "
		<tr>
			<td>$rowCounter</td>
			<td>$type</td>
			<td>$creationTime</td>
			<td>$importance</td>
			<td>$completed</td>
			<td>$tid</td>
			<td>$author</td>
			<td>
				<form action='../scripts/admin/adminDelTSK.php' method='POST' id='aauserDelButton'>
					<input type='hidden' name='targetID' value='$tid'>
					<button type='submit'> Delete task </button> 
				</form> 
			</td>
		</tr>";	
	$rowCounter ++;
	}
	end:	
}
?>

