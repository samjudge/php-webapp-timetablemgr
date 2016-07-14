var timetablesAJAXRequest = new XMLHttpRequest();
var date = new Date(); //simply set display date to today (for now).

var weekday = new Array(7);
weekday[0]=  "Sunday";
weekday[1] = "Monday";
weekday[2] = "Tuesday";
weekday[3] = "Wednesday";
weekday[4] = "Thursday";
weekday[5] = "Friday";
weekday[6] = "Saturday";

var authLevel;

timetablesAJAXRequest.onreadystatechange = function(){
	if(timetablesAJAXRequest.readyState == 4){
		var userXMLNodes = timetablesAJAXRequest.responseXML
				.getElementsByTagName("user");
		var contentNode = document.getElementById("main-content");
		var curDateDisplayNode = document.createElement("div");
		curDateDisplayNode.innerHTML =
				"<a href='#'onClick='decrementDateWeekly()'>&lt&lt</a> "
				+"<a href='#' onClick='decrementDate()'>&lt</a> "
				+ formatDate(date)
				+ " <a href='#' onClick='incrementDate()'>&gt</a> "
				+"<a href='#' onClick='incrementDateWeekly()'>&gt&gt</a>";
		contentNode.appendChild(curDateDisplayNode);
		var shiftsDivNode = document.createElement("div");
		shiftsDivNode.setAttribute("id","shifts");
		var dateUlNode = document.createElement("ul");
		var crossSectionLiNode = document.createElement("li");
		crossSectionLiNode.setAttribute("class","cross")
		dateUlNode.appendChild(crossSectionLiNode);
		for (var x = 0; x < 7; x++){
			var dateLiNode = document.createElement("li");
			if(x == 6){
				dateLiNode.setAttribute("class",x%2 == 0?"eventopend":"oddtopend");
			} else {
				dateLiNode.setAttribute("class",x%2 == 0?"eventop":"oddtop");
			}
			var operatedDate = new Date(date.getTime());
				operatedDate.setDate(date.getDate()+x);
			var operatedDateFormatted = formatDate(operatedDate);
			dateLiNode.innerHTML = operatedDateFormatted + " "
					+ weekday[operatedDate.getDay()];
			dateUlNode.appendChild(dateLiNode);
		}
		shiftsDivNode.appendChild(dateUlNode);
		for(var x = 0; x < userXMLNodes.length; x++){
			var userNode = document.createElement("ul");
			var usernameLabel = document.createElement("li");
			usernameLabel.innerHTML = userXMLNodes[x].getAttribute("username"); 
			usernameLabel.setAttribute("class","timetableusername")
			userNode.appendChild(usernameLabel);
			var shiftXMLNodes = userXMLNodes[x].getElementsByTagName("shift");
			var isUser = false;
			if (userXMLNodes[x].getAttribute("userId")
					== document.getElementById("userId").childNodes[0].data){
						isUser = true;
			}
			for(var y = 0; y < 7; y++){
				var dayNode = document.createElement("li");
				
				var operatedDate = new Date(date.getTime());
				operatedDate.setDate(date.getDate()+y);
				var operatedDateFormatted = formatDate(operatedDate);
				if(isUser){
					if(y == 6){
						dayNode.setAttribute(
								"class",y%2 == 0?"evenEndUser":"oddEndUser");
					} else {
						dayNode.setAttribute(
								"class",y%2 == 0?"evenUser":"oddUser");
					}				
				} else if(y == 6){
					dayNode.setAttribute("class",y%2 == 0?"evenEnd":"oddEnd");
				} else {
					dayNode.setAttribute("class",y%2 == 0?"even":"odd");
				}
				if(shiftXMLNodes.length == 0){
					dayNode.innerHTML = "no shift";
				} else {
					for(var z = 0; z < shiftXMLNodes.length; z++){
						var t = shiftXMLNodes[z].getAttribute("date");
						if (t == operatedDateFormatted){
							var wantRid = shiftXMLNodes[z].getAttribute("wantRid");
							dayNode.innerHTML += shiftXMLNodes[z]
									.getAttribute("startTime")
									+ " - "
									+ shiftXMLNodes[z].getAttribute("endTime")
									+ "<br/>"
									+ shiftXMLNodes[z].getAttribute("shiftName");
									if(wantRid == 1 && isUser) {
										dayNode.innerHTML += "<br/>[Cancel Swap Request]<br/>";
										dayNode.setAttribute("class",y%2 == 0?"evenWantRid":"oddWantRid");
									} else if(isUser) {
										dayNode.innerHTML += "<br/>[Swap Request]<br/>";
									} else if(wantRid == 1){
										dayNode.innterHTML += "<br/>[Request Shift]<br/>";
										dayNode.setAttribute("class",y%2 == 0?"evenWantRid":"oddWantRid");
									}
							if(authLevel == "1"){
								var editLink = "<br/><a href='editShift.php?startTime="
										+ shiftXMLNodes[z].getAttribute("startTime")
										+ "&endTime="
										+ shiftXMLNodes[z].getAttribute("endTime")
										+ "&shiftName="
										+ shiftXMLNodes[z].getAttribute("shiftName")
										+ "&shiftId="
										+ shiftXMLNodes[z].getAttribute("shiftId")
										+ "&userId="
										+ userXMLNodes[x].getAttribute("userId")
										+"&date="
										+ dateUlNode.childNodes[y+1].innerHTML.slice(0,10)
										+ "'>[edit]</a><br/>";
								editLink += "<a href='shiftDelete.php?shiftId="
										+ shiftXMLNodes[z].getAttribute("shiftId")
										+"'>[delete]</a><br/>";
								dayNode.innerHTML += editLink;
							}
						} else {
							dayNode.innerHTML = "no shift";

						}	
					}
				}
				if(authLevel == "1"){
					dayNode.innerHTML +=
							"<br/><a href='addShift.php?userId="
							+ userXMLNodes[x].getAttribute("userId")
							+"&date="
							+ dateUlNode.childNodes[y+1].innerHTML.slice(0,10)
							+ "'>[new]</a>";
				}
				userNode.appendChild(dayNode);
			}
			if(isUser){
				shiftsDivNode.insertBefore(userNode, shiftsDivNode.childNodes[1]);
			} else {
				shiftsDivNode.appendChild(userNode);
			}
		}
		contentNode.appendChild(shiftsDivNode);
	}
}

