autosize($('.m_comment_list textarea'));
autosize($('.c_commentInput'));


var m_comment_list = {};



m_comment_list.watch = function() {
	'use strict';


	$('.m_comment_list').on("click", ".actions .delete", function(){
		m_comment_list.deleteClick($(this));
	});

	$('.m_comment_list .addCommentBtn').click(function(){
		m_comment_list.addClick();
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
	var oldArr = [];
	var newArr = [];
	var classSeq = '';
	var seq = '';
	var commentDate = '';
	var commentText = '';
	var i = 0;


	i = 0;
	$.each($('.m_comment_list tbody tr'), function( index, value ) {
		classSeq = getSeqFromAttrClass($(this).attr("class")).classSeq;

		//If this row has an "old" comment.
		if (classSeq.indexOf('seq-') === 0) {
			seq = getSeqFromAttrClass($(this).attr("class")).seq;
			commentDate = $(this).find('.commentDate input').val();
			commentText = $(this).find('.commentText textarea').val();

			if ( $.trim(commentDate) !== ''  &&  $.trim(commentText) !== '' ) {
				oldArr[i] = [];
			  oldArr[i][0] = seq;
			  oldArr[i][1] = prepForSQL(commentDate, 'date');
			  oldArr[i][2] = prepForSQL(commentText);

			  i += 1;
			}
		}

	});


	i = 0;
	$.each($('.m_comment_list tbody tr'), function( index, value ) {
		//If this row has an "old" comment.
		if ($(this).attr("class").indexOf('new') === 0) {
			commentDate = $(this).find('.commentDate input').val();
			commentText = $(this).find('.commentText textarea').val();

			if ( $.trim(commentDate) !== ''  &&  $.trim(commentText) !== '' ) {
				newArr[i] = [];
			  newArr[i][0] = i + 1;
			  newArr[i][1] = prepForSQL(commentDate, 'date');
			  newArr[i][2] = prepForSQL(commentText);

			  i += 1;
			}
		}
	});


	var obj = {
		oldArr: oldArr,
		newArr: newArr
	};

	return obj;
};



m_comment_list.deleteClick = function(elem) {
	'use strict';
	elem = elem.closest('tr');


	BootstrapDialog.confirm({
		title: '<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;&nbsp;Warning',
		type: BootstrapDialog.TYPE_WARNING,
		message: '<h2 style="text-align:center;">Are you sure?</h2>\n\nThis will permanently delete the comment when you click the \'Update\' button.',
    closable: false,
    callback: function(result) {
      if(result) {
      	deleteComment(elem);
      } else {

      }
    }
	});

	

	function deleteComment(elem) {
		var html = '';

		elem.remove();

		if ($('.m_comment_list tbody tr').length === 0) {
			html = '<tr class="noResults"><td colspan="3">No comments found</td></tr>';
			$('.m_comment_list tbody').html(html);
		}

	}
};



m_comment_list.addClick = function() {
	'use strict';
	var comment = '';
	var msg = 
		'<textarea class="c_commentAdd form-control" rows="4" style="resize:none;"></textarea>' +
		'<script>autosize($(\'.c_commentInput\'));</script>';


	BootstrapDialog.show({
		title: '<span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>&nbsp;&nbsp;Input Comment',
    message: msg,
    buttons: [
    	{
	      label: 'Close',
	      action: function(dialogRef) {
	        dialogRef.close();
	      }
	    },
	    {
	      label: 'Add',
        cssClass: 'btn-primary',
	      action: function(dialogRef) {
	        comment = dialogRef.getModalBody().find('textarea').val();
    			addToTable(comment);
    			dialogRef.close();
	      }
	    }
	   ]
  });


  function addToTable(comment) {
  	var nowDT = moment().format('M/D/YYYY HH:mm');
  	var newRow = 
  		'<tr class="new">' +
  		'  <td class=\"commentDate\">' +
	    '    <div class=\"input-group noPad-xs\">' +
	    '      <input class=\"form-control\" rows=\"1\" value=\"' + nowDT + '\">' +
	    '    </div>' +
	    '  </td>' +
			'  <td class=\"commentText\">' +
	    '    <div class=\"input-group noPad-xs\">' +
	    '      <textarea class=\"form-control\" rows=\"1\">' + comment + '</textarea>' +
	    '    </div>' +
	    '  </td>' +
			'  <td class=\"actions\">' +
	    '    <div class=\"noPad-xs\">' +
	    '      <a href=\"javascript: void(0)\" class=\"delete\">Delete</a>' +
	    '    </div>' +
	    '  </td>' +
	    '</tr>';

	  if ($('.m_comment_list table .noResults').length === 0) {
		  var oldBody = $('.m_comment_list table tbody').html();
		  $('.m_comment_list table tbody').html(newRow + oldBody);
		} else {
			$('.m_comment_list table tbody').html(newRow);
		}

	  autosize($('.m_comment_list textarea'));
  }
};





$( document ).ready(function() {
    m_comment_list.watch();
});







