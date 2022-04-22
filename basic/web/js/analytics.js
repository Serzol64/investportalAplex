$(document).ready(function(){
  var tematic = $('.tematic > li');
  tematic.click(function(e,t){
    var currentT = tematic.eq($(this).index());
    
    tematic.removeClass('selected');
    currentT.addClass('selected');
  });
});
