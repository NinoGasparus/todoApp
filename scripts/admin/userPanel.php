<div id="cp1" class="panel">
<h2>Edit users </h2>
<div class='scroller'>
<table>

	<tr>
		<td>Username</td>
		<td>Email</td>
		<td>UserID</td>
		<td>NoOfTasks</td>
		<td>Set new password </td> 
		<td>Save</td>
		<td>Delete</td>
	</tr>	
		
	<?php
		listUsers();
	?>
	</table>
</div>
</div>	

<?php
function listUsers(){
	include "conn.php"; 
	if($debug == true){
		ini_set('display_errors', '1');
		ini_set('display_startup_errors', '1');
		error_reporting(E_ALL); 
	}
			$status = 0;
		session_start();
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
	
	$query = "SELECT user.username, user.email, user.id, COUNT(tasks.taskId) AS task_count FROM user LEFT JOIN tasks ON user.id = tasks.user_id WHERE user.isAdmin = '0' GROUP BY user.id, user.username, user.email";
		$res = mysqli_query($conn, $query);
		$row; 
		$rowCounter = 1;
		
		while($row = mysqli_fetch_array($res)){
		$username = $row["username"];
		$email = $row["email"];
		$uid = $row["id"];
		$numOfTasks = $row["task_count"];
		
	echo "
		<tr>
			<td>$rowCounter</td>
			<td>$username</td>
			<td>$email</td>
			<td>$uid</td>
			<td>$numOfTasks</td>
			<td>
				<form action='adminSetPWD.php' method='POST'>
					<input type='text' name='newPassword'>
					<input type='hidden' name='targetID' value='$uid'>
			</td>
		
			<td><button type='submit'> Save </button></form></td>
		
			<td>
				<form action='adminDelUSR.php' method='POST' id='userDelButton'>
					<input type='hidden' name='targetID' value='$uid'>
					<button type='submit'> Delete user </button> 
				</form> 
			</td>
		</tr>";	
	$rowCounter ++;
	}
		end:
}
?>
