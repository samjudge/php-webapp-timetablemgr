	var formValidation = function(){
		var timeRegEx = new RegExp("([01]?[0-9]|2[0-3]):[0-5][0-9]");
		
		var date = document.getElementById("date").value;
		
		var sTime = document.getElementById("start").value;
		var eTime = document.getElementById("end").value;

		var shouldSubmit = true;
		if(!isValidDate(date)){
			var dateErr = document.getElementById("dateError");
			dateErr.innerHTML = "*Dates must be in the format YYYY-MM-DD and be valid.";
			shouldSubmit = false;
		}

		if(!timeRegEx.test(sTime)){
			var sTErr = document.getElementById("sTimeError");
			sTErr.innerHTML = "*Times must be in the format HH:MM:SS";
			shouldSubmit = false;
		}
		if(!timeRegEx.test(eTime)){
			var eTErr = document.getElementById("eTimeError");
			eTErr.innerHTML = "*Times must be in the format HH:MM:SS";
			shouldSubmit = false;
		}
		return shouldSubmit;
	}
	
function isValidDate(date) {
	var slices = s.split('-');
	var y = slices[0], m  = slices[1], d = slices[2];
	var daysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31];
	if ( (!(y % 4) && y % 100) || !(y % 400)) { //check if leap year
		daysInMonth[1] = 29;
	}
	return d <= daysInMonth[--m]
}