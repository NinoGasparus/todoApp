document.addEventListener('DOMContentLoaded', function(){
	



	//simulate click of first button so that page loads correctly
	//makes the side button  turn orange
	let target =  "#selector0";
	if(GET("display") != ""){
		target =  "#selector"+GET("display");
	}
	document.querySelector(target).click();
	









	//in case that database access panel is open it will auto focus the interface, so user can just start typing
	if(GET("display") == "2"){
		document.getElementById("clineinput").focus();
	}
	





	
	//auto-scrolls to the bottom of the command line in Database access
	let div = document.getElementById("cli-scroller");
	div.scrollTop = div.scrollHeight;

	addMenuListeners()
}) 

