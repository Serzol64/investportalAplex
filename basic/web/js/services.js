const regionAutoList = (e) => {
	if(this.value !== 'any'){
		var regionCont = $('.newSVCFormContent > ul li select#region'),
			rdbq = new FormData();
		
		rdbq.append('country', this.value);
		
		fetch('/services/0/post', { method: 'POST', body: rdbq })
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
    
    
    
    fetch('/services/4/post', { method: 'POST', body: sfd })
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
  
  $('.modal').css('max-width', '100%').height(567);
  
  $('.last-example > #exmpl').click(function(e, t){
    var searchEl = $('header#search > input'),
        currentV = $(this).text();
    
    searchEl.val(currentV);
  });
  
  $('.newServiceForm > div[data-modalpart=\'content\'] footer#formUI button, .newServiceForm > div[data-modalpart=\'header\'] .formStep #step').click(function(e,t){
	  let stepList = $('.newServiceForm > div[data-modalpart=\'header\'] .formStep #step, .newServiceForm > div[data-modalpart=\'content\'] .formStep #step');
	  
	  for(let i = 0; i < stepList.length; i++){
		  let currentStep = stepList.eq(i).hasClass('active');
		  
		  if(e.target.nodeName === 'li'){
			  if(i === 2 && currentStep){
				  stepList.removeClass('active');
				  stepList.eq(3).addClass('active');
				  $('.newServiceForm > div[data-modalpart=\'content\'] footer#formUI button').html('Finish');
			  }
			  else{
				  stepList.removeClass('active');
				  stepList.eq($(this).index()).addClass('active');
				  
				  if($('.newServiceForm > div[data-modalpart=\'content\'] footer#formUI button').html() === 'Finish'){ $('.newServiceForm > div[data-modalpart=\'content\'] footer#formUI *').html('Countine'); }
				  
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
  
  $('.newServiceForm > div[data-modalpart=\'content\'] main#formUI .formStep #step.active #formStepUI .header a').click(function(e,t){
	  e.preventDefault();
	
	  let nfsEl = [$('.newServiceForm > div[data-modalpart=\'content\'] main#formUI .formStep #step #formStepUI .header a'), $('.newServiceForm > div[data-modalpart=\'content\'] main#formUI .formStep #step #formStepUI .content #tab')];
	  
	  for(let i = 0; i < nfsEl.length; i++){
		  nfsEl[i].removeClass('active');
		  nfsEl[i].eq($(this).index()).addClass('active');
	  }
	  
	  $('.newServiceForm > div[data-modalpart=\'content\'] header#formUI .formStep #step span').css('display', 'none');
	  $('.newServiceForm > div[data-modalpart=\'content\'] header#formUI .formStep #step span').eq($(this).index()).css('display', 'block');
  });
  
  
  $('.newSVCFormContent > ul li select#country').on('change', regionAutoList);
});
