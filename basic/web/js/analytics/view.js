$(document).ready(function () {
    $(window).resize(function(){ $('#news').height($('.main').height() - ($('#news > .news-viewer #left-content').height() / 6)); });
	$(window).resize();
});
