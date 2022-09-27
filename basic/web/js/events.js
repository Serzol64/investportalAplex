$(document).ready(function(){
<<<<<<< HEAD
   var sq = [new FormData(), new FormData()],
	   sqr = [{}, {}];
  
  $('#events-search > .content select, #period > li input').change(function(){ 
	  $('.load-screen-services').removeClass('list-smart-close'); 
	  $('.slider').html('');
  });
  
  $('#events-search > .content select').change(function(e,t){
	  let currentField = $(this).attr('name'),
		  childrenField = [
			$('#period > li input[data-pm=\'from\']').val(),
			$('#period > li input[data-pm=\'to\']').val()
		  ],
		  queryReady = {},
		  periodReady = { period: {} };
	  
	  if(currentField === 'eventRegion'){ Object.assign(queryReady, { region: $(this).val() }); }
	  else if(currentField === 'eventType'){ Object.assign(queryReady, { type: $(this).val() }); }
	  else if(currentField === 'eventCategory'){ Object.assign(queryReady, { tematic: $(this).val() }); }
	  
	  if(childrenField[1]){ Object.assign(periodReady, { from: childrenField[1] }); }
	  if(childrenField[0]){ Object.assign(periodReady, { to: childrenField[0] }); }
	  
	  Object.assign(sqr[0], { service: 'eventsFind', query: { search: queryReady }});
	  
	  if((childrenField[0] && childrenField[1]) || (childrenField[0] || childrenField[1])){ Object.assign(sqr[0].query.search, periodReady); }
	  
	  sq[0].append('svcQuery', JSON.stringify(sqr[0]));
	  
	  fetch('events/api/get', { method: 'GET', body: sq[0] })
		.then(response => response.json())
		.then((data) => {
			data.map((response) => {
				var content = response.location !== '' ? '<span data-type="location">{response.location}</span>' : '',
					readyDescription = response.content.matchAll(/<p[^>]*>(([^>]|.)*?)<\/p>/ug);
				content += '<span data-type="description">' + readyDescription[1][0].length > 234 ? mb_strimwidth(readyDescription[1][0], 0, 234, '...') : readyDescription[1][0] + '</span>';
				
				var dateFormat = [
					moment(response.date_from, 'd/m/Y'),
					moment(response.date_to, 'd/m/Y')
				];
				
				var eventCard = '<span id="date">' + response.date_to ? dateFormat.join(' - ') : dateFormat[0] + '</span><img src="{response.titleImage}" alt="{response.title}" />';
				eventCard += '<span id="title">{response.title}</span><p>{content}</p><a href="/events/{response.id}">Show more</a>';
				
				$('.slider').append('<li>${eventCard}</li>');
			});
			$('.load-screen-services').addClass('list-smart-close');
		})
		.catch(() => { $('.load-screen-services').addClass('list-smart-close'); });
  });
  $('#period > li input').change(function(e,t){
	  let currentField = $(this).data('pm'),
		  childrenField = [
			$('#events-search > .content select[name=\'eventRegion\']').val(),
			$('#events-search > .content select[name=\'eventType\']').val(),
			$('#events-search > .content select[name=\'eventCategory\']').val()
		  ],
		  queryReady = { period: {} };
	  
	  
	  if(currentField === 'from'){ Object.assign(queryReady.period, { from: $(this).val() }); }
	  else if(currentField === 'to'){ Object.assign(queryReady.period, { to: $(this).val() }); }
	  
	  if(childrenField[2]){ Object.assign(queryReady, { tematic: childrenField[2] }); }
	  if(childrenField[0]){ Object.assign(queryReady, { region: childrenField[0] }); }
	  if(childrenField[1]){ Object.assign(queryReady, { type: childrenField[1] }); }
	  
	  Object.assign(sqr[1], { service: 'eventsFind', query: { search: queryReady }});
	  
	  sq[1].append('svcQuery', JSON.stringify(sqr[1]));
	  
	  fetch('events/api/get', { method: 'GET', body: sq[1] })
		.then(response => response.json())
		.then((data) => {
			data.map((response) => {
				var content = response.location !== '' ? '<span data-type="location">{response.location}</span>' : '',
					readyDescription = response.content.matchAll(/<p[^>]*>(([^>]|.)*?)<\/p>/ug);
				content += '<span data-type="description">' + readyDescription[1][0].length > 234 ? mb_strimwidth(readyDescription[1][0], 0, 234, '...') : readyDescription[1][0] + '</span>';
				
				var dateFormat = [
					moment(response.date_from, 'd/m/Y'),
					moment(response.date_to, 'd/m/Y')
				];
				
				var eventCard = '<span id="date">' + response.date_to ? dateFormat.join(' - ') : dateFormat[0] + '</span><img src="{response.titleImage}" alt="{response.title}" />';
				eventCard += '<span id="title">{response.title}</span><p>{content}</p><a href="/events/{response.id}">Show more</a>';
				
				$('.slider').append('<li>${eventCard}</li>');
			});
			$('.load-screen-services').addClass('list-smart-close');
		})
		.catch(() => { $('.load-screen-services').addClass('list-smart-close'); });
  });
=======
  
>>>>>>> parent of 14e5f573 (98.05% Countine)
});
