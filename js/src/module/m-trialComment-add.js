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





