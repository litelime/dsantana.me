function ajax(event) {
    
    //the date currently selected
	var dateSelect=$("date");

	//the iso currently selected 
	var isoSelect= $('ISOselect');

	//the exposure time currently selected
	var timeSelect= $('timeSelect');
    
	var yeary = dateSelect.options[dateSelect.selectedIndex].value;

	//if the year is changing then change the stats. 
	if(event.target.name=="date"){
		var	change='true';
		$("ISO").checked=false;
        $("time").checked=false;
	}
	// if user changed the iso option, but iso is not checked then just return
	else if(event.target.name=="ISOselect"){
		if ($('ISO').checked==false)
			return;
	}else if(event.target.name=="timeSelect"){
        if($("time").checked==false)
            return;
    }

	//if iso box is checked set isoy to iso value if not isoy is false. 
	if ($('ISO').checked)
		var isoy  = isoSelect.options[isoSelect.selectedIndex].value;
	else{
		var isoy= false;
	}
    
    	//if iso box is checked set isoy to iso value if not isoy is false. 
	if ($('time').checked)
		var timey  = timeSelect.options[timeSelect.selectedIndex].value;
	else{
		var timey= false;
	}

	console.log("event "+event.target.name);
	console.log(yeary);
	console.log(isoy);
    console.log(timey);
	console.log(change);

	new Ajax.Request("./image.php", {
							onSuccess: datesuccess,
							onFailure: datefailure,	
							parameters:
							{
								year:yeary,
								iso:isoy,
                                time:timey,
								yearChange:change
							}
						}
	);
}

/* mainChange(event)

	Changing the large photo in the middle of the page. 
	event will be used to see what small photo in the scroll
	bar the user clicked on. The large photo will be changed 
	to that picture clicked. 

*/
function mainChange(event){

	setScrollWidth();

	//what photo clicked on 
	var clicked=event.target;

	//path to the small versio of the photo clicked on 
	var smallPath=clicked.src;

	//path to the large version of the photo clicked on 
	var bigPath = smallPath.replace("Small","");
		
	//change path of the large image box. 
	$("main").src=bigPath;

	//COMMENT OUT LATER
	$("main").src=smallPath

	//remove the border from the previously clicked picture
	if($("selected")!=null){
		$("selected").style.borderStyle="none";
		$("selected").id="none";
	}

	//add blue border to the small image that was clicked. 
	clicked.id="selected";
	clicked.style.borderStyle="solid";
	clicked.style.borderColor="#00FFFF";

}

function datefailure(ajax) {
	console.log("Failed");
	console.log(ajax.status);
	console.log(ajax.statusText);
}

/* setScrollWidth

sets the css width of the scrollbar of small photos
Needed because the amount of photos there will change
so the width reflects the number of photos there.

Width is calculated based on the actual width of photos
if they are loaded, if not uses an approximation.

*/
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

/* datesuccess

Changes to be made after the user has made a selection on the
page. 
*/
function datesuccess(ajax) {

	console.log("success");

	var response = ajax.responseText;

	var regex = /<img.*<\/div>/;

	allPhotosInMatch = response.match(regex);

	//if there are no photos that match the user filters. 
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
		//take the regex match (all the img divs) and place it in the scrollbar.
	    $("allPhotosIn").innerHTML=allPhotosInMatch[0];

	    //make all photos observe clicks, mainChange will be the called method. 
	    $$('.foto').invoke('observe', 'click', mainChange);

	    var fotos = $$('.foto');

	    //the first photo will be the 'selected' one, w/ blue border
	   	fotos[0].style.borderStyle="solid";
	   	fotos[0].style.borderColor="#00FFFF";
	   	fotos[0].id="selected";

	   	//the large middle photo will be the first in the scrollbar as well. 
	   	$("main").src=fotos[0].src;
	   	$("main").src=fotos[0].src.replace("Small","");

	   	setScrollWidth();
	}

	//update iso select boxes. Only done when year is changed. 
	regex = /<option class='iso'>.*<\/select>/;
	isoSelectMatch = response.match(regex);
	if(isoSelectMatch)
		$("ISOselect").innerHTML=isoSelectMatch[0];
    
    //update exposure time boxes
	regex = /<option class='time'>.*<\/option>/;
	timeSelectMatch = response.match(regex);
    if(timeSelectMatch)
        $("timeSelect").innerHTML=timeSelectMatch[0];
    
}	

Event.observe(window, "resize", function() {
	setScrollWidth();
});	

window.onload = function() {

	$("date").disabled=false;
    $("date").onchange = ajax;
    $("ISO").onchange = ajax; 
    $("ISOselect").onchange=ajax;
    $("time").onchange = ajax;
    $("timeSelect").onchange = ajax;
	$$('.foto').invoke('observe', 'click', mainChange);
	var fotos = $$('.foto');
   	fotos[0].style.borderStyle="solid";
   	fotos[0].style.borderColor="#00FFFF";
   	fotos[0].id="selected";
   	setScrollWidth();
}
