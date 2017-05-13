function ajaxlookup(event){

	$("content").textContent="loading...please wait";

	var steamidy = $("steamid").value;
	var num_col = $("num_column").checked;
	var date_col = $("date_column").checked;
	if($("year").checked){
		var split_opt = "year";
	}else{
		var split_opt = "month";
	}

	var e = document.getElementById("charOption");
	var char = e.options[e.selectedIndex].value;
	if(char=="blank"){
		char = String.fromCharCode(8201);
	}

	console.log(num_col);
	console.log(date_col);
	console.log(steamidy);
	console.log(split_opt);
	console.log(char);

	new Ajax.Request("achievement.php", {
							onSuccess: success,
							onFailure: failure,				
							parameters:
							{
								steamid: steamidy,
								num_column: num_col,
								date_column: date_col,
								split: split_opt,
								schar: char
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

function hideandshow(elem){

	var right = $("right");
	var mover = $("mover");
	var center = $("center");
	var hide = $("hide");

    if (hide.style.display === 'none') {
    	mover.textContent = "Hide Examples";
    	right.style.width = "25%";
    	mover.style.width="40%";
    	center.style.width = "30%";
        hide.style.display = 'block';
    } else {
    	center.style.width = "45%";
    	mover.textContent = "Show Examples";
    	mover.style.width="100%";
    	right.style.width = "10%";
        hide.style.display = 'none';
    }

}

window.onload = function() {
    $("button").onclick = ajaxlookup;
    $("copyButton").onclick = copyToClipboard;
    $("mover").onclick = hideandshow;
}
