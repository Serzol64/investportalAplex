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
});
