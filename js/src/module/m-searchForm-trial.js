var m_searchForm_trial = {};



m_searchForm_trial.validate = function() {
	var errorText = '';
	var startDate = $('.m-searchForm-trial .start-date input').val();
	var endDate = $('.m-searchForm-trial .end-date input').val();


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



m_searchForm_trial.parseInputs = function() {
	var obj = {
		trialName 			: prepForSQL($('.m-searchForm-trial .name input').val()),
		startDate 			: prepForSQL($('.m-searchForm-trial .start-date input').val(), 'date'),
		endDate 				: prepForSQL($('.m-searchForm-trial .end-date input').val(), 'date'),
		unit 						: prepForSQL($('.m-searchForm-trial .unit select').val()),
		trialType 			: prepForSQL($('.m-searchForm-trial .goal-type select').val()),
		changeType 			: prepForSQL($('.m-searchForm-trial .change-type select').val())
	};


	return obj;		
}	