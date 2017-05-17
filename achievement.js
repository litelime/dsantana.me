function ajaxlookup(event) {

	$("content").textContent = "loading...please wait";

	var steamidy = $("steamid").value;
	var num_col = $("num_column").checked;
	var date_col = $("date_column").checked;

	//Split options
	if ($("year").checked) {
		var split_opt = "year";
	} else {
		var split_opt = "month";
	}

	//char Options
	var e = $("charOption");
	var char = e.options[e.selectedIndex].value;
	if (char=="blank"){
		char = String.fromCharCode(8194);
	}

	var j = $("sortOption");
	var sortopt = j.options[j.selectedIndex].value;

    
	var k = $("closeOption");
	var surrounding = k.options[k.selectedIndex].value;
    
	console.log(num_col);
	console.log(date_col);
	console.log(steamidy);
	console.log(split_opt);
	console.log(char);
	console.log(sortopt);
    console.log(surrounding);

	new Ajax.Request("achievement.php", {
							onSuccess: success,
							onFailure: failure,				
							parameters:
							{
								steamid: steamidy,
								num_column: num_col,
								date_column: date_col,
								split: split_opt,
								schar: char,
								sort: sortopt,
                                surrChar:surrounding
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
    	mover.textContent = "Hide Examples (More room for output)";
    	right.style.width = "25%";
    	center.style.width = "30%";
        hide.style.display = 'block';
    } else {
    	center.style.width = "55%";
    	mover.textContent = "Show Examples";
    	right.style.width = "0%";
        hide.style.display = 'none';
    }

}

window.onload = function() {
    $("button").onclick = ajaxlookup;
    $("copyButton").onclick = copyToClipboard;
    $("mover").onclick = hideandshow;
}
