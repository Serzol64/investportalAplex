
$(document).ready(function () {
    $('#lightbox > .lightwin-passport#offer footer #left-content-plus .add-but, #lightbox > .lightwin-passport-regional#offer footer #left-content .add-but').click(function(e,t){
		var oqq = new FormData();
	
		let currentPart = $(this).data('control'),
			investQuery = {};
		
		investQuery.login = get_cookie('portalId');
		investQuery.offer = $('.lightwin-passport > main form #textput.offer').val();
		investQuery.status = $('.lightwin-passport > footer #left-content .selectors #selector:nth-child(1) #selector-check:checked').val() ? true : false;
		investQuery.isMail = $('.lightwin-passport > footer #left-content .selectors #selector:nth-child(2) #selector-check:checked').val() ? true : false;
		
		if($('.lightwin-passport > main form #textput').data('id')){ investQuery.objectId = $('.lightwin-passport > main form #textput').data('id'); }

		if(currentPart === 'region'){
			investQuery.parameter = {
				name: $('.lightwin-passport > main form #textput.title').val(),
				category: $('.lightwin-passport > main form #selector-form').eq(0).val(),
				country: $('.lightwin-passport > main form #selector-form').eq(1).val()
			};
			investQuery.region = getSelectedRegions();
		}
		else if(currentPart === 'default'){
			investQuery.parameter = {
				name: $('.lightwin-passport > main form #textput.title').val(),
				category: $('.lightwin-passport > main form #selector-form').eq(0).val(),
				country: $('.lightwin-passport > main form #selector-form').eq(1).val()
			};
		}
		
		oqq.append('svcQuery', JSON.stringify(investQuery));
		
		$('.lightwin-passport, .lightwin-passport-regional').addClass('waiting-mode');
		
		alertify.set('notifier','position', 'top-right');
		alertify.set('notifier','delay', 10);
		
		fetch('/passport/api/post?svc=offers', { method: 'POST', body: oqq })
			.then((response) => {
				$('.lightwin-passport, .lightwin-passport-regional').removeClass('waiting-mode');
				if(response.status === 200){ window.location.reload(true); }
			})
			.catch(() => { 
				$('.lightwin-passport, .lightwin-passport-regional').removeClass('waiting-mode');
				alertify.error('Request sending failed! Try again later...'); 
			});
	});
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
