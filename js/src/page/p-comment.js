$(document).ready(function(){
	'use strict';
	var main = {};
	var trialSeq = getURLVariable('trialseq');
	var groupSeq = getURLVariable('groupseq');
	var pageType = '';

	if (!groupSeq) {
		pageType = 'trial';
	} else {
		pageType= 'group';
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
		

		$('#submit').click(function() {
			submit();
		});
	}



	function submit() {
		'use strict';
		var errorText = '';
		var errorList = '';


		errorText += m_commentAdd.validate();

		if (errorText.length === 0) {
			$('.errorHolder').html('');
				
			addToDatabase();

		} else {
			errorList =
				'<h3>Please fix these items:</h3>' +
				'<div class="errorList">' +
				'  <ul>' + errorText + '</ul>' +
				'</div>';

			BootstrapDialog.alert({
				title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
				type: BootstrapDialog.TYPE_DANGER,
				message: errorList
			});

			errorText =
				'<div class="alert alert-danger">\n' +
				'    <ul>\n' + errorText + '</ul>\n' +
				'</div>';

			$('.errorHolder').html(errorText);

		}
	}



	function addToDatabase() {
		'use strict';
		var seq = null;
		var comment = m_commentAdd.parse();
		var urlSQL = null;
		var urlRedirect = null;
		var msgSuccess = null;
		var msgFailure = null;

		if (pageType === 'trial') {
			seq = trialSeq;
			urlSQL = 'php/dist/sql-create-comment-trial.php';
			urlRedirect = 'view.php?trialseq=';
			msgSuccess = 'Comment successfully added.';
			msgFailure = 'Something went wrong. Comment not added.';
		} else if (pageType === 'group') {
			seq = groupSeq;
			urlSQL = 'php/dist/sql-create-comment-group.php';
			urlRedirect = 'view.php?groupseq=';
			msgSuccess = 'Comment successfully added.';
			msgFailure = 'Something went wrong. Comment not added.';
		}


		$.ajax({
				type: 'POST',
        url: urlSQL,
        data: {
        	'seq' : JSON.stringify( prepForSQL(seq) ),
        	'comment' : JSON.stringify(comment)
        },
        dataType: 'json',
        success: function(results) {
	      	if (results.status === 'success') {
        		var dialog = new BootstrapDialog({
							title: '<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>&nbsp;&nbsp;Success',
							type: BootstrapDialog.TYPE_SUCCESS,
							message: '<h3 style="text-align:center;">' + msgSuccess + '</h3>',
							buttons: [{
								label: 'OK',
								action: function(){
									document.location.href = urlRedirect + seq;
								}
							}]
						});
						
						dialog.open();
        	} else {
        		var dialog = new BootstrapDialog({
							title: '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>&nbsp;&nbsp;Error',
							type: BootstrapDialog.TYPE_DANGER,
							message: '<h3 style="text-align:center;">' + msgFailure + '</h3>',
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





