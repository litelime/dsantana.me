function yearAjax(event) {
    
	var presetBox=$("date");

	var yeary = presetBox.options[presetBox.selectedIndex].value;

	console.log(yeary);

	new Ajax.Request("./index.php", {
							onSuccess: datesuccess,
							onFailure: datefailure,	
							onComplete:setScrollWidth,
							parameters:
							{
								year:yeary
							}
						}
	);
}

function mainChange(event){

	var clicked=event.target;
	var path=clicked.src;
	if($("selected")!=null){
		$("selected").style.borderStyle="none";
		$("selected").id="none";
	}
	clicked.id="selected";
	clicked.style.borderStyle="solid";
	console.log(path);
	$("main").src=path;
}


function datefailure(ajax) {
	console.log("Failed");
	console.log(ajax.status);
	console.log(ajax.statusText);
}

function setScrollWidth(){

		var children = $("allPhotosIn").childElements();

		console.log(children);

		var container_width=0;
		var altwidth=0;

		for (var i = children.length - 1; i >= 0; i--) {
			container_width+=children[i].width;
		}

		container_width+=children[0].width;

		//if images not properly loaded use altwidth
		altwidth = 190 * children.length;

		if(container_width<500){
			container_width=altwidth;
		}

		console.log(container_width);

	   $("allPhotosIn").setStyle(
		   	{
		   		width: container_width+"px"
		   	}
	   	);
	
}

function datesuccess(ajax) {

	console.log("success");
	var response = ajax.responseText;
	var regex = /<img.*<\/div>/;
	response = response.match(regex);
    $("allPhotosIn").innerHTML=response[0];
    $$('.foto').invoke('observe', 'click', mainChange);
	setScrollWidth();

}	

window.onload = function() {

	$("date").disabled=false;
    $("date").onchange = yearAjax;
	$$('.foto').invoke('observe', 'click', mainChange);
	setScrollWidth();
}
