autosize($('.m-groupInfo .goalText textarea'));
autosize($('.m-groupInfo .monitorText textarea'));
autosize($('.m-groupInfo .otherInfoText textarea'));
autosize($('.m-groupInfo .conclusionText textarea'));



var m_groupInfo = {};


m_groupInfo.validate = function() {
	'use strict';

	var errorText = "";
	var name = $('.m-groupInfo .name input').val();
	var startDate = $('.m-groupInfo .startDate input').val();
	var endDate = $('.m-groupInfo .endDate input').val();
	var unit = $('.m-groupInfo .unit select').val();
	var owner = $('.m-groupInfo .owner input').val();

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



m_groupInfo.parse = function() {
	'use strict';


	var info = {
		name 						: prepForSQL($('.m-groupInfo .name input').val()),
		owner 					: prepForSQL($('.m-groupInfo .owner input').val()),
		startDate 			: prepForSQL($('.m-groupInfo .startDate input').val(), 'date'),
		endDate 				: prepForSQL($('.m-groupInfo .endDate input').val(), 'date'),
		unit 						: prepForSQL($('.m-groupInfo .unit select').val()),
		goalType 				: prepForSQL($('.m-groupInfo .goalType select').val()),
		changeType 			: prepForSQL($('.m-groupInfo .changeType select').val()),
		bopVsl 					: prepForSQL($('.m-groupInfo .bopVsl select').val()),
		degasVsl 				: prepForSQL($('.m-groupInfo .degasVsl select').val()),
		argonNum 				: prepForSQL($('.m-groupInfo .argonNum select').val()),
		casterNum 			: prepForSQL($('.m-groupInfo .casterNum select').val()),
		strandNum 			: prepForSQL($('.m-groupInfo .strandNum select').val()),
		goalText 				: prepForSQL($('.m-groupInfo .goalText textarea').val()),
		monitorText 		: prepForSQL($('.m-groupInfo .monitorText textarea').val()),
		otherInfoText 	: prepForSQL($('.m-groupInfo .otherInfoText textarea').val()),
		conclusionText	: prepForSQL($('.m-groupInfo .conclusionText textarea').val())
	};


	return info;
};






