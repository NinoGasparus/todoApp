<div id="taskcontainer" style="overflow-y:auto; width:100%">

<?php 
?>

<?php
	// 0->active tasks, 1-> completed tasks, 2-> search tasks
		
	$displayMode = 0;

	if(empty($_GET)){	
	}else if(isSet($_GET["displayMode"])){
		if($_GET["displayMode"] == 1);
		{
			$displayMode = 1;
		}
	}else if(isSet($_GET["searchquery"])){
		if($_GET["searchquery"] != ""){
			$displayMode = 2;
		}
	}


	if(!isSet($_SESSION["uid"])){goto end;};

	if($_SESSION["uid"] && $_SESSION["uid"] != ""){
		$uid = $_SESSION["uid"];
		
		$query ="";
		if($displayMode == 0){
			//$query="SELECT * FROM tasks WHERE user_id = '$uid' AND complete = 0 ORDER BY CASE WHEN deadline = CURDATE() THEN 0 WHEN importance = -1 THEN 2 ELSE 1 END, ends ASC, importance DESC";

			//$query = "SELECT * FROM tasks WHERE user_id = '$uid' AND complete = 0 ORDER BY CASE WHEN importance = -1 THEN 2 WHEN DATE(ends) = CURDATE() THEN 0 ELSE 1 END, ends ASC, importance DESC";

			//$query = "SELECT * FROM tasks WHERE user_id = '$uid' AND complete = 0 ORDER BY CASE WHEN importance = -1 THEN 1 ELSE 0 END, ends DESC, importance DESC";
			//$query = "SELECT * FROM tasks WHERE user_id = '$uid' AND complete = 0 AND CURDATE() = DATE(deadline)";	
			//$query = "SELECT * FROM tasks WHERE user_id = '$uid' AND complete = 0 ORDER BY ends ASC,  importance DESC";
			//
			$query = "(SELECT * FROM tasks WHERE user_id = '$uid' AND complete =  0 AND deadline = CURDATE()) UNION ALL (SELECT * FROM tasks WHERE user_id = '$uid' AND complete =  0 AND NOT importance = -1 ORDER BY  ends ASC, importance DESC)";
		}else if($displayMode == 1){
			$query = "SELECT * FROM tasks WHERE user_id = '$uid' AND complete = 1 ORDER BY ends";
		}else if($displayMode == 2){
			$keyword = strtolower($conn->real_escape_string($_GET["searchquery"]));
			$query = "SELECT * FROM tasks WHERE LOWER(title) LIKE '%$keyword%' OR LOWER(text) LIKE '%$keyword%'";
		}

		$res = mysqli_query($conn, $query);
		
		$rowCount = mysqli_num_rows($res);
		if($rowCount == 0){
			switch($displayMode){
				case 0:	echo "No tasks found, create one";break;
				case 1: echo "No completed tasks";break;
				case 2: echo "No matches found";break;
			}
		}else{
			for($i = 0; $i < $rowCount;  $i++){
				$row = mysqli_fetch_array($res);
				$taskType = $row["typeof"];
					switch($taskType){
					case "1": makeTask1($row,$displayMode);break;
					case "2": makeTask2($row,$displayMode);break;
					}
	
			}
		}

	}else{
		end:
		echo "Not logged in. Log in to load and save your tasks";
	}
	

	function makeTask1($row, $displayMode){
		$title = $row["title"];
		$text = $row["text"];
		$timeCreated = $row["timeCreated"];
		$importance = "importanceClass".$row["importance"];
		$complete = $row["complete"];
		$taskID = $_SESSION["uid"]."_".$row["taskId"];
		$taskIntID = $row["taskId"];
		$ends =  $row["ends"];
		
		$today = new DateTime();
    
		$future = new DateTime($ends);
    		$diff = $today->diff($future);
    		$timeLeft = $diff->days;
		echo "<div class='task $importance'>
				<h1 class='taskTitle' id='$taskID'> $title </h1>
					<div>$text </div>
					<div style='display:flex; flex-direction:row'>
						<div class='completeTask'>";
		if($displayMode == 0){
			echo "
							<form action='components/completeTask.php' method='POST'>
								<button type='submit' name='taskID' value='$taskIntID' > Mark as complete </button> 
							</form>
							<p style='color:black; font-weight:bold'>$timeLeft days left </p>";}
		else if($displayMode == 1){
			echo "				<form action='components/delTask.php' method='POST'>
								<button type='submit' name='taskID' value='$taskIntID' > Delete task </button> 
							</form>";
	
		}

			echo "			</div>
	
						<div style='margin-left:auto' class='taskTimeStamp'>
							Created on $timeCreated	
						</div>
					</div>

			</div>";
	}


function  makeTask2($row,$displayMode){
		$title = $row["title"];
		$text = $row["text"];
		$timeCreated = $row["timeCreated"];
		$importance = "importanceClass".$row["importance"];
		$complete = $row["complete"];
		$taskID = $_SESSION["uid"]."_".$row["taskId"];
		$taskIntID = $row["taskId"];
		$ends =  $row["ends"];
		
		$today = new DateTime();
    
		$future = new DateTime($ends);
    		$diff = $today->diff($future);
		$timeLeft = $diff->days;

		if($timeLeft == 0){
			$importance = "importanceClass5";
		}
		echo "<div class='task $importance'>
				<h1 class='taskTitle' id='$taskID'> $title </h1>
					<div>$text </div>
					<div style='display:flex; flex-direction:row'>
						<div class='completeTask'>";
		if($displayMode == 0){
			echo "
							<form action='components/completeTask.php' method='POST'>
								<button type='submit' name='taskID' value='$taskIntID' > Mark as complete </button> 
							</form>
							<p style='color:black; font-weight:bold'>$timeLeft days left </p>";}
		else if($displayMode == 1){
			echo "				<form action='components/delTask.php' method='POST'>
								<button type='submit' name='taskID' value='$taskIntID' > Delete task </button> 
							</form>";
	
		}

			echo "			</div>
	
						<div style='margin-left:auto' class='taskTimeStamp'>
							Created on $timeCreated	
						</div>
					</div>

			</div>";
	}


?>


</div>
