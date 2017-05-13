function ajaxlookup(event){

	$("content").textContent="loading...please wait";

	var steamidy = $("steamid").value;
	var num_col = $("num_column").checked;
	var date_col = $("date_column").checked;
	if($("year").checked){
		var split_opt = "year";
		console.log("year");
	}else{
		var split_opt = "month";
		console.log("month");
	}

	console.log(num_col);
	console.log(date_col);

	new Ajax.Request("achievement.php", {
							onSuccess: success,
							onFailure: failure,				
							parameters:
							{
								steamid: steamidy,
								num_column: num_col,
								date_column: date_col,
								split: split_opt
							}
						}
	);
}

function failure(ajax) {
	console.log("Failed");
	console.log(ajax.status);
	console.log(ajax.statusText);
}

function success(ajax){

	$("copyButton").disabled = false;
	$("copyButton").textContent = "Copy to Clipboard";
	$("content").textContent = ajax.responseText;

}	

function copyToClipboard(elem) {

	target = $('content');

    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
    	succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }

    if(succeed)
   		$('copyButton').textContent="Copied!";

    return succeed;
}

window.onload = function() {
    $("button").onclick = ajaxlookup;
    $("copyButton").onclick = copyToClipboard;
}
