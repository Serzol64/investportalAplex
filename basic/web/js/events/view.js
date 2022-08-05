$(document).ready(function(){
  $('.add-but[data-type=\'incoming\']').click(function(e,t){
    e.preventDefault();
    let getLink = 'about:blank',
		readyQuery = {
			service: '',
			query: { eventId: parseInt($(this).data('eventid')) }
		};
    var bfd = new FormData();
    
    bfd.append('svcQuery', JSON.stringify(readyQuery));
    
    fetch('/events/api/post', { method: 'POST', body: bfd)
		.then(response => response.json())
		.then((data) => { getLink = data.url; })
		.catch(() => { $('.add-but[data-type=\'incoming\']').remove(); });
    
    
    window.open(getLink, "_blank");
  });
  
  $(window).resize(function(){ $('#news').height($('.main').height() - $('#news > .news-viewer #left-content').height()); });
  $(window).resize();
});
