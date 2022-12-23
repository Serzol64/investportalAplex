$(document).ready(function(){
  var tematic = $('#investors-list > .header .inv li'),
	  currentAd = $('#investors-list > .body aside div:nth-child(3) a');
 
  $(window).resize(function(){ $('#investors-list').height(($('.main').height() - $('#investors-list').height()) * 2); });
  $(window).resize();
  
  currentAd.click(function(event) {
	  event.preventDefault();
	  this.blur();
	  $.get(this.href, function(html) {
		$(html).appendTo('body').modal();
	  });
  });
  
   let queryObject = [{}, {}, {}];
	  var investForm = [
		new FormData(),
		new FormData(),
		new FormData()
	  ];
  
  tematic.click(function(e,t){
	findDataLoading(false);
	var searchQueryHead = {};
    var currentT = tematic.eq($(this).index());
    
    if(currentT.hasClass('selected')){
		currentT.removeClass('selected');
		
		if($('#investors-list > .footer ul li select option:selected').val() !== 'all'){ searchQueryHead.type = $('#investors-list > .footer ul li select option:selected').val(); }
		if($('#investors-list > .footer ul li input').eq(1).val()){ searchQueryHead.activityTo = $('#investors-list > .footer ul li input').eq(1).val(); }
		if($('#investors-list > .footer ul li input').eq(0).val()){ searchQueryHead.date = $('#investors-list > .footer ul li input').eq(0).val(); }
		  
		queryObject[2] = searchQueryHead;
		  
		investForm[2].append('svcQuery', JSON.stringify(queryObject[2]));
		  
		  fetch('/investors/api/get?service=find', { method: 'POST', body: investForm[2] })
			.then((response) => {
				if(response.status === 200){
					return response.json();
				}
				else{ alert('Results not found!'); }
			})
			.then((data) => {
				let resultAppend = '';
				
				data.map((result) => {
					resultAppend += '<aside><div>' + result.title + '</div><div>' + result.description + '</div><div><i>' + result.date + '</i><a href="/investors/' + result.id + '" data-modal="modal:open">Read more</a></div></aside>\n';
				});
				
				$('#investors-list > .body').html(resultAppend);
				findDataLoading(true);
			});
	}
    else{
		tematic.removeClass('selected');
		currentT.addClass('selected');
		
		if($('#investors-list > .footer ul li select option:selected').val() !== 'all'){ searchQueryHead.type = $('#investors-list > .footer ul li select option:selected').val(); }
		if($('#investors-list > .footer ul li input').eq(1).val()){ searchQueryHead.activityTo = $('#investors-list > .footer ul li input').eq(1).val(); }
		if($('#investors-list > .footer ul li input').eq(0).val()){ searchQueryHead.date = $('#investors-list > .footer ul li input').eq(0).val(); }
		  
		searchQueryHead.region = currentT.data('region');
		queryObject[2] = searchQueryHead;
		  
		investForm[2].append('svcQuery', JSON.stringify(queryObject[2]));
		  
		  fetch('/investors/api/get?service=find', { method: 'POST', body: investForm[2] })
			.then((response) => {
				if(response.status === 200){
					return response.json();
				}
				else{ alert('Results not found!'); }
			})
			.then((data) => {
				let resultAppend = '';
				
				data.map((result) => {
					resultAppend += '<aside><div>' + result.title + '</div><div>' + result.description + '</div><div><i>' + result.date + '</i><a href="/investors/' + result.id + '" data-modal="modal:open">Read more</a></div></aside>\n';
				});
				
				$('#investors-list > .body').html(resultAppend);
			});
	}
    
  });
  
  $('.new-ad-form-modal-data > #header a').click(function(e,t){
	  e.preventDefault();
	
	  let nfsEl = [$('.new-ad-form-modal-data > #header a'), $('.new-ad-form-modal-data > #content ul li')];
	  
	  for(let i = 0; i < nfsEl.length; i++){
		  nfsEl[i].removeClass('modal-active');
		  nfsEl[i].eq($(this).index()).addClass('modal-active');
	  }
  });
  
  $('.new-ad-form-modal-data[data-endpoint=\'search\'] > #footer button').click(function(e,t){
	   let endpointCodeSearch = '/investors/api/post?service=send&subService=search';
		   contentSearch = {},
		   metaSearch = {},
		   contactSearch = {};
		  
	   metaSearch = {
			title: $('input#titleSearch').val(),
			country: $('select#regionSearch option:selected').val()
	   };
		  
	   contentSearch = {
			 parameters: {
				  target: $('input#needI').val(),
				  purpose: $('input#existence').val(),
				  solved: $('input#problem').val(),
				  competitors: $('textarea#competitors').val(),
				  implementation: $('input#implementation').val()
			 },
			 data: {
				  content: $('textarea#contentSearch').val()
			 } 
	   };
		  
	   contactSearch = {
			  activity: $('input#activitySearchTo').val(),
			  data: {
				  user: $('input#contactSearchName').val(),
				  phone: $('input#contactSearchPhone').val(),
			      mail: $('input#contactSearchMail').val()
			  }
	   };
	   
	   queryObject[1] = {
		  header: metaSearch,
		  body: contentSearch,
		  footer: contactSearch
	   };
	  
	   investForm[1].append('svcQuery', JSON.stringify(queryObject[1]));
	  
	   fetch(endpointCodeSearch, { method: 'POST', body: investForm[1] })
		.then((response) => { if(response.ok){ window.location.reload(true); } })
		.catch(() => { alert('Failed to send data! Try again later...'); });
  });
  $('.new-ad-form-modal-data[data-endpoint=\'offer\'] > #footer button').click(function(e,t){
	  let endpointCode = '/investors/api/post?service=send&subService=offer';
		  content = {},
		  meta = {},
		  contact = {};
		  
	 
     meta = {
			  title: $('input#title').val(),
			  country: $('select#region option:selected').val()
	 };
		  
	 content = {
			  parameters: {
				  payback: $('input#period').val(),
				  amount: $('input#amount').val()
			  },
			  data: {
				  content: $('textarea#content').val()
			  }
	  };
		  
	  contact = {
			  activity: $('input#activityTo').val(),
			  data: {
				  user: $('input#contactName').val(),
				  phone: $('input#contactPhone').val(),
			      mail: $('input#contactMail').val()
			  }
	  };
	  
	  queryObject[0] = {
		  header: meta,
		  body: content,
		  footer: contact
	  };
	  
	  investForm[0].append('svcQuery', JSON.stringify(queryObject[0]));
	  
	  fetch(endpointCode, { method: 'POST', body: investForm[0] })
		.then((response) => { if(response.ok){ window.location.reload(true); } })
		.catch(() => { alert('Failed to send data! Try again later...'); });
	  
  });
  $('#investors-list > .footer ul li button').click(function(e,t){
	  findDataLoading(false);
	  $('#investors-list > .body').html('');
	  let searchQuery = {};
	  
	  if($('#investors-list > .footer ul li select option:selected').val() !== 'all'){ searchQuery.type = $('#investors-list > .footer ul li select option:selected').val(); }
	  if($('#investors-list > .footer ul li input').eq(1).val()){ searchQuery.activityTo = $('#investors-list > .footer ul li input').eq(1).val(); }
	  if($('#investors-list > .footer ul li input').eq(0).val()){ searchQuery.date = $('#investors-list > .footer ul li input').eq(0).val(); }
	  
	  queryObject[1] = searchQuery;
	  
	  investForm[1].append('svcQuery', JSON.stringify(queryObject[1]));
	  
	  fetch('/investors/api/get?service=find', { method: 'POST', body: investForm[1] })
		.then((response) => {
			if(response.status === 200){
				return response.json();
			}
			else{ alert('Results not found!'); }
		})
		.then((data) => {
			let resultAppend = '';
			
			data.map((result) => {
				resultAppend += '<aside><div>' + result.title + '</div><div>' + result.description + '</div><div><i>' + result.date + '</i><a href="/investors/' + result.id + ' data-modal="modal:open">Read more</a></div></aside>\n';
			});
			
			$('#investors-list > .body').html(resultAppend);
			findDataLoading(true);
		});
  });
});
function findDataLoading(state){
	var loadingUI = new Loading({
		loadingBgColor: '#ffffff',
		loadingAnimation: 'image',
		animationSrc: '/images/icons/loading.gif',
		defaultApply: true
	});
	
	if(state){ loadingUI.out(); }
}
