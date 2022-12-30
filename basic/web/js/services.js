const regionAutoList = () => {
	if($('.newSVCFormContent > ul li select#country option:selected').val() !== 'any'){
		var regionCont = $('.newSVCFormContent > ul li select#region'),
			rdbq = new FormData();
		
		rdbq.append('country', $('.newSVCFormContent > ul li select#country option:selected').val());
		
		fetch('/services/api/0/post', { method: 'POST', body: rdbq })
			.then(response => response.json())
			.then((data) => {
				regionCont.html('');
				regionCont.append('<option value="any">All Regions</option>');
				
				for(let i = 0; i < data.length; i++){ regionCont.append('<option value="' + data[i]['id'] + '">' + data[i]['region'] + '</option>'); }
				
				if(regionCont.prop('disabled')){ regionCont.prop('disabled', false); }
			});
	}
	else{ regionCont.prop('disabled', true); }
}


$(document).ready(function(){
  $('.categories > a').eq(0).addClass('active-category');
  
  $('.categories > a').click(function(e, t){
    e.preventDefault();
    
    var currentC = $('.categories > a').eq($(this).index()),
		category = currentC.data('cat'),
		sfd = new FormData();
    
    $('.categories > a').removeClass('active-category');
    currentC.addClass('active-category');
    
    sfd.append('categoryId', category);
    
    $('main#list > ul').html('');
    
	$('.load-screen-services').removeClass('list-smart-close');
	$('.not-found-data, main#list > ul').addClass('list-smart-close');
    
    
    
    fetch('/services/api/4/post', { method: 'POST', body: sfd })
		.then(response => response.json())
		.then((data) => {
			let listResponse = '';
			data.map(res => listResponse += '<li><a href="/services/${res.id}">${res.title}</a></li>');
			
			$('main#list > ul').html(listResponse);
			window.setTimeout(function(){ 
				$('.load-screen-services').addClass('list-smart-close');
				$('main#list > ul').removeClass('list-smart-close'); 
			}, 2500);
		})
		.catch((error) => {
			window.setTimeout(function(){ 
				$('.load-screen-services').addClass('list-smart-close');
				$('.not-found-data').removeClass('list-smart-close'); 
			}, 2500); 
		});
  });
  
  $('.last-example > #exmpl').click(function(e, t){
    var searchEl = $('header#search > input'),
        currentV = $(this).text();
    
    searchEl.val(currentV);
  });
  
  $('.newServiceForm > div[data-modalpart=\'content\'] footer#formUI button').click(function(e,t){
	  var offerQuery = new FormData();
	  let sendQuery = {
			  title: $('.newSVCFormContent > ul li:eq(0) *:nth-last-child(1)').val(),
			  meta: {
				isOffer: true,
				seoData: {
					categoryId: $('.newSVCFormContent > ul li:eq(2) *:nth-last-child(1)').val(),
					country: $('.newSVCFormContent > ul li:eq(3) *:nth-last-child(1)').val(),
					region: $('.newSVCFormContent > ul li:eq(4) *:nth-last-child(1)').val(),
					logo: $('.newSVCFormContent > ul li:nth-child(2) label input').data('logo'),
					parameters: {
						description: $('.SVCData > li:eq(0) textarea').val(),
						information: $('.SVCData > li:eq(1) textarea').val(),
					}
				}
			  },
			  content: {
				  data: {
					  priceList: $('.SVCData > li:eq(2) textarea').val(),
					  advantages: $('.SVCData > li:eq(3) textarea').val(),
					  disadvantages: $('.SVCData > li:eq(4) textarea').val(),
					  privelegies: $('.SVCData > li:eq(5) textarea').val(),
					  infrastructure: $('.SVCData > li:eq(6) textarea').val(),
					  more: $('.SVCData > li:eq(7) textarea').val()
				  }
			  },
			  proc: {
					parameters: {
						contactName: $('.contactDataForm > li:eq(0) input').val(),
						contactPhone: $('.contactDataForm > li:eq(1) input').val(),
						contactMail: $('.contactDataForm > li:eq(2) input').val()
					}		
			  }
		  };
	 
	 offerQuery.append('svcQuery', JSON.stringify(sendQuery));
	 fetch('/services/api/2/post?o=newServiceOffer', {method: 'POST', body: offerQuery})
		.then(response => response.json())
		.then(data => window.location.assign(data.redirect))
		.catch((error) => {
			alert('The request could not be sent! Try again later...');
		});
  });
  $('.newSVCFormContent > ul li:nth-child(2) label input').change(function(e,t){
	  const file = e.target.files[0];
	
	  const reader = new FileReader();
	  reader.onloadend = () => {
		$(this).data('logo', reader.result);
	 };
	reader.readAsDataURL(file);
  });
  
  
  
  $('.newSVCFormContent > ul li select#country').change(regionAutoList);
});
