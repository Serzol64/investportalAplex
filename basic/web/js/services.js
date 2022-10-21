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
  
  
  $('.newServiceForm > div[data-modalpart=\'content\'] main#formUI .formStep #step.active #formStepUI .header a').click(function(e,t){
	  e.preventDefault();
	
	  let nfsEl = [$('.newServiceForm > div[data-modalpart=\'content\'] main#formUI .formStep #step.active #formStepUI .header a'), $('.newServiceForm > div[data-modalpart=\'content\'] main#formUI .formStep #step.active #formStepUI .content #tab')];
	  
	  for(let i = 0; i < nfsEl.length; i++){
		  nfsEl[i].removeClass('active');
		  nfsEl[i].eq($(this).index()).addClass('active');
	  }
	  
	  $('.newServiceForm > div[data-modalpart=\'content\'] header#formUI .formStep #step.active span').css('display', 'none');
	  $('.newServiceForm > div[data-modalpart=\'content\'] header#formUI .formStep #step.active span').eq($(this).index()).css('display', 'block');
  });
});
