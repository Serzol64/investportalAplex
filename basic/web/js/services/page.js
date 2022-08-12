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
			'Service Form coming out' === buttonQuery[0] ? true : false,
			'Form not avaliabllity in service' === buttonQuery[0] ? true : false,
			'Using this is service(Beta)' === buttonQuery[0] ? true : false,
			'Sign in for service using(Beta)' === buttonQuery[0] ? true : false,
			'Sign in for service using' === buttonQuery[0] ? true : false
		  ];
	 if(buttonStatus[0] || buttonStatus[3]){ window.location.assign('/services/${buttonQuery[1]}/form'); }
	 else if(buttonStatus[4] || buttonStatus[5]){ $('.header > #header_bottom .hb_bottom header .header-informer footer .user-services a, .header > #header_bottom_adaptive header ul.adaptive-buttons li:nth-last-child(2)').trigger('click'); }
	 else if(buttonStatus[2]){
		 $.alert({
			 title: 'The form for using this service is completely or partially unavailable!',
			 content: 'For now, you will be able to study partially updated information about this service while we develop a form for it. When we launch it, we will inform you about it, waiting from or up to 6 months before the final stage of its development!'
		 });
	 }
	 else{
		 $.alert({
			 title: 'The service will be launched soon (if possible, temporarily in beta mode)',
			 content: 'We are in the final stage of service development!  Within 1.5 - 3 months we will try to launch it in beta mode. The mode itself will operate temporarily, but it is important for us to take into account your opinion on its revision, correction and improvement in order to improve the quality of its availability. We will not make a service for working with your ideas soon!'
		 });
	 }
		  
	  
  });
  
  $('').click(function(e,t){ 
	  
  });
});
