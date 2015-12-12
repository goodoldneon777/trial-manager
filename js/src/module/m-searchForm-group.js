var m_searchForm_group = {};


m_searchForm_group.validate = function() {
	var errorText = '';
	var startDate = $('.m-searchForm-group .start-date input').val();
	var endDate = $('.m-searchForm-group .end-date input').val();


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



m_searchForm_group.parseInputs = function() {
	var obj = {
		trialName 	: prepForSQL($('.m-searchForm-group .name input').val()),
		startDate 	: prepForSQL($('.m-searchForm-group .start-date input').val(), 'date'),
		endDate 		: prepForSQL($('.m-searchForm-group .end-date input').val(), 'date'),
		unit 				: prepForSQL($('.m-searchForm-group .unit select').val()),
		trialType 	: prepForSQL($('.m-searchForm-group .goal-type select').val()),
		changeType 	: prepForSQL($('.m-searchForm-group .change-type select').val())
	};


	return obj;		
}	