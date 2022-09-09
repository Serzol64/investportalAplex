function newsViewerTabletSizerXXL(e){ if(e.matches){ $('#news').css('min-height', '1780px'); } }
function newsViewerTabletSizerXL(e){ if(e.matches){ $('#news').css('min-height', '2780px'); } }
function newsViewerTabletSizerL(e){ if(e.matches){ $('#news').css('min-height', '3080px'); } }

$(document).ready(function () {
    $(window).resize(function(){ $('#news').height($('.main').height() - $('#news > .news-viewer #left-content').height()); });
    $(window).resize();
    
    let mediaListener = [
		window.matchMedia('(min-width: 960px) and (max-width: 1024px)'),
		window.matchMedia('(min-width: 414px) and (max-width: 768px)'),
		window.matchMedia('(max-width: 414px)')
    ];
    
    mediaListener[0].addListener(newsViewerTabletSizerXXL);
    mediaListener[1].addListener(newsViewerTabletSizerXL);
    mediaListener[2].addListener(newsViewerTabletSizerL);
    
    newsViewerTabletSizerXL(mediaListener[1]);
    newsViewerTabletSizerL(mediaListener[2]);
    newsViewerTabletSizerXXL(mediaListener[0]);

});
