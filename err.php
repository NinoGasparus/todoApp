<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="styles/root.css">
		<link rel="stylesheet" href="styles/nav.css">
		
		<style>
			#container{
				display:flex;
				justify-content:center;
			}
			#errorBox{
				background-color:var(--fg);
				border-radius:var(--gbr);
				width: 40%;
				padding:var(--gp);
				margin-top:calc(var(--gm) * 2);
			}
		</style>

	<script>

		document.addEventListener('DOMContentLoaded', function(){
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

		}) 

</script>
</head>
	<body>
		<?php 
			include "components/nav.php";
	
		?>
	<div id="container">

		<div id="errorBox">
			<h1> Something went wrong...</h1>
			
			<p>
				There are several possibilities:
				<ul>
					<li>Page does not exist,</li>
					<li>You are missing premissions to load the page,</li>
					<li>There was an error loading the page </li>
				</ul>
				If problem presits or you believe this is a mistake please contact our support 
			</p>
		</div>
	</div>
	</body>

</html>
