<?php 


	//check if user is logged in and has all  credentials valid
	$err = false;
	if(isSet($_SESSION["uid"]) && isSet($_SESSION["username"])){
		$uid =  $conn->real_escape_string($_SESSION["uid"]);
		$uname = $conn->real_escape_string($_SESSION["username"]);

		$query = "SELECT username FROM user WHERE id = '$uid'";
		$res = mysqli_query($conn, $query);
	
		if(mysqli_num_rows($res) !=  1){
			$err = true;
			#echo "1";
		}else{
			if(mysqli_fetch_array($res)["username"] != $uname){
				$err = true;
				#echo "2";
			}	
		}
	}else{
		$err = true;
		#echo "3";
	}
?>



<div id="createTaskMenu" style="display:none;right:0px; bottom:0px">
	<h2> Create a new task </h2>
	<?php 
		if($err ==  true){
			echo "Not logged in or info is invalid. Please log in or tasks will not be saved";
		}
		if(!$err){
			echo '<form action="components/createTask.php" method="POST">';
		}else{
			echo  '<form action="" method="POST">';

		}
	?>
		
	<label  for="type">  Task type </label>
	<select name="type" id="taskTypeSelector">
		<option value="1"> ToDo </option>
		<option value="2"> Reminder </option>
		<option value="3"> Re-occuring </option>
	</select>

	<div id="importanceSelector" style = "display:block">
		<label for="prio"> Task importance </label>
		<select name="prio">
			<option value="1"> Lowest </option>
			<option value="2"> Low 	  </option>
			<option value="3"> Medium </option>
			<option value="4"> High	</option>
			<option value="5"> Highest </option>
		</select> 
	</div>

	<input type="text" placeholder="Enter task title" name="title"> 
	<textarea name="desc" placeholder="Enter task description"></textarea>

	<div id="dateSelector" style="display:block">
		<label for="date"> Chose a deadline </label>	
		<input type="date" name="date" id="dateSelectorIO">
	</div>

	<!-- naming scheme, tXf where, taskType (number) field, only one of following divs can be visible at time depending on active selection -->
	<div id="t1f">
		<!-- nothing -->			
	</div>
		
	<div id="t2f">

	</div>
	
	<button type="submit"> Create </button>
</form>
	<div id="taskTypeDesc"> 
		Basic, check to complete task.
	</div>
</div>


