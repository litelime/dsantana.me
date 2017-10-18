
function ajaxlookup(event) {
    
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

    if(event.target.id=="updater")
        steamidy = $("entered").textContent;
    
    if(!steamidy.match(/\d{17}/)){
        $("content").textContent = "The steam id entered is not valid.\nEnter a 17 digit value";
        if (!$("entered").textContent.includes("None Yet")){
            $("content").textContent+="\nOr click Update Text to see output for id: "+$("entered").textContent;
        }
        return;
    }
    
    $("updater").disabled=false;
        
    $("entered").textContent = steamidy;

    $("content").textContent = "loading...please wait";
    
	new Ajax.Request("/achievement_site/achievement.php", {
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
    
    var response = ajax.responseText;
    
    //char Options
	var e = $("charOption");
	var char = e.options[e.selectedIndex].value;
	if (char=="blank"){
		char = String.fromCharCode(8194);
	}
    
	$("content").textContent = response;
    
    $("spacing").max=getLongestCharSequence(response,char);

    
}	

function getLongestCharSequence(response,char){
    
    
    var lines = response.split('\n');
    
    var count = 0;
    var greatest = 0;
        
    for(var i = 0; i < lines.length; i++){

        for(var j=0; j < lines[i].length; j++){
            if(lines[i].charAt(j)==char)
                count++;
        }

 
        if(count>greatest){
            greatest = count;
            count=0;
        }
    }


    return greatest;
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
    
    if (mover.textContent == "Output Examples") {
        mover.textContent = "Hide";
    	right.style.width = "25%";
    	center.style.width = "25%";
        hide.style.display = 'block';
    } else {
        center.style.width = "50%";
        mover.textContent = "Output Examples";
    	right.style.width = "0%";
        hide.style.display = 'none';
    }
}

function preset(elem){

	var presetBox = $("presets");

	var presetString = presetBox.options[presetBox.selectedIndex].value;

	if(presetString=="amap"){
		$("num_column").checked=false;
		$("date_column").checked=false;
		$("year").checked=true;
		$("charOption").selectedIndex=6;
		$("closeOption").selectedIndex=3;
	}else if (presetString=="info"){
		$("num_column").checked=true;
		$("date_column").checked=true;
		$("month").checked=true;
		$("charOption").selectedIndex=0;
		$("closeOption").selectedIndex=2;
	}else if(presetString=="mine"){
		$("num_column").checked=false;
		$("date_column").checked=true;
		$("month").checked=true;
		$("charOption").selectedIndex=6;
		$("closeOption").selectedIndex=2;
	}

}

window.onload = function() {
    $("button").onclick = ajaxlookup;
    $("copyButton").onclick = copyToClipboard;
    $("mover").onclick = hideandshow;
    $("updater").onclick = ajaxlookup;
    $("presets").onchange = preset;
    $("num_column").checked=false;
	$("date_column").checked=false;
	$("year").checked=true;
	$("charOption").selectedIndex=6;
	$("closeOption").selectedIndex=3;

}
