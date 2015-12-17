autosize($('.m_comment_list textarea'));


var m_comment_list = {};



m_comment_list.watch = function() {
	'use strict';


	$('.m_comment_list').on("click", ".actions .delete", function(){
		m_comment_list.deleteClick($(this));
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
	var seq = '';
	var commentDate = '';
	var commentText = '';
	var i = 0;


	$.each($('.m_comment_list tbody tr'), function( index, value ) {
		// class = $(this).attr("class").match(/comment-[\w-]*\b/)[0];
		// comment_seq = class.substring(8, class.length);
		seq = getSeqFromAttrClass($(this).attr("class")).seq;
		commentDate = $(this).find('.commentDate input').val();
		commentText = $(this).find('.commentText textarea').val();

		if ( $.trim(commentDate) !== ''  &&  $.trim(commentText) !== '' ) {
			arr[i] = [];
		  arr[i][0] = seq;
		  arr[i][1] = prepForSQL(commentDate, 'date');
		  arr[i][2] = prepForSQL(commentText);

		  i += 1;
		}
	});


	return arr;
};



m_comment_list.deleteClick = function(elem) {
	'use strict';
	var classSeq = getSeqFromAttrClass(elem.closest('tr').attr('class')).classSeq;

	BootstrapDialog.confirm({
			title: '<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;&nbsp;Warning',
			type: BootstrapDialog.TYPE_WARNING,
			message: '<h2 style="text-align:center;">Are you sure?</h2>\n\nThis will permanently delete the comment when you click the \'Update\' button.',
      closable: false,
      callback: function(result) {
        if(result) {
        	deleteComment(classSeq);
        } else {

        }
      }
		});

	

	function deleteComment(classSeq) {
		var html = '';

		$('.m_comment_list .' + classSeq).remove();

		if ($('.m_comment_list tbody tr').length === 0) {
			html = '<tr class="noResults"><td colspan="3">No comments found</td></tr>';
			$('.m_comment_list tbody').html(html);
		}

	}
};




$( document ).ready(function() {
    m_comment_list.watch();
});