<div id="navbar">
	<div class="markDiv"><a href="/index.php"> Todo<sup>2</sup></a></div>

<div id="searchbar">
	<form action="" method="POST">
	
		<input type="text" name="searchquery" placeholder="Type here to search" > </input>
		
		<button type="submit"> Find </button>
	</form>

</div>

<?php 
session_start();

if(session_status() == PHP_SESSION_ACTIVE){
	if(isSet($_SESSION["uid"]) && isSet($_SESSION["username"])){

 		echo "<button id='usermenu'>".$_SESSION['username']."</button>";
	}else if(isSet($_COOKIE["stay"])){
		if($_COOKIE["stay"] != ""){
			
			$cookie = $conn->real_escape_string($_COOKIE["stay"]);

			$query = "SELECT user_id FROM cookies WHERE value = '$cookie'";
			$res = mysqli_query($conn, $query);
			
			if(mysqli_num_rows($res) == 0){
				setCookie("stay" , "", time()-9999999, "/");

			}else if(mysqli_num_rows($res) > 1){
				$query = "DELETE FROM cookies WHERE value = '$cookie'";
				mysqli_query($conn, $query);
				setCookie("stay" , "", time()-9999999, "/");

				mysqli_close($conn);
			}else if(mysqli_num_rows($res) === 1){
				$UID = mysqli_fetch_array($res)["user_id"];

				$query = "SELECT username, id FROM user WHERE id = '$UID' LIMIT 1";
			       	$res = mysqli_query($conn, $query);

				$row = mysqli_fetch_array($res);
					
				session_start();
				$_SESSION["uid"] = $row["id"];
				$_SESSION["username"] = $row["username"];
		 		echo "<button id='usermenu'>".$_SESSION['username']."</button>";	
			}

		}else{
			goto end;
		}
	}else{
		goto end;
	}
}else{
	end:
	mysqli_close($conn);
	echo '<a href="login.php"><button>Log In </button></a>';
}


?>
</div>

