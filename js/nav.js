function addMenuListeners(){

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
	
}
