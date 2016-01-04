var m_search = {};



m_search.start = function() {
	'use strict';


	m_search.watch();
};



m_search.watch = function() {
	'use strict';


	$('.m_search .name').keyup(function() {		//Watch for typing in the name input. This allows for live searching while the user types.
    m_search.submit();
	});

	$('.m_search input').change(function() {		//Watch for changes in any input. This doesn't cover live searching while typing.
		m_search.submit();
	});

	$('.m_search select').change(function() {		//Watch for changes in any of the dropdowns.
		m_search.submit();
	});

	$('.m_search .c_submitBtn').click(function() {		//Watch for clicking the submit button.
		m_search.submit();
	});
};



m_search.validate = function() {
	'use strict';
	var errorText = '';
	var startDate = $('.m_search .start-date input').val();
	var endDate = $('.m_search .end-date input').val();


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
};



m_search.parse = function() {
	'use strict';
	var obj = {
		name 				: ifBlank($('.m_search .c_form .name input').val(), null),
		startDate 	: prepDateForSQL( ifBlank($('.m_search .c_form .start-date input').val(), null) ),
		endDate 		: prepDateForSQL( ifBlank($('.m_search .c_form .end-date input').val(), null) ),
		unit 				: ifBlank($('.m_search .c_form .unit select').val(), null),
		goalType 		: ifBlank($('.m_search .c_form .goal-type select').val(), null),
		changeType 	: ifBlank($('.m_search .c_form .change-type select').val(), null)
	};


	return obj;		
};



m_search.submit = function() {
	var errorText = '';
	var errorList = '';
	var msg = '';
	

	errorText = m_search.validate();


	//If there weren't any errors
	if (errorText.length === 0) {
		$('.m_search .c_errorBox .content').html('');


		//Run the function that searches the DB.
		m_search.search();

	} else {	//If there was at least 1 error
		//Build the HTML for the error dialog.
		errorList =
			'<h3>Please fix these items:</h3>' +
			'<div class="errorList">' +
			'  <ul>' + errorText + '</ul>' +
			'</div>';

		//Alert the user with the errors.
		msg = errorList;
  	dialogError(msg);

		//Build the HTML for the embedded error box.
		errorText =
			'<div class="alert alert-danger">' +
			'    <ul>' + errorText + '</ul>' +
			'</div>';

		//Update the embedded error box with the errors.
		$('.m_search .c_errorBox .content').html(errorText);

	}
};



m_search.search = function() {
	'use strict';
	var msg = '';
	var input = m_search.parse();
	var pageType = getURLVariable('type');	//Get the page type from the URL.
	if (pageType !== 'group') {
		pageType = 'trial';
	}


	$.ajax({
		type: 'POST',
    url: gVar.root + '/module/search/dist/sql_search.php',
    data: {
    	'input' : JSON.stringify(input),
    	'pageType' : JSON.stringify(pageType)
    },
    dataType: 'json',
    success: function(results) {
    	$('.m_search .c_results').html(results.html);
    	console.log(results.sql);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
    	msg = 'Status: ' + textStatus + '\n' + 'Error: ' + errorThrown;
  		dialogError(msg);
    }   
  });

}





$( document ).ready(function() {
    m_search.start();
});