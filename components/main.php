<div id="taskcontainer" style="overflow-y:auto; width:100%">


<?php
	if(!isSet($_SESSION["uid"])){goto end;};

	if($_SESSION["uid"] && $_SESSION["uid"] != ""){
		$uid = $_SESSION["uid"];
		$query = "SELECT * FROM tasks WHERE user_id = '$uid' AND complete = 0 ORDER BY ends DESC,  importance DESC";
		$res = mysqli_query($conn, $query);
		
		$rowCount = mysqli_num_rows($res);
		if($rowCount == 0){
			echo "No tasks found, create one";
		}else{
			for($i = 0; $i < $rowCount;  $i++){
				$row = mysqli_fetch_array($res);
				$taskType = $row["typeof"];
					switch($taskType){
						case "1": makeTask1($row);break;
					}
	
			}
		}

	}else{
		end:
		echo "Not logged in. Log in to load and save your tasks";
	}
	

	function makeTask1($row){
		$title = $row["title"];
		$text = $row["text"];
		$timeCreated = $row["timeCreated"];
		$importance = "importanceClass".$row["importance"];
		$complete = $row["complete"];
		$taskID = $_SESSION["uid"]."_".$row["taskId"];
			
		$ends =  $row["ends"];
		
		$today = new DateTime();
    
		$future = new DateTime($ends);
    		$diff = $today->diff($future);
    		$timeLeft = $diff->days;
		echo "<div class='task $importance'>
				<h1 class='taskTitle' id='$taskID'> $title </h1>
					<div>$text </div>
					<div style='display:flex; flex-direction:row'>
						<div class='completeTask'>
							<button> Mark as complete </button>
							 <p style='color:red; font-weight:bold'>$timeLeft days left </p> 

						</div>
	
						<div style='margin-left:auto' class='taskTimeStamp'>
							Created on $timeCreated	
						</div>
					</div>

			</div>";
	}

?>


</div>
