
var postbodyElement;
function myFunction() {
	var postId = 0;
  	event.preventDefault();
	postbodyElement = event.target.parentNode.parentNode.childNodes[1];
	var a = postbodyElement.textContent;
  	postId = event.target.parentNode.parentNode.childNodes[3].textContent;
  	//console.log(postId);
  	$('#hidden-input').val(postId);
  	$('#edit-input').val(a);
}

function myFunction1() {
	event.preventDefault();
	$.ajax({
		method: 'POST',
		url: url,
		data: { body: $('#edit-input').val(), postId: $('#hidden-input').val() , _token: token }
	})
	.done(function (msg){
		$(postbodyElement).text(msg['message']);
	})
}