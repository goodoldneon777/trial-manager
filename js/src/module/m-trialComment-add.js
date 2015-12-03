autosize($('#m-trialComment-add .comment textarea'));


var m_trialComment_add = {};


m_trialComment_add.validate = function() {
	'use strict';

	var errorText = "";
		var comment = $('#m-trialComment-add .comment textarea').val();


		if (comment.length === 0) {
			errorText += "<li>Your comment is blank.</li>";
		}


		return errorText;
};



m_trialComment_add.parse = function() {
	'use strict';


	var obj = {
		commentText	: prepForSQL($('#m-trialComment-add .comment textarea').val())
	};


	return obj;
};





// $(document).ready(function(){
// 	var main = {};

// 	// start();




// 	function start() {
// 		initialize();
// 		watch();
// 	}


// 	function initialize() {
// 		main = {};
// 	}


// 	function watch() {
// 		var errorText = null;

// 		$('#submit').click(function() {
// 			errorText = validate();

// 			if (errorText.length === 0) {
// 				$('#error-box').html('');

// 				parseInputs();
// 			} else {
// 				errorText =
// 					'<div class="alert alert-danger" style="text-align:left">\n' +
// 					'    <ul>\n' + errorText + '</ul>\n' +
// 					'</div>';
// 				$('#error-box').html(errorText);
// 			}
// 		});
// 	}


// 	function validate() {
// 		var errorText = "";
// 		var comment = $('#m-trialComment-add .comment textarea').val();


// 		if (comment.length === 0) {
// 			errorText += "<li>Your comment is blank.</li>\n";
// 		}


// 		return errorText;
// 	}


// 	function parseInputs() {
// 		main.data = {
// 			trialSeq 		: getURLVariable('trialseq'),
// 			commentText	: $('#m-trialComment-add .comment textarea').val()
// 		};


// 		$.ajax({
// 				type: 'POST',
//         url: 'php/dist/sql-create-comment.php',
//         data: {
//         	'input' : JSON.stringify(main.data)
//         },
//         dataType: 'json',
//         success: function(results) {
//         	// console.log(results);
//         	alert("Comment successfully added to the database.");
//         	// location.reload();
//         	document.location.href = "view.php?trialseq=" + getURLVariable('trialseq');
//         }
//     });
// 	}	
// });





