
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="/styles/root.css">
	<link rel="stylesheet" href="/styles/main.css">
	<link rel="stylesheet" href="/styles/nav.css">
	<link rel="stylesheet" href="/styles/admin.css">
<script>

	//get GET parameters
	function GET(keyword){
		let url =  new URLSearchParams(window.location.search);
		return url.get(keyword);

	}

document.addEventListener('DOMContentLoaded', function(){
	//simulate click of first button so that page loads correctly
	
	let target =  "#selector0";
	if(GET("display") != ""){
		target =  "#selector"+GET("display");
	}

	document.querySelector(target).click();
		


	document.getElementById("clineinput").focus();


	const userActionsButton = document.getElementById("usermenu");
	const userActionsMenu = document.getElementById("userActions");
	
	let timeout;

	userActionsMenu.addEventListener("mouseover", function(){
		clearTimeout(timeout);
		userActionsMenu.style.display = "flex";

	})
	userActionsMenu.addEventListener("mouseout", function(){
		timeout = setTimeout(()=>{
			userActionsMenu.style.display = "none";
		},100)
	})

	userActionsButton.addEventListener("mouseover", function(){
		userActionsMenu.style.display = "flex";
	})
	
	userActionsButton.addEventListener("mouseout", function(){
		timeout = setTimeout(()=>{
			userActionsMenu.style.display = "none";
		},100)
	})





	document.getElementById('userDelButton').addEventListener('submit', function(event) {
		event.preventDefault();
			if (confirm('Are you sure you want to  delete this user? All their data and tasks will be deleted!')) {
				event.target.submit();
            		}            
	});



	

}) 


function showPanel(id, sender){
	let buttons = document.getElementsByClassName("panelSelector");
	
	
	let senderID = sender.id[sender.id.length-1];
	history.pushState(null, '', window.location.pathname+"?display="+senderID);

	for(let  i of buttons){
		if(i == sender){
			i.style.backgroundColor = "var(--orange)";
		}else{
			i.style.backgroundColor = "var(--bg)";
		}
	}
	let panels = document.getElementsByClassName("panel");
	for(let  i of panels){
		if(i.id == "cp"+id){
			i.style.display = "block";
		}else{
			i.style.display = "none";
		}
	}	
}


</script>

</head>

<body>
<?php
include "nav.php";
session_write_close();
?>
<div id="main">
	<div id="sidebar">
		<button onClick="showPanel(1,this)" class="panelSelector" id="selector0">Edit users </button>
		<button onClick="showPanel(2,this)" class="panelSelector" id="selector1">Search tasks</button>
		<button onClick="showPanel(3,this)" class="panelSelector" id="selector2">Database access</button>
	</div>
	<div id="panel">
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
			?>
		</table>
		</div>
		</div>	
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
				
				include "conn.php";
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
							<form action='adminDelTSK.php' method='POST' id='aauserDelButton'>
								<input type='hidden' name='targetID' value='$tid'>
								<button type='submit'> Delete task </button> 
							</form> 
						</td>
					</tr>";	
				$rowCounter ++;
				}
			?>
		</table>
	
		</div>	
		<div id="cp3" class="panel">
			<div id="cli"> 
				
				<?php
				if(session_status() != PHP_SESSION_ACTIVE){
					session_start();
				}
				if(isSet($_SESSION["uid"]) && isSet($_SESSION["res"])){
					echo $_SESSION["res"];
				}
				
				?>
				<div id="cline">
						
					>
					<form action="adminSQLQuery.php" method="POST" id="adminsql">
					<input type="text" id="clineinput" name="query" style="width:100%">
					
					</input>
					</form>
				</div>
				
			</div>
			
			</div>	
	</div>

</div>
</body>
</html>

<?php

include "conn.php";
if($debug == true){			
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL); 
}	
?>
<?php
$status = 0;
try{
	if(empty($_POST)){
		$status =  1;
		goto end;
	}

	
	if(!isSet($_SESSION["uid"])){
		$status = 2;
		goto end;
	}
	if(!isSet($_SESSION["isAdmin"])){
		$status =3;
		goto end;
	}

	$uid = $conn->real_escape_string($_SESSION["uid"]);

	$query = "SELECT isAdmin FROM user WHERE id = '$uid'";
	$res = mysqli_query($conn, $query);
	$isAdmin = mysqli_fetch_array($res)["isAdmin"];
	if($isAdmin != 1){
		$status =  4;
		goto end;
	}
	session_write_close();
			
}catch(Exception $e){
	if($debug ==true){
		echo "err" . $e;
	}else{
		Header("Location: /err.php");
	}
}

end:
//status codes
//1 empty post request
//2 missing uid
//3 admin variable not set
//4 not admin 
//
if($status != 0){
	if($debug == true){
		echo $status;
	}else{
		Header("Location: /err.php");
	}
}else{

}

?>




