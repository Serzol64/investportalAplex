var host;
if (location.hostname === "investportal.aplex") { host = "http://investportal.aplex"; }
else { host = "https://investportal.aplex.ru"; }

$(document).ready(function(){
  $('#service-page > .svcFooter ul li #question').click(function(e,t){
    let curQ = $('#service-page > .svcFooter ul li #question').eq($(this).index()),
        curA = $('#service-page > .svcFooter ul li #answer').eq($(this).index());
    
    if(!curA.is('.faq-answer-close')){
      curQ.removeClass('faq-answer-active');
      curA.addClass('faq-answer-close');
    }
    else{
      curQ.addClass('faq-answer-active');
      curA.removeClass('faq-answer-close');
    }
  });
  
  $(".svcMeta > *[data-group='metaData'] *[data-block='form'] button").click(function(e,t){ 
	  let buttonQuery = [
			$(this).text().trim(),
			$(this).data('svclink')
	      ],
		  buttonStatus = [
			'Using this is service' === buttonQuery[0] ? true : false,
			'Form not avaliabllity in service' === buttonQuery[0] ? true : false,
			'Using this is service(Beta)' === buttonQuery[0] ? true : false,
			'Sign in for service using(Beta)' === buttonQuery[0] ? true : false,
			'Sign in for service using' === buttonQuery[0] ? true : false
		  ];
	 if(buttonStatus[0] || buttonStatus[2]){ window.location.assign('/services/' + document.URL.split(host + '/services/')[1] + '/form'); }
	 else if(buttonStatus[3] || buttonStatus[4]){ $('.header > #header_bottom .hb_bottom header .header-informer footer .user-services a, .header > #header_bottom_adaptive header ul.adaptive-buttons li:nth-last-child(2)').trigger('click'); }
	 else if(buttonStatus[1]){
		 $.alert({
			 title: 'The form for using this service is completely or partially unavailable!',
			 content: 'For now, you will be able to study partially updated information about this service while we develop a form for it. When we launch it, we will inform you about it, waiting from or up to 6 months before the final stage of its development!'
		 });
	 }
		  
	  
  });
  
  $('').click(function(e,t){ 
	  
  });
});
