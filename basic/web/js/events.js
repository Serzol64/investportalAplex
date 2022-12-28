$(document).ready(function(){
   var sq = [new FormData(), new FormData()],
	   sqr = [{}, {}],
	   readyDescription = ['', ''],
	   content = ['', ''],
	   eventCard = ['', ''],
	   dateFormat = [[], []];
  
    let responseHtml = ['', ''];
  
  $('#events-search > .content select').change(function(e,t){
	  $('.load-screen-services').removeClass('list-smart-close'); 
	  $('#events-body > .events-feed main .slider').html('');
	  
	  let currentField = $(this).attr('name'),
		  childrenField = [
			$('#period > li input[data-pm=\'from\']').val(),
			$('#period > li input[data-pm=\'to\']').val()
		  ],
		  queryReady = {},
		  periodReady = { period: {} };
	  
	  if(currentField === 'eventRegion'){ queryReady.region = $(this).val(); }
	  else if(currentField === 'eventType'){ queryReady.type = $(this).val(); }
	  else if(currentField === 'eventCategory'){ queryReady.tematic = $(this).val(); }
	  
	  if(childrenField[1]){ periodReady.period.from = childrenField[1]; }
	  if(childrenField[0]){ periodReady.period.to = childrenField[0]; }
	  
	  sqr[0].service = 'eventsFind';
	  sqr[0].query = { search: queryReady };
	  
	  if((childrenField[0] && childrenField[1]) || (childrenField[0] || childrenField[1])){ sqr[0].query.search = periodReady; }
	  
	  sq[0].append('svcQuery', JSON.stringify(sqr[0]));
	  
	  fetch('/events/api/get', { method: 'POST', body: sq[0] })
		.then(response => response[index].json())
		.then((data) => {
			console.log(data);
			
			data.forEach((response, index) => {
					content[0] = response[index].location !== '' ? '<span data-type="location">' + response[index].location + '</span>' : '';
					readyDescription[0] = response[index].content.matchAll(/<p[^>]*>(([^>]|.)*?)<\/p>/ug);
					content[0] += '<span data-type="description">' + readyDescription[0][1][0].length > 234 ? mb_strimwidth(readyDescription[0][1][0], 0, 234, '...') : readyDescription[0][1][0] + '</span>';
					
					dateFormat[0] = [
						moment(response[index].date_from, 'd/m/Y'),
						moment(response[index].date_to, 'd/m/Y')
					];
					
					eventCard[0] = '<span id="date">' + response[index].date_to ? dateFormat[0].join(' - ') : dateFormat[0][0] + '</span><img src="' + response[index].titleImage + '" alt="' + response[index].title + '" />';
					eventCard[0] += '<span id="title">' + response[index].title + '</span><p>' + content[0] + '</p><a href="/events/' + response[index].id + '">Show more</a>';
			
					responseHtml[0] += '<li>' + eventCard[0] + '</li>';
			});
			$('#events-body > .events-feed main .slider').html(responseHtml[0]);
			$('.load-screen-services').addClass('list-smart-close');
		})
		.catch(() => { $('.load-screen-services').addClass('list-smart-close'); });
  });
  $('#period > li input').change(function(e,t){
	  $('.load-screen-services').removeClass('list-smart-close'); 
	  $('#events-body > .events-feed main .slider').html('');
	  
	  let currentField = $(this).data('pm'),
		  childrenField = [
			$('#events-search > .content select[name=\'eventRegion\']').val(),
			$('#events-search > .content select[name=\'eventType\']').val(),
			$('#events-search > .content select[name=\'eventCategory\']').val()
		  ],
		  queryReady = { period: {} };
	  
	  
	  if(currentField === 'from'){ queryReady.period['from'] = $(this).val(); }
	  else if(currentField === 'to'){ queryReady.period['to'] = $(this).val(); }
	  
	  if(childrenField[2]){ queryReady.tematic = childrenField[2]; }
	  if(childrenField[0]){ queryReady.region = childrenField[0]; }
	  if(childrenField[1]){ queryReady.type = childrenField[1]; }
	  
	  sqr[1].service = 'eventsFind';
	  sqr[1].query = { search: queryReady };
	  
	  sq[1].append('svcQuery', JSON.stringify(sqr[1]));
	  
	  fetch('/events/api/get', { method: 'POST', body: sq[1] })
		.then(response => response[index].json())
		.then((data) => {
			console.log(data);
			
			data.forEach((response, index) => {
					content[1] = response[index].location !== '' ? '<span data-type="location">' + response[index].location + '</span>' : '';
					readyDescription[1] = response[index].content.matchAll(/<p[^>]*>(([^>]|.)*?)<\/p>/ug);
					content[1] += '<span data-type="description">' + readyDescription[1][1][0].length > 234 ? mb_strimwidth(readyDescription[1][1][0], 0, 234, '...') : readyDescription[1][1][0] + '</span>';
					
					dateFormat[1] = [
						moment(response[index].date_from, 'd/m/Y'),
						moment(response[index].date_to, 'd/m/Y')
					];
					
					eventCard[1] += '<span id="date">' + response[index].date_to ? dateFormat[1].join(' - ') : dateFormat[1][0] + '</span><img src="' + response[index].titleImage + '" alt="' + response[index].title + '" />';
					eventCard[1] += '<span id="title">' + response[index].title + '</span><p>' + content[1] + '</p><a href="/events/' + response[index].id + '">Show more</a>';
			
					responseHtml[1] += '<li>' + eventCard[1] + '</li>';
			});
			$('#events-body > .events-feed main .slider').html(responseHtml[1]);
			$('.load-screen-services').addClass('list-smart-close');
		})
		.catch(() => { $('.load-screen-services').addClass('list-smart-close'); });
  });
});
