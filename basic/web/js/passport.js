const ExitToPage = (e,t) => {
    window.location.assign($('.passport-page > header #right-content a').attr('href'));
}

$(document).ready(function () {
    $('.passport-page > header #right-content nav img#exit').click(ExitToPage);
});

const lightboxopen = (e,t) => {
    $('#lightbox').removeClass('lightbox-closed');
    $('.lightwin-passport').removeClass('lightbox-closed');
    $('.lightwin-passport-regional').removeClass('lightbox-closed');
}
const lightboxclose = (e,t) => {
    e.preventDefault();

    $('#lightbox').addClass('lightbox-closed');
    $('.lightwin-passport').addClass('lightbox-closed');
    $('.lightwin-passport-regional').addClass('lightbox-closed');
}
const lightboxcloseRegional = (e,t) => {
    e.preventDefault();

    $('.lightwin-passport-regional').addClass('lightbox-closed');
}

const sendQuery = (e,t) => {
	var oqq = new FormData();
	
	let currentPart = $(this).data('control'),
		investQuery = {};
	
	investQuery.login = get_cookie('portalId');
	investQuery.status = $('.lightwin-passport > footer #left-content .selectors #selector:nth-child(1) #selector-check:checked').val() ? true : false;
	investQuery.isMail = $('.lightwin-passport > footer #left-content .selectors #selector:nth-child(2) #selector-check:checked').val() ? true : false;
	
	if($('.lightwin-passport > main form #textput').data('id')){ investQuery.objectId = $('.lightwin-passport > main form #textput').data('id'); }

	if(currentPart === 'region'){
		investQuery.parameter = {
			name: $('.lightwin-passport > main form #textput').val(),
			category: $('.lightwin-passport > main form #selector-form').eq(0).val(),
			country: $('.lightwin-passport > main form #selector-form').eq(1).val(),
			cost: [$('.lightwin-passport > main form #from-to .left #selector-form-add').val(), $('.lightwin-passport > main form #from-to .right #selector-form-add').val()]
		};
		investQuery.region = getSelectedRegions();
	}
	else if(currentPart === 'default'){
		investQuery.parameter = {
			name: $('.lightwin-passport > main form #textput').val(),
			category: $('.lightwin-passport > main form #selector-form').eq(0).val(),
			country: $('.lightwin-passport > main form #selector-form').eq(1).val(),
			cost: [$('.lightwin-passport > main form #from-to .left #selector-form-add').val(), $('.lightwin-passport > main form #from-to .right #selector-form-add').val()]
		};
	}
	
	oqq.append('svcQuery', JSON.stringify(investQuery));
	
	$('.lightwin-passport, .lightwin-passport-regional').addClass('waiting-mode');
	
	alertify.set('notifier','position', 'top-right');
    alertify.set('notifier','delay', 10);
    
	fetch('/passport/api/post?svc=requests', { method: 'POST', body: oqq })
		.then((response) => {
			$('.lightwin-passport, .lightwin-passport-regional').removeClass('waiting-mode');
			if(response.status === 200){ window.location.reload(true); }
		})
		.catch(() => { 
			$('.lightwin-passport, .lightwin-passport-regional').removeClass('waiting-mode');
			alertify.error('Request sending failed! Try again later...'); 
		});
}


$(document).ready(function () {
    $('.add-but, .passport-page > header #right-content nav img#newrequest, .passport-page > header #right-content nav img#newoffer').click(lightboxopen);
    $('.lightwin-passport > header #right-content').click(lightboxclose);
    $('.lightwin-passport-regional > header #right-content').click(lightboxcloseRegional);
    if(window.location.pathname === '/passport'){ $('#lightbox > .lightwin-passport footer #left-content-plus .add-but, #lightbox > .lightwin-passport-regional footer #left-content .add-but').click(sendQuery); }
});

let adaptiveCnts = [
    $('.passport-menu-adaptive .nav li'),
    $('.passport-menu-adaptive .nav li img'),
    $('.passport-menu-adaptive .nav li span')
];
const TextLinksInit = () => {
    for(let i=0; i < adaptiveCnts[0].length; i++){
      adaptiveCnts[1].eq(i).after('<span>' + adaptiveCnts[1].eq(i).attr('alt') + '</span>');
    }
}
const PassportPagesAdaptiveMenu = () => {
    TextLinksInit();
}
$(document).ready(function(){
    PassportPagesAdaptiveMenu();
});

function getSelectedRegions(){
	let regionList = [],
		regionCont = $('.lightwin-passport-regional > main form .countries-part');
		
	for(let i = 0; i < regionCont.length; i++){ 
		
		let currentRegion = regionList.eq(i).find('label');
		
		for(let j = 0; j < currentRegion.length; j++){
			currentRegion = currentRegion.eq(j).find('input');
			if(currentRegion.prop('checked')){ regionList.push(currentRegion.val()); }
		}
		 
	}
	
	return regionList;
}