formatDate = function(operatedDate) {
	return operatedDate.getFullYear()
			+"-"+ ("0"+(operatedDate.getMonth()+1)).slice(-2)
			+"-"+ ("0"+operatedDate.getDate()).slice(-2);
}

clearMainContent = function() {
	var contentNode = document.getElementById("main-content");
	while (contentNode.hasChildNodes()){
		contentNode.removeChild(contentNode.childNodes[0]);
	}
	
}

incrementDate = function(){
	var newDate = new Date(date.getTime());
	newDate.setDate(date.getDate()+1)
	newDate = formatDate(newDate);
	setDate(newDate);
}

decrementDate = function(){
	var newDate = new Date(date.getTime());
	newDate.setDate(date.getDate()-1)
	newDate = formatDate(newDate);
	setDate(newDate);	
}

incrementDateWeekly = function(){
	var newDate = new Date(date.getTime());
	newDate.setDate(date.getDate()+7)
	newDate = formatDate(newDate);
	setDate(newDate);
}

decrementDateWeekly = function(){
	var newDate = new Date(date.getTime());
	newDate.setDate(date.getDate()-7)
	newDate = formatDate(newDate);
	setDate(newDate);	
}

setDate = function(newDate) {
	date = new Date(newDate);
	updateTimetable();
}

updateTimetable = function() {
	clearMainContent();
	timetablesAJAXRequest.open("POST","createShiftsForSiteXML.php");
	timetablesAJAXRequest.send();
}

window.onload = function(){
	authLevel = document.getElementById("authLevel").childNodes[0].data;
	timetablesAJAXRequest.open("POST","createShiftsForSiteXML.php");
	timetablesAJAXRequest.send();
}