var ansCount=[];
var queCount=0;
var ansLimit=5;
var queLimit=3;

function addAnswer(queIndex){
	//*
	if(ansCount[queIndex]+1>ansLimit){
		alert("Cannot add more than "+ansLimit+" answers");
		return;
	}
	//*/
	ansCount[queIndex-1]++;
	var newdiv = document.createElement('div');
	newdiv.id = "answer"+queIndex+"-"+ansCount[queIndex];
	newdiv.innerHTML = "<input type='text' size='50' name='answers"+queIndex+"[]' placeholder='Answer' required/></br>";
	//"<input type=\"text\" size=\"100\" name=\"answer"+ansCount+"\" id=\"answer"+ansCount+"\" placeholder=\"answer "+ansCount+"\"></br>";
	document.getElementById("answers"+queIndex).appendChild(newdiv);
	//window.alert(ansCount);
}

function delAnswer(queIndex){
	var div = document.getElementById("answer"+queIndex+"-"+ansCount[queIndex]);
	document.getElementById("answers"+queIndex).removeChild(div);
	ansCount[queIndex-1]--;
	//window.alert(ansCount);
}

function addQuestion(){
	if(queCount+1>queLimit){
		alert("Cannot add more than "+queLimit+" questions");
		return;
	}
	queCount++;
	var newdiv = document.createElement('div');
	newdiv.id = "question"+queCount;
	var out = "<p>Question:</p> <input name='questions[]' type='text' size='39' placeholder='Question' required/>";
	out = out + "<p>Answers:</p> <div id='answers"+queCount+"'>";
	out = out + "<input type='text' size='50' name='answers"+queCount+"[]' placeholder='Answer' required/></br>";
	out = out + "<input type='text' size='50' name='answers"+queCount+"[]' placeholder='Answer' required/></br>";
	out = out + "</div>";
	out = out + "<div id='answer-commands'>";
	out = out + "<input type='button' name='add_answer' id='addAnswerButton' value='Add an Answer' onclick='addAnswer("+queCount+")' />"
	out = out + "<input type='button' name='del_answer' id='delAnswerButton' value='Delete last Answer' onclick='delAnswer("+queCount+")' />";
	out = out + "</div></br></br>";
/*
					<input name="topic_question" id="question" type="text" size="39" placeholder="Question" value="<?php echo $question;?>">
					<h3>Answers:</h3>
					<div id="answers">
					</div>
					<input type="button" name="add_answer" id="addAnswerButton" value="Add an Answer" onclick="addAnswer()">
					<input type="button" name="del_answer" id="delAnswerButton" value="Delete last Answer" onclick="delAnswer()">

*/
	newdiv.innerHTML = out;
	document.getElementById("questions").appendChild(newdiv);
	ansCount.push(2);
	//window.alert(ansCount);
}

function delQuestion(){
	var div = document.getElementById("question"+queCount);
	document.getElementById("questions").removeChild(div);
	ansCount.pop();
	queCount--;
	//window.alert(ansCount);
}

function queCountAdd(ansC){
	queCount++;
	ansCount.push(ansC);
	//window.alert(ansCount[queCount-1]);
}