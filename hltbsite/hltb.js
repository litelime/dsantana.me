function ajaxlookup(event) {
    
    console.log(event);
    
	new Ajax.Request("../hltbsite/hltb.php", {
							onSuccess: success,
							onFailure: failure				
						}
	);
}

function failure(ajax) {
	console.log("Failed");
	console.log(ajax.status);
	console.log(ajax.statusText);
}

function success(ajax) {

    console.log(ajax.responseText);
	$("content").textContent = ajax.responseText;

}	


window.onload = function() {
    $("button").onclick = ajaxlookup;
}
