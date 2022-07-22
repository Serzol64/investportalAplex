$(document).ready(function(){
  var tematic = $('.tematic > li');
  tematic.click(function(e,t){
    var currentT = tematic.eq($(this).index()),
		currentCategory = currentT.text(),
		uid = new FormData();
		
	let categoryFeedQuery = {
		service: 'categoryLastNews',
		query: { name: currentCategory }
	};
	
	uid.append('svcQuery', JSON.stringify(categoryFeedQuery));
    
    tematic.removeClass('selected');
    currentT.addClass('selected');
    
    $('.news-feed > footer #down-feed .down-feed-cont #cont-content').html('<div class="load-screen-services"> <img src="/images/icons/loading.gif" /> <span>Please wait... <br />The process of processing the search query is underway</span></div>');
    
    fetch('/analytics/api/get', { method: 'POST', body: uid })
		.then(response => response.json())
		.then((data) => {
			let l = '',
				pl = '',
				o = '';
				
			data.l.map((item) => { l += '<li><img src="' + item.titleImage + '" alt="' + item.title + '"><a href="/analytics/' + item.id + '">' + item.title + '</a></li>'; });
			data.pl.map((item) => { pl += '<li><img src="' + item.titleImage + '" alt="' + item.title + '"><a href="/analytics/' + item.id + '">' + item.title + '</a></li>'; });
			data.o.map((item) => { o += '<li><img src="' + item.titleImage + '" alt="' + item.title + '"><a href="/analytics/' + item.id + '">' + item.title + '</a></li>'; });
				
			$('.news-feed > footer #down-feed .down-feed-cont:nth-child(1) #cont-content').html('<ul>' + l + '</ul>');
			$('.news-feed > footer #down-feed .down-feed-cont:nth-child(2) #cont-content').html('<ul>' + pl + '</ul>');
			$('.news-feed > footer #down-feed .down-feed-cont:nth-child(3) #cont-content').html('<ul>' + o + '</ul>');
		})
		.catch(() => $('.news-feed > footer #down-feed .down-feed-cont #cont-content').html('<div class="not-found-data"> <img src="/images/icons/services/error.gif" /> <div><h3>There are no matherials in the selected category!</h3> <span>In the category you have selected, matherials from their collection on the portal are unavailable. Empty, because we have recently registered a category and the first matherials inside it will be available later or earlier.</span></div></div>'));
  });
});
