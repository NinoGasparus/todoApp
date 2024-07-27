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

