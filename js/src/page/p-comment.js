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
		

		$('#submit').click(function() {
			submit();
		});
	}


	function submit() {
		'use strict';
		var errorText = '';
		var errorList = '';


		errorText += m_trialComment_add.validate();

		if (errorText.length === 0) {
			$('.errorHolder').html('');
				
			createComment();

		} else {
			errorList =
				'<h3>Please fix these items:</h3>' +
				'<div class="errorList">' +
				'  <ul>' + errorText + '</ul>' +
				'</div>';

			BootstrapDialog.alert({
				title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
				type: BootstrapDialog.TYPE_DANGER,
				message: errorList,
				closable: false
			});

			errorText =
				'<div class="alert alert-danger">\n' +
				'    <ul>\n' + errorText + '</ul>\n' +
				'</div>';

			$('.errorHolder').html(errorText);

		}
	}


	function createComment() {
		'use strict';
		var trialSeq = getURLVariable('trialseq');
		var o_trialComment_add = m_trialComment_add.parse();

		$.ajax({
				type: 'POST',
        url: 'php/dist/sql-create-comment.php',
        data: {
        	'trialSeq' : JSON.stringify( prepForSQL(trialSeq) ),
        	'o_trialComment_add' : JSON.stringify(o_trialComment_add)
        },
        dataType: 'json',
        success: function(results) {
	      	if (results.status === 'success') {
        		var dialog = new BootstrapDialog({
							title: '<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>&nbsp;&nbsp;Success',
							type: BootstrapDialog.TYPE_SUCCESS,
							message: '<h3 style="text-align:center;">Comment successfully created.</h3>',
							closable: false,
							buttons: [{
								label: 'OK',
								action: function(){
									document.location.href = "view.php?trialseq=" + trialSeq;
								}
							}]
						});
						
						dialog.open();
        	} else {
        		var dialog = new BootstrapDialog({
							title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
							type: BootstrapDialog.TYPE_DANGER,
							message: '<h3 style="text-align:center;">Something went wrong. Comment not created.</h3>',
							closable: false,
							buttons: [{
								label: 'OK',
								action: function(dialogRef){
                  dialogRef.close();
                }
							}]
						});
						
						dialog.open();

        		console.log(results.errors);
        	}
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
          var dialog = new BootstrapDialog({
						title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
						type: BootstrapDialog.TYPE_DANGER,
						message: '<h3>Status: ' + textStatus + '\n' + 'Error: ' + errorThrown + '</h3>',
						closable: false,
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





