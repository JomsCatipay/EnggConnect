var ansCount=0;
var ansLimit=5;

function addAnswer(){
	if(ansCount+1>ansLimit){
		alert("Cannot add more than "+ansLimit+" answers");
		return;
	}
	ansCount++;
	var newdiv = document.createElement('div');
	newdiv.id = "answer"+ansCount;
	newdiv.innerHTML = "<input type='text' size='50' name='answers[]' placeholder='Answer'></br>";
	//"<input type=\"text\" size=\"100\" name=\"answer"+ansCount+"\" id=\"answer"+ansCount+"\" placeholder=\"answer "+ansCount+"\"></br>";
	document.getElementById("answers").appendChild(newdiv);
}

function delAnswer(){
	var div = document.getElementById("answer"+ansCount);
	document.getElementById("answers").removeChild(div);
	ansCount--;
}