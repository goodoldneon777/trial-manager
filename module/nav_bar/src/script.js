$( document ).ready(function() {
  var url = window.location.href;
  var page = url.substr(url.lastIndexOf('/') + 1);



  if (page.lastIndexOf('.php') >= 0) {
  	page = page.substr(0, page.lastIndexOf('.php'));
  } else if (page.lastIndexOf('?') >= 0) {
  	page = page.substr(0, page.lastIndexOf('?'));
  } else {

  	page = page.substr(0);
  }


  switch (page) {
    case '':
      $('.m_nav_bar .recent').addClass('active');
      break;
    case 'index':
      $('.m_nav_bar .recent').addClass('active');
      break;
    case 'recent':
      $('.m_nav_bar .recent').addClass('active');
      break;
    case 'search':
      $('.m_nav_bar .search').addClass('active');
      break;
    case 'lookup':
      $('.m_nav_bar .lookup').addClass('active');
      break;
    case 'create':
      $('.m_nav_bar .create').addClass('active');
      break;
    default:
      break;
  }
});