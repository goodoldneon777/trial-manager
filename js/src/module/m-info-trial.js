autosize($('.m-info-trial .goalText textarea'));
autosize($('.m-info-trial .monitorText textarea'));
autosize($('.m-info-trial .otherInfoText textarea'));
autosize($('.m-info-trial .conclusionText textarea'));



var m_info_trial = {};


m_info_trial.validate = function() {
	'use strict';

	var errorText = "";
	var trialName = $('.m-info-trial .name input').val();
	var startDate = $('.m-info-trial .startDate input').val();
	var endDate = $('.m-info-trial .endDate input').val();
	var unit = $('.m-info-trial .unit select').val();
	var owner = $('.m-info-trial .owner input').val();

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



m_info_trial.parse = function() {
	'use strict';
	var info = {
		name 						: prepForSQL($('.m-info-trial .name input').val()),
		owner 					: prepForSQL($('.m-info-trial .owner input').val()),
		startDate 			: prepForSQL($('.m-info-trial .startDate input').val(), 'date'),
		endDate 				: prepForSQL($('.m-info-trial .endDate input').val(), 'date'),
		processChange 	: prepForSQL($('.m-info-trial .processChange input').val()),
		twi 						: prepForSQL($('.m-info-trial .twi input').val()),
		unit 						: prepForSQL($('.m-info-trial .unit select').val()),
		goalType 				: prepForSQL($('.m-info-trial .goalType select').val()),
		changeType 			: prepForSQL($('.m-info-trial .changeType select').val()),
		bopVsl 					: prepForSQL($('.m-info-trial .bopVsl select').val()),
		degasVsl 				: prepForSQL($('.m-info-trial .degasVsl select').val()),
		argonNum 				: prepForSQL($('.m-info-trial .argonNum select').val()),
		casterNum 			: prepForSQL($('.m-info-trial .casterNum select').val()),
		strandNum 			: prepForSQL($('.m-info-trial .strandNum select').val()),
		goalText 				: prepForSQL($('.m-info-trial .goalText textarea').val()),
		monitorText 		: prepForSQL($('.m-info-trial .monitorText textarea').val()),
		otherInfoText 	: prepForSQL($('.m-info-trial .otherInfoText textarea').val()),
		conclusionText	: prepForSQL($('.m-info-trial .conclusionText textarea').val())
	};


	return info;
};






