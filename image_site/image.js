function ajax(event) {
    
	var dateSelect=$("date");
	var isoSelect= $('ISOselect');

	var yeary = dateSelect.options[dateSelect.selectedIndex].value;

	//if the year is changing then change the stats. 
	if(event.target.name=="date"){
		var	change='true';
		$("ISO").checked=false;
	}
	else
		var change='false';

	if($('ISO').checked){
		var isoy  = isoSelect.options[isoSelect.selectedIndex].value;
	}else{
		isoy="false";
	}

	console.log("event "+event.target.name);
	console.log(yeary);
	console.log(isoy);
	console.log(change);

	new Ajax.Request("./image.php", {
							onSuccess: datesuccess,
							onFailure: datefailure,	
							parameters:
							{
								year:yeary,
								iso:isoy,
								isoChange:change
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
	allPhotosInMatch = response.match(regex);

	if(!allPhotosInMatch){
		console.log("none");
		 $("allPhotosIn").innerHTML="No Photos";
		  
		 $("allPhotosIn").setStyle(
			  {
			  	width: "200px"
			  }
		  );
	}
	else{
	    $("allPhotosIn").innerHTML=allPhotosInMatch[0];
	    $$('.foto').invoke('observe', 'click', mainChange);

	    var fotos = $$('.foto');
	   	fotos[0].style.borderStyle="solid";
	   	fotos[0].style.borderColor="#00FFFF";
	   	fotos[0].id="selected";
	   	$("main").src=fotos[0].src.replace("Small","");
	   	setScrollWidth();
	}

	//update iso select boxes. Only done when year is changed. 
	regex = /<option>.*<\/option>/;
	isoSelectMatch = response.match(regex);
	if(isoSelectMatch)
		$("ISOselect").innerHTML=isoSelectMatch[0];

}	

Event.observe(window, "resize", function() {
	setScrollWidth();
});	

window.onload = function() {

	$("date").disabled=false;
    $("date").onchange = ajax;
    $("ISO").onchange = ajax; 
    $("ISOselect").onchange=ajax;
	$$('.foto').invoke('observe', 'click', mainChange);
	var fotos = $$('.foto');
   	fotos[0].style.borderStyle="solid";
   	fotos[0].style.borderColor="#00FFFF";
   	fotos[0].id="selected";
   	setScrollWidth();
}
