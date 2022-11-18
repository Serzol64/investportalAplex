$(document).ready(function(){
  var tematic = $('.tematic > li'),
	  activeTematic = $('.tematic > li.selected');
  tematic.click(function(e,t){
	  
    var currentT = tematic.eq($(this).index()),
		currentCategory = currentT.text(),
		uid = new FormData();
		
	let categoryFeedQuery = {};
		
	if(currentT.hasClass('selected')){
		categoryFeedQuery = {
			service: 'categoryLastNews',
			query: { name: currentCategory }
		};
		
		tematic.removeClass('selected');
		currentT.addClass('selected');
	}
	else{
		categoryFeedQuery = {
			service: 'lastNews'
		};
		
		tematic.removeClass('selected');
	}
	
	uid.append('svcQuery', JSON.stringify(categoryFeedQuery));
    
    $('.news-feed > footer #down-feed .down-feed-cont #cont-content').html('<div class="load-screen-services"> <img src="/images/icons/loading.gif" /> <span>Please wait... <br />The process of processing the search query is underway</span></div>');
    
    fetch('/analytics/api/get', { method: 'POST', body: uid })
		.then(response => response.json())
		.then((data) => {
			let l = '',
				pl = '',
				o = '';
				
			for(let i = 0; i < data.last.length; i++){ l += '<li><img src="' + data.last[i].titleImage + '" alt="' + data.last[i].title + '"><a href="/analytics/' + data.last[i].id + '">' + data.last[i].title + '</a></li>'; }
			
			if(data.prelast){
				for(let i = 0; i < data.prelast.length; i++){ pl += '<li><img src="' + data.prelast[i].titleImage + '" alt="' + data.prelast[i].title + '"><a href="/analytics/' + data.prelast[i].id + '">' + data.prelast[i].title + '</a></li>'; }
			}
			
			if(data.old){
				for(let i = 0; i < data.old.length; i++){ o += '<li><img src="' + data.old[i].titleImage + '" alt="' + data.old[i].title + '"><a href="/analytics/' + data.old[i].id + '">' + data.old[i].title + '</a></li>'; }
			}
			
			$('.news-feed > footer #down-feed .down-feed-cont:nth-child(1) #cont-content').html('<ul>' + l + '</ul>');
			$('.news-feed > footer #down-feed .down-feed-cont:nth-child(2) #cont-content').html('<ul>' + pl + '</ul>');
			$('.news-feed > footer #down-feed .down-feed-cont:nth-child(3) #cont-content').html('<ul>' + o + '</ul>');
		})
		.catch((error) => {
			$('.news-feed > footer #down-feed .down-feed-cont #cont-content').html('<div class="not-found-data"> <img src="/images/icons/services/error.gif" /> <div><h3>There are no matherials in the selected category!</h3> <span>In the category you have selected, matherials from their collection on the portal are unavailable. Empty, because we have recently registered a category and the first matherials inside it will be available later or earlier.</span></div></div>');
			console.log(error);
		});
  });
  
  activeTematic.click(function(e,t){
	  var uaid = new FormData();
		
		let FeedQuery = { service: 'lastNews' };
		
		uaid.append('svcQuery', JSON.stringify(FeedQuery));
		
		activeTematic.removeClass('selected');
		
		$('.news-feed > footer #down-feed .down-feed-cont #cont-content').html('<div class="load-screen-services"> <img src="/images/icons/loading.gif" /> <span>Please wait... <br />The process of processing the search query is underway</span></div>');
		
		fetch('/analytics/api/get', { method: 'POST', body: uaid })
			.then(response => response.json())
			.then((data) => {
				let la = '',
					pla = '',
					oa = '';
					
				for(let i = 0; i < data.last.length; i++){ la += '<li><img src="' + data.last[i].titleImage + '" alt="' + data.last[i].title + '"><a href="/analytics/' + data.last[i].id + '">' + data.last[i].title + '</a></li>'; }
				
				if(data.prelast){
					for(let i = 0; i < data.prelast.length; i++){ pla += '<li><img src="' + data.prelast[i].titleImage + '" alt="' + data.prelast[i].title + '"><a href="/analytics/' + data.prelast[i].id + '">' + data.prelast[i].title + '</a></li>'; }
				}
				
				if(data.old){
					for(let i = 0; i < data.old.length; i++){ oa += '<li><img src="' + data.old[i].titleImage + '" alt="' + data.old[i].title + '"><a href="/analytics/' + data.old[i].id + '">' + data.old[i].title + '</a></li>'; }
				}
				
				$('.news-feed > footer #down-feed .down-feed-cont:nth-child(1) #cont-content').html('<ul>' + la + '</ul>');
				$('.news-feed > footer #down-feed .down-feed-cont:nth-child(2) #cont-content').html('<ul>' + pla + '</ul>');
				$('.news-feed > footer #down-feed .down-feed-cont:nth-child(3) #cont-content').html('<ul>' + oa + '</ul>');
			})
			.catch((error) => {
				$('.news-feed > footer #down-feed .down-feed-cont #cont-content').html('<div class="not-found-data"> <img src="/images/icons/services/error.gif" /> <div><h3>There are no matherials in the selected category!</h3> <span>In the category you have selected, matherials from their collection on the portal are unavailable. Empty, because we have recently registered a category and the first matherials inside it will be available later or earlier.</span></div></div>');
				console.log(error);
			});
  });
});
