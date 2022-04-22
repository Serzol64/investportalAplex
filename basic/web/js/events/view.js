$(document).ready(function(){
  $('.add-but[data-type=\'incoming\']').click(function(e,t){
    e.preventDefault();
    
    var incomeLink = $('.add-but[data-type=\'incoming\']').data('eventid');
    
    var getLink = incomeLink === 1 ? "https://events.kommersant.ru/events/2022-aprelskie-tezisy-kommercheskaya-nedvizhimost/#event__registration" : NULL;
    
    window.open(getLink, "_blank");
  });
});
