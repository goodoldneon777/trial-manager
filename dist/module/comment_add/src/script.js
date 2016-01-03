autosize($('.m_comment_add textarea'));


var m_comment_add = {};



m_comment_add.validate = function() {
	'use strict';
	var errorText = '';
	var commentText = $('.m_comment_add textarea').val();


  if (commentText.length === 0) {
		errorText += "<li>Comment text is blank.</li>";
	}


	return errorText;
};



m_comment_add.parse = function() {
	'use strict';
	var commentText = $('.m_comment_add textarea').val();


	return commentText;
};




