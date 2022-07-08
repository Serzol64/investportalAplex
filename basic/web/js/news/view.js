$(document).ready(function () {
    $(window).resize(function(){ $('.main').height($('.main').height() + $('#news > .news-viewer #left-content').height()); });
    $(window).resize();
});
