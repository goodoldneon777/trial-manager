autosize($('.m_info .goalText textarea'));
autosize($('.m_info .monitorText textarea'));
autosize($('.m_info .otherInfoText textarea'));
autosize($('.m_info .conclusionText textarea'));



var m_info = {};


m_info.validate = function() {
	'use strict';

	var errorText = "";
	var name = $('.m_info .name input').val();
	var startDate = $('.m_info .startDate input').val();
	var endDate = $('.m_info .endDate input').val();
	var unit = $('.m_info .unit select').val();
	var owner = $('.m_info .owner input').val();

	if (name.length === 0) {
		errorText += "<li>'Name' is blank.</li>";
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



m_info.parse = function() {
	'use strict';
	var info = {};
	var pageType = getURLVariable('type');
	if (pageType !== 'group') {
		pageType = 'trial';
	}
	

	info = {
		name 						: prepForSQL($('.m_info .name input').val()),
		owner 					: prepForSQL($('.m_info .owner input').val()),
		startDate 			: prepForSQL($('.m_info .startDate input').val(), 'date'),
		endDate 				: prepForSQL($('.m_info .endDate input').val(), 'date'),
		unit 						: prepForSQL($('.m_info .unit select').val()),
		goalType 				: prepForSQL($('.m_info .goalType select').val()),
		changeType 			: prepForSQL($('.m_info .changeType select').val()),
		bopVsl 					: prepForSQL($('.m_info .bopVsl select').val()),
		degasVsl 				: prepForSQL($('.m_info .degasVsl select').val()),
		argonNum 				: prepForSQL($('.m_info .argonNum select').val()),
		casterNum 			: prepForSQL($('.m_info .casterNum select').val()),
		strandNum 			: prepForSQL($('.m_info .strandNum select').val()),
		goalText 				: prepForSQL($('.m_info .goalText textarea').val()),
		monitorText 		: prepForSQL($('.m_info .monitorText textarea').val()),
		otherInfoText 	: prepForSQL($('.m_info .otherInfoText textarea').val()),
		conclusionText	: prepForSQL($('.m_info .conclusionText textarea').val())
	};

	//The trial version of the info module has 2 inputs more inputs than the group version.
	if (pageType === 'trial') {
		info.processChange = prepForSQL($('.m_info .processChange input').val());
		info.twi = prepForSQL($('.m_info .twi input').val());
	}


	return info;
};






