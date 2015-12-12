$(document).ready(function(){
	'use strict';
	var main = {};
	var pageType = getURLVariable('type');	//Get the page type from the URL.
	
	if (pageType !== 'group') {
		pageType = 'trial';
	}


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
		var elemForm = '';
		if (pageType === 'trial') {		//The search form has different classes: for trials and groups.
			elemForm = '.m-searchForm-trial';
		} else if (pageType === 'group') {
			elemForm = '.m-searchForm-group';
		}

		$(elemForm + ' .name').keyup(function() {		//Watch for typing in the name input. This allows for live searching while the user types.
	    submit();
		});

		$(elemForm + ' input').change(function() {		//Watch for changes in any input. This doesn't cover live searching while typing.
			submit();
		});

		$(elemForm + ' select').change(function() {		//Watch for changes in any of the dropdowns.
			submit();
		});

		$('#submit').click(function() {		//Watch for clicking the submit button.
			submit();
		});
	}



	function submit() {
		var errorText = null;
		var errorList = '';
		
		//Depending on the page type, validate the search form. The validate functions return lists of errors.
		if (pageType === 'trial') {
			errorText = m_searchForm_trial.validate();
		} else if (pageType === 'group') {
			errorText = m_searchForm_group.validate();
		}


		//If there weren't any errors
		if (errorText.length === 0) {
			$('.errorHolder').html('');


			//Depending on the page type, parse the search form.
			if (pageType === 'trial') {
				main.data = m_searchForm_trial.parseInputs();
			} else if (pageType === 'group') {
				main.data = m_searchForm_group.parseInputs();
			}


			//Run the function that searches the DB.
			search(pageType);


		} else {	//If there was at least 1 error
			//Build the HTML for the error dialog.
			errorList =
				'<h3>Please fix these items:</h3>' +
				'<div class="errorList">' +
				'  <ul>' + errorText + '</ul>' +
				'</div>';

			//Alert the user with the errors.
			BootstrapDialog.alert({
				title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
				type: BootstrapDialog.TYPE_DANGER,
				message: errorList
			});

			//Build the HTML for the embedded error box.
			errorText =
				'<div class="alert alert-danger">' +
				'    <ul>' + errorText + '</ul>' +
				'</div>';

			//Update the embedded error box with the errors.
			$('.errorHolder').html(errorText);

		}
	}



	function search(pageType) {
		var urlSQL = '';

		if (pageType === 'trial') {
			urlSQL = 'php/dist/sql-searchTrial.php'
		} else if (pageType === 'group') {
			urlSQL = 'php/dist/sql-searchGroup.php'
		}


		$.ajax({
			type: 'POST',
      url: urlSQL,
      data: {
      	'input' : JSON.stringify(main.data)
      },
      dataType: 'json',
      success: function(results) {
      	$('.m-searchResults .contents').html(results.html);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) { 
      	var dialog = new BootstrapDialog({
					title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
					type: BootstrapDialog.TYPE_DANGER,
					message: 'Status: ' + textStatus + '\n' + 'Error: ' + errorThrown,
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





