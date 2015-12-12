autosize($('.m-commentAdd .comment textarea'));


var m_commentAdd = {};


m_commentAdd.validate = function() {
	'use strict';

	var errorText = "";
		var comment = $('.m-commentAdd .comment textarea').val();


		if (comment.length === 0) {
			errorText += "<li>Your comment is blank.</li>";
		}


		return errorText;
};



m_commentAdd.parse = function() {
	'use strict';


	var obj = {
		commentText	: prepForSQL($('.m-commentAdd .comment textarea').val())
	};


	return obj;
};





