function yearAjax(event) {
    
	var presetBox=$("date");

	var yeary = presetBox.options[presetBox.selectedIndex].value;

	console.log(yeary);

	new Ajax.Request("./image.php", {
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

	setScrollWidth();
	var clicked=event.target;
	var path=clicked.src;
	$("main").src = "";
	if($("selected")!=null){
		$("selected").style.borderStyle="none";
		$("selected").id="none";
	}
	clicked.id="selected";
	clicked.style.borderStyle="solid";
	clicked.style.borderColor="#00FFFF";
	console.log(path);
	$("main").src=path.replace("Small","");


}

function datefailure(ajax) {
	console.log("Failed");
	console.log(ajax.status);
	console.log(ajax.statusText);
}

function setScrollWidth(){

		var children = $("allPhotosIn").childElements();

		var container_width=0;
		var altwidth=0;
		var greatest=0;

		for (var i = children.length - 1; i >= 0; i--) {
			if(children[i].width>greatest)
				greatest=children[i].width;
			container_width+=children[i].width;
		}

		container_width+=(greatest*2);


		//if images not properly loaded use altwidth
		altwidth = 190 * children.length;

		if(container_width<500){
			console.log("alt");
			container_width=altwidth;
		}

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

    var fotos = $$('.foto');
   	fotos[0].style.borderStyle="solid";
   	fotos[0].style.borderColor="#00FFFF";
   	fotos[0].id="selected";
   	$("main").src=fotos[0].src.replace("Small","");
	setScrollWidth();

}	

window.onload = function() {

	$("date").disabled=false;
    $("date").onchange = yearAjax;
	$$('.foto').invoke('observe', 'click', mainChange);
	var fotos = $$('.foto');
   	fotos[0].style.borderStyle="solid";
   	fotos[0].style.borderColor="#00FFFF";
   	fotos[0].id="selected";
   	setScrollWidth();
}
