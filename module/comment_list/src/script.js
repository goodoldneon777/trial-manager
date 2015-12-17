autosize($('.m_comment_list textarea'));


var m_comment_list = {};



m_comment_list.watch = function() {
	'use strict';

	$('.m_comment_list .commentAction').click(function() {
		alert(1);
	});
};



m_comment_list.validate = function() {
	'use strict';
	var errorText = '';
	var commentDate = '';
	var commentText = '';


	$.each($('.m_comment_list tbody tr'), function( index, value ) {
	  commentDate = $(this).find('.commentDate input').val();
	  commentText = $(this).find('.commentText textarea').val();
	  console.log(commentDate);
	  if (commentDate.length === 0  &&  commentText.length > 0) {
			errorText += "<li>Comment date is blank but comment text isn't.</li>";
		} else if (commentDate.length > 0  &&  commentText.length === 0) {
			errorText += "<li>Comment text is blank but comment date isn't.</li>";
		} else if (commentDate.length > 0  &&  !isValidDate(commentDate)) {
			errorText += "<li>Invalid comment date: " + commentDate + ".</li>";
		}

	});


	return errorText;
};



m_comment_list.parse = function() {
	'use strict';
	var arr = [];
	var class = '';
	var comment_seq = '';
	var commentDate = '';
	var commentText = '';
	var i = 0;


	$.each($('.m_comment_list tbody tr'), function( index, value ) {
		class = $(this).attr("class").match(/comment-[\w-]*\b/)[0];
		comment_seq = class.substring(8, class.length);
		commentDate = $(this).find('.commentDate input').val();
		commentText = $(this).find('.commentText textarea').val();

		if ( $.trim(commentDate) !== ''  &&  $.trim(commentText) !== '' ) {
			arr[i] = [];
		  arr[i][0] = comment_seq;
		  arr[i][1] = prepForSQL(commentDate, 'date');
		  arr[i][2] = prepForSQL(commentText);

		  i += 1;
		}
	});


	return arr;
};



m_comment_list.deleteComment = function(target) {
	'use strict';

	BootstrapDialog.confirm({
			title: '<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;&nbsp;Warning',
			type: BootstrapDialog.TYPE_WARNING,
			message: '<h3 style="text-align:center;">This will delete the comment. \n \nAre you sure?</h3>',
      closable: false,
      callback: function(result) {
        if(result) {
        	clearComment();
        } else {

        }
      }
		});

	

	function clearComment() {
		$('.' + target + ' input').val('');
		$('.' + target + ' textarea').val('');
		$('.' + target).remove();

		if ($('.m_comment_list tbody tr').length === 0) {
			$('.m_comment_list .content').html('<div style=\"text-align:center; padding:10px;\">No comments found</div>');
		}
	}
};




$( document ).ready(function() {
    m_comment_list.watch();
});