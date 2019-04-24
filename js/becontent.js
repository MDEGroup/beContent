function my_initMessage() {
	
	var msg = document.getElementById("message");
	
	if (msg.innerHTML != "") {
		var box = document.getElementById("messagebox");
		
		var top = (document.body.clientHeight/2) - 100;
		var left = (document.body.clientWidth-200)/2;
		
		box.style.top = top+"px";
		box.style.left = left+"px";
	   box.style.visibility = "visible";	
	   
	}
}

function my_closeMessage() {
	var box = document.getElementById("messagebox");
	
	box.style.visibility = "hidden";
}

function getCoordinates(element) {
 var coords = {x: 0, y: 0, width: 0};

 while (element) {
   coords.x += element.offsetLeft;
   coords.y += element.offsetTop;
//   coords.y += element.top;
   element = element.offsetParent;
 }

// alert(coords.x+' '+coords.y);
 return coords;
}


function openMenu() {
	var obj = document.getElementById("smallbox");
	if (obj.style.visibility != 'visible') {
		obj.style.visibility = 'visible';
	} else {
		obj.style.visibility = 'hidden';
	}
}
