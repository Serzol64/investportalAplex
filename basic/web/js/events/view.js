$(document).ready(function(){
  $('.add-but[data-type=\'incoming\']').click(function(e,t){
    e.preventDefault();
    
    
    
    window.open(getLink, "_blank");
  });
  
  $(window).resize(function(){ $('#news').height($('.main').height() - ($('#news > .news-viewer #left-content').height() / 6)); });
  $(window).resize();
});
