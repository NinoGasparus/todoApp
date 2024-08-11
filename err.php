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
	<script src="js/nav.js"></script>
	<script>

		document.addEventListener('DOMContentLoaded', function(){
			addMenuListeners()
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
