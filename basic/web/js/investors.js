$(document).ready(function(){
  var tematic = $('#investors-list > .header .inv li'),
	  currentAd = $('#investors-list > .body aside div:nth-child(3) a');
 
  $(window).resize(function(){ $('#investors-list').height(($('.main').height() - $('#investors-list').height()) * 2); });
  $(window).resize();
  
  $('.modal').css('max-width', '100%').height(567);
  
  currentAd.click(function(event) {
	  event.preventDefault();
	  this.blur();
	  $.get(this.href, function(html) {
		$(html).appendTo('body').modal();
	  });
  });
  
  tematic.click(function(e,t){
    var currentT = tematic.eq($(this).index());
    
    tematic.removeClass('selected');
    currentT.addClass('selected');
    
  });
  
  $('.new-ad-form-modal-data > #header a').click(function(e,t){
	  e.preventDefault();
	
	  let nfsEl = [$('.new-ad-form-modal-data > #header a'), $('.new-ad-form-modal-data > #content ul li')];
	  
	  for(let i = 0; i < nfsEl.length; i++){
		  nfsEl[i].removeClass('modal-active');
		  nfsEl[i].eq($(this).index()).addClass('modal-active');
	  }
  });
  
  let queryObject = [{}, {}];
  var investForm = [
	new FormData(),
	new FormData()
  ];
  
  $('.new-ad-form-modal-data > #footer button').click(function(e,t){
	  let endpointName = $('.new-ad-form-modal-data > #content ul li.modal-active section.form').data('endpoint'),
		  endpointCode = endpointName === 'search' ? '/investors/api/post?service=send&subService=search' : '/investors/api/post?service=send&subService=offer';
		  content = {};
		  
	  var meta = {
		  title: $('input#title').val(),
		  country: $('select#region option:selected').val()
	  };
	  
	  var contact = {
		  activity: $('input#activityTo, input#activitySearchTo').val(),
		  name: $('input#contactName, input#contactSearchName').val(),
		  phone: $('input#contactPhone, input#contactSearchPhone').val(),
		  mail: $('input#contactMail, input#contactSearchMail').val()
	  };
	  
	  if(endpointName === 'search'){
		  content = {
			 parameters: {
				  target: $('input#needI').val(),
				  purpose: $('input#existence').val(),
				  solved: $('input#problem').val(),
				  competitors: $('textarea#competitors').val(),
				  implementation: $('input#period').val()
			 },
			 data: {
				  content: $('textarea#contentSearch').val()
			 } 
		  };
	  }
	  else{
		  content = {
			  parameters: {
				  payback: $('input#period').val(),
				  amount: $('input#amount').val()
			  },
			  data: {
				  content: $('textarea#content').val()
			  }
		  };
	  }
	  
	  queryObject[0] = {
		  header: meta,
		  body: content,
		  footer: contact
	  };
	  
	  investForm[0].append('svcQuery', JSON.stringify(queryObject[0]));
	  
	  fetch(endpointCode, { method: 'POST', body: investForm[0] })
		.then((response) => {
			if(response.status === 200){
				$('.modal').css('display', 'none');
				window.reload(true);
			}
		})
		.catch(() => { alert('Failed to send data! Try again later...'); });
	  
  });
  $('#investors-list > .footer ul li button').click(function(e,t){
	  
	  $('#investors-list > .body').html('');
	  let searchQuery = {};
	  
	  if($('#investors-list > .footer ul li select option:selected').val() !== 'all'){ searchQuery.type = $('#investors-list > .footer ul li select option:selected').val(); }
	  if($('#investors-list > .footer ul li input').eq(1).val()){ searchQuery.activityTo = $('#investors-list > .footer ul li input').eq(1).val(); }
	  if($('#investors-list > .footer ul li input').eq(0).val()){ searchQuery.date = $('#investors-list > .footer ul li input').eq(0).val(); }
	  
	  queryObject[1] = searchQuery;
	  
	  investForm[1].append('svcQuery', JSON.stringify(queryObject[1]));
	  
	  fetch('/investors/api/get?service=find', { method: 'GET', body: investForm[1] })
		.then((response) => {
			if(response.status === 200){
				return response.json();
			}
			else{ alert('Results not found!'); }
		})
		.then((data) => {
			let resultAppend = '';
			
			data.map((result) => {
				resultAppend += '<aside><div>${result.title}</div><div>${result.description}</div><div><i>${result.date}</i><a href="${result.id}">Read more</a></div></aside>\n';
			});
			
			$('#investors-list > .body').append(resultAppend);
		});
  });
});
