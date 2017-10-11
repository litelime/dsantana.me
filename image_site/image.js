function ajaxlookup(event) {
    
	var presetBox=$("date");

	var yeary = presetBox.options[presetBox.selectedIndex].value;

	console.log(yeary);

	new Ajax.Request("./imageHome.php", {
							onSuccess: success,
							onFailure: failure,				
							parameters:
							{
								year:yeary
							}
						}
	);
}

function failure(ajax) {
	console.log("Failed");
	console.log(ajax.status);
	console.log(ajax.statusText);
}

function success(ajax) {

	console.log("success");
    console.log(ajax.responseText);
    $("allPhotos").innerHTML=ajax.responseText;
}	

window.onload = function() {

	$("date").disabled=false;
    $("date").onchange = ajaxlookup;

}