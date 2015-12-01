$(document).ready(function(){
	var main = {};

	start();


	function start() {
		initialize();
		watch();
	}


	function initialize() {
		main = {};
	}


	function watch() {
		var errorText = '';

		$('#submit').click(function() {
			errorText = '';
			errorText += m_trialComment_add.validate();


			if (errorText.length === 0) {
				$('#error-box').html('');
					
				submit();

			} else {
				errorText =
					'<div class="alert alert-danger" style="text-align:left">\n' +
					'    <ul>\n' + errorText + '</ul>\n' +
					'</div>';
				$('#error-box').html(errorText);

			}
		});
	}



	function submit() {
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
        		alert("Comment successfully added to the trial.");
        		document.location.href = "view.php?trialseq=" + trialSeq;
        	} else {
        		alert("There was a problem. Comment not added to the trial.");
        		console.log(results.errors);
        	}
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
          alert(
          	'Status: ' + textStatus + '\n' +
        		'Error: ' + errorThrown
        	);
        }   
    });
	}	


});





