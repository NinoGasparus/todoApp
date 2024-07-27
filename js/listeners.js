document.addEventListener('DOMContentLoaded', function() {
    initTasks();
});

document.addEventListener('DOMContentLoaded', function() {
	
	const selectElement = document.getElementById('taskTypeSelector');
	if(selectElement){
	selectElement.addEventListener('change', function(event) {
	const selectedValue = event.target.value;
    
	const desc =  document.getElementById("taskTypeDesc");
	let td =  "";
	switch(selectedValue){
		case "1": td="Basic, check to complete task."; tt1Action();break;
		case "2": td="Basic, check task which will gain max importance on the set date.";tt2Action();break;
		case "3": td="Basic, check to complete task which will re-start itself on given time interval specified amount of times";break;
		  default:  td="1";break;

	}	
	desc.innerText =  td;
	});
	}



});

document.addEventListener('DOMContentLoaded', function() {
	
	const dateSelector = document.getElementById('dateSelectorIO');
	const today = new Date().toISOString().split('T')[0];
	dateSelector.setAttribute('min', today);


})


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
