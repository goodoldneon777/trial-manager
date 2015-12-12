var m_groupSearchForm = {};


m_groupSearchForm.validate = function() {
	var errorText = '';
	var startDate = $('.m-groupSearchForm .start-date input').val();
	var endDate = $('.m-groupSearchForm .end-date input').val();


	if ( (startDate.length > 0)  &&  (!isValidDate(startDate)) ) {
		errorText += "<li>'Start Date' is not a valid date.</li>";
	}

	if ( (endDate.length > 0)  &&  (!isValidDate(endDate)) ) {
		errorText += "<li>'End Date' is not a valid date.</li>";
	}

	if ( (startDate.length > 0)  &&  (endDate.length > 0) ) {
		if (isValidDate(startDate)  &&  isValidDate(endDate)) {
			startDate = stringToDate(startDate);
			endDate = stringToDate(endDate);
			
			if (startDate > endDate) {
				errorText += "<li>'Start Date' is after 'End Date'</li>";
			}
		}
	}

	return errorText;
}



m_groupSearchForm.parseInputs = function() {
	var obj = {
		trialName 	: prepForSQL($('.m-groupSearchForm .name input').val()),
		startDate 	: prepForSQL($('.m-groupSearchForm .start-date input').val(), 'date'),
		endDate 		: prepForSQL($('.m-groupSearchForm .end-date input').val(), 'date'),
		unit 				: prepForSQL($('.m-groupSearchForm .unit select').val()),
		trialType 	: prepForSQL($('.m-groupSearchForm .goal-type select').val()),
		changeType 	: prepForSQL($('.m-groupSearchForm .change-type select').val())
	};


	return obj;		
}	