$(document).ready(function(){
	'use strict';
	var main = {};

	start();


	function start() {
		'use strict';

		initialize();

		watch();
	}


	function initialize() {
		'use strict';

		main = {};
	}


	function watch() {
		'use strict';


		$('#m-search-form .trial-name').keyup(function() {
	    submit();
		});

		$('#m-search-form input').change(function() {
			submit();
		});

		$('#m-search-form select').change(function() {
			submit();
		});

		$('#submit').click(function() {
			submit();
		});
	}


	function submit() {
		var errorText = null;
		var errorList = '';
		
		errorText = validate();

			if (errorText.length === 0) {
				$('.errorHolder').html('');

				parseInputs();

			} else {
				errorList =
					'<h3>Please fix these items:</h3>' +
					'<div class="errorList">' +
					'  <ul>' + errorText + '</ul>' +
					'</div>';

				BootstrapDialog.alert({
					title: 'Error',
					type: BootstrapDialog.TYPE_DANGER,
					message: errorList
				});

				errorText =
					'<div class="alert alert-danger">' +
					'    <ul>' + errorText + '</ul>' +
					'</div>';

				$('.errorHolder').html(errorText);

			}
	}


	function validate() {
		var errorText = "";
		var startDate = $('#m-search-form .start-date input').val();
		var endDate = $('#m-search-form .end-date input').val();


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


	function parseInputs() {
		main.data = {
			trialName 			: prepForSQL($('#m-search-form .trial-name input').val()),
			startDate 			: prepForSQL($('#m-search-form .start-date input').val(), 'date'),
			endDate 				: prepForSQL($('#m-search-form .end-date input').val(), 'date'),
			unit 						: prepForSQL($('#m-search-form .trial-unit select').val()),
			trialType 			: prepForSQL($('#m-search-form .trial-type select').val()),
			changeType 			: prepForSQL($('#m-search-form .change-type select').val())
		};

// console.log(main.data);
		$.ajax({
				type: 'POST',
        url: 'php/dist/sql-search.php',
        data: {
        	'input' : JSON.stringify(main.data)
        },
        dataType: 'json',
        success: function(results) {
        	$('#m-search-results .contents').html(results.html);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
        	var dialog = new BootstrapDialog({
						title: 'Error',
						type: BootstrapDialog.TYPE_DANGER,
						message: 'Status: ' + textStatus + '\n' + 'Error: ' + errorThrown,
						closable: true,
						buttons: [{
							label: 'OK',
							action: function(dialogRef){
                dialogRef.close();
              }
						}]
					});
						
					dialog.open();
        }   
    });
	}	
});





