var textbox = document.getElementById("textbox");
var chars = 160;

//add event listener for keypress (does not include shift alt ctrl etc)
textbox.addEventListener("keypress", function(ev){
	//init a counter var
	var remainingChar = chars - (textbox.value.length +1);
	//display counter bar in the remainingC tags
	document.getElementById("remainingC").innerHTML = remainingChar ;
	//test if you still have chars left
	if(remainingChar <= 0){
		//if no disable the textbox
		textbox.readOnly = true;
	}
})