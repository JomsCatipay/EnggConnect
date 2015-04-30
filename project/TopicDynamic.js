function addReply(post_id){
	var newdiv = document.createElement('div');
	newdiv.id = "reply";

	var out = "";
	out = out + "<input type='text' name='replyText' placeholder='Reply...' required/>";
	out = out + "<input type='hidden' name='reply_id' value="+post_id+" />";
	out = out + "<input type=\"Submit\" name='replyGo' value=\"Submit Reply\" />";

	newdiv.innerHTML = out;
	
	document.getElementById(post_id).appendChild(newdiv);
}