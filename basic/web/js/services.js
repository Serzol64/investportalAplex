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
  
  $('#newSVCForm > .newServiceForm div[data-modalpart=\'content\'] footer#formUI button, #newSVCForm > .newServiceForm div[data-modalpart=\'header\'] .formStep #step').click(function(e,t){
	  let stepList = $('#newSVCForm > .newServiceForm div[data-modalpart=\'header\'] .formStep #step, #newSVCForm > .newServiceForm div[data-modalpart=\'content\'] .formStep #step');
	  
	  for(let i = 0; i < stepList.length; i++){
		  let currentStep = stepList.eq(i).hasClass('active');
		  
		  if(e.target.nodeName === 'li'){
			  if(i === 2 && currentStep){
				  stepList.removeClass('active');
				  stepList.eq(3).addClass('active');
				  $('#newSVCForm > .newServiceForm div[data-modalpart=\'content\'] footer#formUI button').html('Finish');
			  }
			  else{
				  stepList.removeClass('active');
				  stepList.eq($(this).index()).addClass('active');
				  
				  if($('#newSVCForm > .newServiceForm div[data-modalpart=\'content\'] footer#formUI button').html() === 'Finish'){ $('#newSVCForm > .newServiceForm div[data-modalpart=\'content\'] footer#formUI *').html('Countine'); }
				  
			  }
		  }
		  else if(e.target.nodeName === 'button'){
			  if(i === 3 && currentStep){
				  stepList.removeClass('active');
				  
			  }
			  else if(i === 2 && currentStep){
				  stepList.removeClass('active');
				  $(this).text('Finish');
			  }
			  else{
				  stepList.removeClass('active');
				  stepList.eq(i + 1).addClass('active');
			  }
		  }
	  }
  });
  
  
  $('.newSVCFormContent > ul li select#country').change(regionAutoList);
});
