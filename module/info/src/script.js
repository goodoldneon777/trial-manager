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
	var trialSeq = getURLVariable('trialseq');
	var groupSeq = getURLVariable('groupseq');
	var pageType = getURLVariable('type');

	if (trialSeq) {
		pageType = 'trial';
	} else if (groupSeq) {
		pageType = 'group';
	} else if (!pageType) {
		pageType = 'trial';
	}
	

	info = {
		name 						: ifBlank($('.m_info .name input').val(), null),
		owner 					: ifBlank($('.m_info .owner input').val(), null),
		startDate 			: prepDateForSQL( ifBlank($('.m_info .startDate input').val(), null) ),
		endDate 				: prepDateForSQL( ifBlank($('.m_info .endDate input').val(), null) ),
		unit 						: ifBlank($('.m_info .unit select').val(), null),
		goalType 				: ifBlank($('.m_info .goalType select').val(), null),
		changeType 			: ifBlank($('.m_info .changeType select').val(), null),
		bopVsl 					: ifBlank($('.m_info .bopVsl select').val(), null),
		degasVsl 				: ifBlank($('.m_info .degasVsl select').val(), null),
		argonNum 				: ifBlank($('.m_info .argonNum select').val(), null),
		casterNum 			: ifBlank($('.m_info .casterNum select').val(), null),
		strandNum 			: ifBlank($('.m_info .strandNum select').val(), null),
		goalText 				: ifBlank($('.m_info .goalText textarea').val(), null),
		monitorText 		: ifBlank($('.m_info .monitorText textarea').val(), null),
		otherInfoText 	: ifBlank($('.m_info .otherInfoText textarea').val(), null),
		conclusionText	: ifBlank($('.m_info .conclusionText textarea').val(), null)
	};

	//The trial version of the info module has 2 inputs more inputs than the group version.
	if (pageType === 'trial') {
		info.processChange = ifBlank($('.m_info .processChange input').val(), null);
		info.twi = ifBlank($('.m_info .twi input').val(), null);
	}


	return info;
};






