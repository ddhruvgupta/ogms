console.log('Validating...');

function confirm_delete() {
  var txt;
  var r = confirm("Are you sure you want to delete?");
  if (r == true) {
    txt = "User confirm delete";
  } else {
	event.preventDefault()
    txt = "You pressed Cancel!";
  }
  //console.log(txt);
}
