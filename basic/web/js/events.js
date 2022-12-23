$(document).ready(function(){
   var sq = [new FormData(), new FormData()],
	   sqr = [{}, {}];
  
  
  $('#events-search > .content select').change(function(e,t){
	  $('.load-screen-services').removeClass('list-smart-close'); 
	  $('.slider').html('');
	  
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
		.then(response => response.json())
		.then((data) => {
			console.log(data);
			data.map((response) => {
				var content = response.location !== '' ? '<span data-type="location">' + response.location + '</span>' : '',
					readyDescription = response.content.matchAll(/<p[^>]*>(([^>]|.)*?)<\/p>/ug);
				content += '<span data-type="description">' + readyDescription[1][0].length > 234 ? mb_strimwidth(readyDescription[1][0], 0, 234, '...') : readyDescription[1][0] + '</span>';
				
				var dateFormat = [
					moment(response.date_from, 'd/m/Y'),
					moment(response.date_to, 'd/m/Y')
				];
				
				var eventCard = '<span id="date">' + response.date_to ? dateFormat.join(' - ') : dateFormat[0] + '</span><img src="' + response.titleImage + '" alt="' + response.title + '" />';
				eventCard += '<span id="title">' + response.title + '</span><p>{content}</p><a href="/events/' + response.id + '">Show more</a>';
				
				$('.slider').append('<li>' + eventCard + '</li>');
			});
			$('.load-screen-services').addClass('list-smart-close');
		})
		.catch(() => { $('.load-screen-services').addClass('list-smart-close'); });
  });
  $('#period > li input').change(function(e,t){
	  $('.load-screen-services').removeClass('list-smart-close'); 
	  $('.slider').html('');
	  
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
		.then(response => response.json())
		.then((data) => {
			console.log(data);
			data.map((response) => {
				var content = response.location !== '' ? '<span data-type="location">' + response.location + '</span>' : '',
					readyDescription = response.content.matchAll(/<p[^>]*>(([^>]|.)*?)<\/p>/ug);
				content += '<span data-type="description">' + readyDescription[1][0].length > 234 ? mb_strimwidth(readyDescription[1][0], 0, 234, '...') : readyDescription[1][0] + '</span>';
				
				var dateFormat = [
					moment(response.date_from, 'd/m/Y'),
					moment(response.date_to, 'd/m/Y')
				];
				
				var eventCard = '<span id="date">' + response.date_to ? dateFormat.join(' - ') : dateFormat[0] + '</span><img src="' + response.titleImage + '" alt="' + response.title + '" />';
				eventCard += '<span id="title">' + response.title + '</span><p>{content}</p><a href="/events/' + response.id + '">Show more</a>';
				
				$('.slider').append('<li>' + eventCard + '</li>');
			});
			$('.load-screen-services').addClass('list-smart-close');
		})
		.catch(() => { $('.load-screen-services').addClass('list-smart-close'); });
  });
});
