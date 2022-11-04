$(document).ready(function(){
  var tematic = $('#investors-list > .header .inv li');
 
  $(window).resize(function(){ $('#investors-list').height(($('.main').height() - $('#investors-list').height()) * 2); });
  $(window).resize();
  
  $('.modal').css('max-width', '100%').height(567);
  
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
});
