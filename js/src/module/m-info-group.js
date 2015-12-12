autosize($('.m-info-group .goalText textarea'));
autosize($('.m-info-group .monitorText textarea'));
autosize($('.m-info-group .otherInfoText textarea'));
autosize($('.m-info-group .conclusionText textarea'));



var m_info_group = {};


m_info_group.validate = function() {
	'use strict';

	var errorText = "";
	var name = $('.m-info-group .name input').val();
	var startDate = $('.m-info-group .startDate input').val();
	var endDate = $('.m-info-group .endDate input').val();
	var unit = $('.m-info-group .unit select').val();
	var owner = $('.m-info-group .owner input').val();

	if (name.length === 0) {
		errorText += "<li>'Group Name' is blank.</li>";
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



m_info_group.parse = function() {
	'use strict';


	var info = {
		name 						: prepForSQL($('.m-info-group .name input').val()),
		owner 					: prepForSQL($('.m-info-group .owner input').val()),
		startDate 			: prepForSQL($('.m-info-group .startDate input').val(), 'date'),
		endDate 				: prepForSQL($('.m-info-group .endDate input').val(), 'date'),
		unit 						: prepForSQL($('.m-info-group .unit select').val()),
		goalType 				: prepForSQL($('.m-info-group .goalType select').val()),
		changeType 			: prepForSQL($('.m-info-group .changeType select').val()),
		bopVsl 					: prepForSQL($('.m-info-group .bopVsl select').val()),
		degasVsl 				: prepForSQL($('.m-info-group .degasVsl select').val()),
		argonNum 				: prepForSQL($('.m-info-group .argonNum select').val()),
		casterNum 			: prepForSQL($('.m-info-group .casterNum select').val()),
		strandNum 			: prepForSQL($('.m-info-group .strandNum select').val()),
		goalText 				: prepForSQL($('.m-info-group .goalText textarea').val()),
		monitorText 		: prepForSQL($('.m-info-group .monitorText textarea').val()),
		otherInfoText 	: prepForSQL($('.m-info-group .otherInfoText textarea').val()),
		conclusionText	: prepForSQL($('.m-info-group .conclusionText textarea').val())
	};


	return info;
};






