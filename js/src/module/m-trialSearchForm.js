var m_trialSearchForm = {};



m_trialSearchForm.validate = function() {
	var errorText = '';
	var startDate = $('.m-trialSearchForm .start-date input').val();
	var endDate = $('.m-trialSearchForm .end-date input').val();


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



m_trialSearchForm.parseInputs = function() {
	var obj = {
		trialName 			: prepForSQL($('.m-trialSearchForm .name input').val()),
		startDate 			: prepForSQL($('.m-trialSearchForm .start-date input').val(), 'date'),
		endDate 				: prepForSQL($('.m-trialSearchForm .end-date input').val(), 'date'),
		unit 						: prepForSQL($('.m-trialSearchForm .unit select').val()),
		trialType 			: prepForSQL($('.m-trialSearchForm .goal-type select').val()),
		changeType 			: prepForSQL($('.m-trialSearchForm .change-type select').val())
	};


	return obj;		
}	