function createTask(){	
	const cm = document.getElementById("createTaskMenu");
	if(cm.style.display == "block"){
		cm.style.display = "none";
	}else{
		cm.style.display = "block";
	}

}

function initTasks() {
   

	console.log("idk");
    let tasks = document.getElementsByClassName("taskTitle");
    let taskTitles = [];
    for (let i = 0; i < tasks.length; i++) {
        taskTitles.push(tasks[i].innerText);
    }
    console.log(taskTitles);

    const sidebar = document.getElementById("sidebar");

    for (let i = 0; i < tasks.length; i++) {
        let link = document.createElement("a");
        let newButton = document.createElement("button");

        let tid = tasks[i].id;
        newButton.innerText = taskTitles[i];

        link.href = "#" + tid;
        link.appendChild(newButton);

        sidebar.appendChild(link);
    }
}
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



	const dateSelector = document.getElementById('dateSelectorIO');
	const today = new Date().toISOString().split('T')[0];
	dateSelector.setAttribute('min', today);
});

//taskTypeActions,


function tt1Action(){
	console.log("tt1Action");
	toggleImportanceSelector()

}
function tt2Action(){
	console.log("tt2Action");
	toggleImportanceSelector()
}



function toggleImportanceSelector(){
    const imsel = document.getElementById("importanceSelector");

    if(imsel.style.display == "none"){
        imsel.style.display = "block";
    } else {
        imsel.style.display = "none";
    }
}

