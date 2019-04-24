
function openvideo(stream,logo) {
	video = window.open('stream.php?stream='+stream+'&logo='+logo,'finestra','scrollbars=no,resizable=no,width=370,height=292,status=no,location=no,toolbar=no'); video.focus();	
}

