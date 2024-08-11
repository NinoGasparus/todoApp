	//get GET parameters
	function GET(keyword){
		let url =  new URLSearchParams(window.location.search);
		return url.get(keyword);

	}


function showPanel(id, sender){
	let buttons = document.getElementsByClassName("panelSelector");
	
	
	let senderID = sender.id[sender.id.length-1];
	history.pushState(null, '', window.location.pathname+"?display="+senderID);

	for(let  i of buttons){
		if(i == sender){
			i.style.backgroundColor = "var(--orange)";
		}else{
			i.style.backgroundColor = "var(--bg)";
		}
	}
	let panels = document.getElementsByClassName("panel");
	for(let  i of panels){
		if(i.id == "cp"+id){
			i.style.display = "block";
		}else{
			i.style.display = "none";
		}
	}	
	if(GET("display") == "2"){
		document.getElementById("clineinput").focus();
	}

}


