$(document).ready(function(){
  var tematic = $('#investors-list > .header .inv li');
 
  $(window).resize(function(){ $('#investors').height($('.main').height() - $('#investors-list').height()); });
  $(window).resize();
  
  tematic.click(function(e,t){
    var currentT = tematic.eq($(this).index());
    
    tematic.removeClass('selected');
    currentT.addClass('selected');
    
  });
});
