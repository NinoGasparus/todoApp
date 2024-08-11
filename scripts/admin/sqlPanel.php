<div id="cp3" class="panel">
	<div id="cli"> 
		<div id="cli-scroller">
			<?php
				if(session_status() != PHP_SESSION_ACTIVE){
					session_start();
				}	
		
				if(isSet($_SESSION["uid"]) && isSet($_SESSION["res"])){
					echo $_SESSION["res"];
				}
	
			?>
		</div>
		<div id="cline">
			
			>
			<form action="../scripts/admin/adminSQLQuery.php" method="POST" id="adminsql">
				<input type="text" id="clineinput" name="query" style="width:100%"></input>
			</form>
		</div>
	
	</div>

</div>
