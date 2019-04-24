/* 

	Copyright 2006 (C) Alfonso Pierantonio
	
	This library can freely be used and distributed 
	provided that you send and email to 
	
		alfonso@di.univaq.it
		
	specifying [beContent] in the subject and the following
	information
	
		1. name, surname
		2. affiliation
		3. commercial/personal
		4. website where is in use 	
	
	Please consider to make a donation with payPal at the
	following address

		alfonso@di.univaq.it
		
	Thank you!
	

*/ 

function my_updatePosition(form, element, arg) {
	
	var form = document.forms[form];
	var position = eval("form."+element);
		
	var trovato;
		
	for (var i=0; i<position.options.length; i++) {
		if (position.options[i].value == 0) {
     		trovato = i;
		}
	}
	position.options[trovato].text = arg.value;
	position.options[trovato].value = 0;
	position.selectedIndex = trovato;
		
}

function my_updatePosition_preload(form, element, arg, idName) {
	var form = document.forms[form];
	var position = eval("form."+element);
	var id = eval("form."+idName);
		
	var trovato = 0;
	
	for (var i=0; i<position.options.length; i++) {
		
		if (position.options[i].value == id.value) {
     		trovato = i;
		}
	}
	position.options[trovato].text = arg.value;
	position.selectedIndex = trovato;
		
}

	
function my_up(form, element) {
	var form = document.forms[form];
	var position = eval("form."+element);
	
	if (position.selectedIndex > 0) {
		
		var text = position.options[position.selectedIndex-1].text;
		var value = position.options[position.selectedIndex-1].value;
		
		position.options[position.selectedIndex-1].text = position.options[position.selectedIndex].text;
		position.options[position.selectedIndex-1].value = position.options[position.selectedIndex].value;
		position.options[position.selectedIndex].text = text;
		position.options[position.selectedIndex].value = value;	
		position.selectedIndex--;
	}
}

function my_down(form, element) {
	var form = document.forms[form];
	var position = eval("form."+element);
	
	if (position.selectedIndex < position.options.length-1) {
		
		var text = position.options[position.selectedIndex+1].text;
		var value = position.options[position.selectedIndex+1].value;
		
		position.options[position.selectedIndex+1].text = position.options[position.selectedIndex].text;
		position.options[position.selectedIndex+1].value = position.options[position.selectedIndex].value;
		position.options[position.selectedIndex].text = text;
		position.options[position.selectedIndex].value = value;	
		position.selectedIndex++;
	}
}


var http_request = false;
var global_entry; 
var global_operation;
var global_first = true;
var global_stage;

	
function makeRequest(reference, position, controlled, table, operation, stage) {
	
	var obj_reference = document.getElementById(reference);

	if (window.XMLHttpRequest) {
    	http_request = new XMLHttpRequest();
    	http_request_watch = true;
    	
      	if (http_request.overrideMimeType) {
        	http_request.overrideMimeType('text/xml');
      	}
   	} else if (window.ActiveXObject) {
      	try {
        	http_request = new ActiveXObject("Msxml2.XMLHTTP");
        	http_request_watch = true;
      	} catch (e) {
        	try {
            	http_request = new ActiveXObject("Microsoft.XMLHTTP");
            	http_request_watch = true;
         	} catch (e) {}
      	}
   	}
   	
	http_request.onreadystatechange = manageResult;
	http_request.open("GET", "ajax-manager.php?value="+obj_reference.options[obj_reference.selectedIndex].value+"&position="+position+"&controlled="+controlled+"&table="+table+"&reference="+reference+"&operation="+operation+"&stage="+stage+"&randomizer="+Math.random(123), true);
	//alert("ajax-manager.php?value="+obj_reference.options[obj_reference.selectedIndex].value+"&position="+position+"&controlled="+controlled+"&table="+table+"&reference="+reference+"&operation="+operation+"&stage="+stage+"&randomizer="+Math.random(123));
	http_request.send(null);
	
}

function manageResult() {
			
	if (http_request.readyState == 4) {
		if (http_request.status == 200) {
					
			var result = http_request.responseText; 
			var data = ajaxDecode(result);
			
			var position = data['position']; 
			var controlled = data['controlled'];  
			var operation = data['operation']; 
			var stage = data['stage']; 
			var item = data['item'];
			
			var obj_position = document.getElementById(position);
			
			obj_position.options.length = item.length;	
		
			for(i=0; i<item.length; i++) {
				
				
				obj_position.options[i].value = item[i]['value']; 
				obj_position.options[i].text = item[i]['text'];
			}
			
			var controlled_field = document.getElementById(controlled);
			
			if (operation == 'edit')  {
				
				
				if (stage == "onChange") {
					
					obj_position.options.length++;
					obj_position.options[obj_position.length-1].text = controlled_field.value;
					obj_position.options[obj_position.length-1].value = document.forms['dataEntry'].value.value;
				}
				
			} else {
				obj_position.length++;
				obj_position.options[obj_position.length-1].text = controlled_field.value;
				obj_position.options[obj_position.length-1].value = 0;
			}
			
		} else {
			alert("Error!");
		}
	}		
}
				

/* Image Show */

var index = 200;

function image_show(arg) {
	var obj = document.getElementById(arg+'_img');
	
	if (obj.style.visibility != "visible") {
		obj.style.visibility = "visible";
		index++;
		obj.style.zIndex = index;
	} else {
		obj.style.visibility = "hidden";
	}
}