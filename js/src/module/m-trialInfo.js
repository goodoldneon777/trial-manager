autosize($('#m-trialInfo .goalText textarea'));
autosize($('#m-trialInfo .monitorText textarea'));
autosize($('#m-trialInfo .otherInfoText textarea'));
autosize($('#m-trialInfo .conclusionText textarea'));



var m_trialInfo = {};


m_trialInfo.validate = function() {
	'use strict';

	var errorText = "";
	var trialName = $('#m-trialInfo .trialName input').val();
	var startDate = $('#m-trialInfo .startDate input').val();
	var endDate = $('#m-trialInfo .endDate input').val();
	var unit = $('#m-trialInfo .unit select').val();
	var owner = $('#m-trialInfo .owner input').val();

	if (trialName.length === 0) {
		errorText += "<li>'Trial Name' is blank.</li>";
	}

	if (startDate.length === 0) {
		errorText += "<li>'Start Date' is blank.</li>";
	} else if (!isValidDate(startDate)) {
		errorText += "<li>'Start Date' is not a valid date.</li>";
	}

	if (endDate.length === 0) {
		errorText += "<li>'End Date' is blank.</li>";
	} else if (!isValidDate(endDate)) {
		errorText += "<li>'End Date' is not a valid date.</li>";
	}

	if (isValidDate(startDate)  &&  isValidDate(endDate)) {
		startDate = stringToDate(startDate);
		endDate = stringToDate(endDate);
		if (startDate > endDate) {
			errorText += "<li>'Start Date' is after 'End Date'</li>";
		}
	}

	if (unit.length === 0) {
		errorText += "<li>'Unit' is blank.</li>";
	}

	if (owner.length === 0) {
		errorText += "<li>'Owner' is blank.</li>";
	}

	return errorText;
};



m_trialInfo.parse = function() {
	'use strict';

	var elem = '$m-trialInfo';

	var trialInfo = {
		trialName 			: prepForSQL($('#m-trialInfo .trialName input').val()),
		owner 					: prepForSQL($('#m-trialInfo .owner input').val()),
		startDate 			: prepForSQL($('#m-trialInfo .startDate input').val(), 'date'),
		endDate 				: prepForSQL($('#m-trialInfo .endDate input').val(), 'date'),
		processChange 	: prepForSQL($('#m-trialInfo .processChange input').val()),
		twi 						: prepForSQL($('#m-trialInfo .twi input').val()),
		unit 						: prepForSQL($('#m-trialInfo .unit select').val()),
		trialType 			: prepForSQL($('#m-trialInfo .trialType select').val()),
		changeType 			: prepForSQL($('#m-trialInfo .changeType select').val()),
		bopVsl 					: prepForSQL($('#m-trialInfo .bopVsl select').val()),
		degasVsl 				: prepForSQL($('#m-trialInfo .degasVsl select').val()),
		argonNum 				: prepForSQL($('#m-trialInfo .argonNum select').val()),
		casterNum 			: prepForSQL($('#m-trialInfo .casterNum select').val()),
		strandNum 			: prepForSQL($('#m-trialInfo .strandNum select').val()),
		goalText 				: prepForSQL($('#m-trialInfo .goalText textarea').val()),
		monitorText 		: prepForSQL($('#m-trialInfo .monitorText textarea').val()),
		otherInfoText 	: prepForSQL($('#m-trialInfo .otherInfoText textarea').val()),
		conclusionText	: prepForSQL($('#m-trialInfo .conclusionText textarea').val())
	};


	return trialInfo;
};






