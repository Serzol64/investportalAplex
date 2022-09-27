$(document).ready(function () {
    $(window).resize(function(){ $('#news').height($('.main').height() - $('#news > .news-viewer #left-content').height()); });
    $(window).resize();
});
