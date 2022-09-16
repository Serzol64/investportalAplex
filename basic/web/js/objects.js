let currentSlide = 0,
    n;


const searchwinclose = (e,t) => {
    e.preventDefault();
    $('#objects > .projects-search-form').addClass('window-closed');
}
const searchwinproccess = (e,t) => {
	$('.load-screen-services').removeClass('list-smart-close'); 
	
	let attributeData = $(''),
		regionData = [$(''), $('')],
		parameterData = [
			[$(''), $('')],
			[$(''), $('')]
		];
		
	
}

$(document).ready(function () {
    $('#objects > .projects-search-form header #right-content .close').click(searchwinclose);
    $('#objects > .projects-search-form main form .selectors .selector #type-selector, #objects > .projects-search-form footer .filter .option #option-selector, #objects > .projects-search-form footer .filter .parameters .parameter-form #text-from, #objects > .projects-search-form footer .filter .parameters .parameter-form #text-to').change(searchwinproccess);
});

const ServiceSliderSwitcher_Back = (cntl,slider) => {
    cntl.click(function (e) { 
        var sllib = slider;
        n = currentSlide - 1;
        
        sllib.eq(currentSlide).attr('id','hide');
        currentSlide = (n+sllib.length)%sllib.length;
        sllib.eq(currentSlide).attr('id','');

    });
}
const ServiceSliderSwitcher_Go = (cntl,slider) => {
    cntl.click(function (e) { 
        var sllib = slider;
        n = currentSlide + 1;
        
        sllib.eq(currentSlide).attr('id','hide');
        currentSlide = (n+sllib.length)%sllib.length;
        sllib.eq(currentSlide).attr('id','');
    });
}

const regionAutoList = (select) => {
	var regionCont = $('#objects > .projects-search-form footer .filter .option:nth-child(2) #option-selector'),
		rdbq = new FormData();
		
	rdbq.append('country', select.value);
	
	if(select.value !== 'any'){
		fetch('/services/0/post', { method: 'POST', body: rdbq })
			.then(response => response.json())
			.then((data) => {
				regionCont.html('');
				regionCont.append('<option value="any">All Regions</option>');
				
				for(let i = 0; i < data.length; i++){ regionCont.append('<option value="' + data[i]['id'] + '">' + data[i]['region'] + '</option>'); }
				
				if(regionCont.prop('disabled')){ regionCont.prop('disabled', false); }
			});
	}
	else{ regionCont.prop('disabled', true); }
}

$(document).ready(function () {
	$(window).resize(function(){ $('#objects').height($('.main').height() - $('.objects-list').height()); });
    $(window).resize();
    
    let controlsBack = [
        $('#services > main header#slider-controller img'),
        $('#services > main header#slider-controller-adaptive img')
    ];
    let controlsGo = [
        $('#services > main footer#slider-controller img'),
        $('#services > main footer#slider-controller-adaptive img')
    ];
    let sliders = [
        $('#services > main #slider-view .service-feed .service'),
        $('#services > main #slider-view-adaptive .service')
    ];

    for (let i = 0; i < sliders.length; i++) {
        const e = sliders[i],
              g = controlsGo[i],
              b = controlsBack[i];

        ServiceSliderSwitcher_Back(b,e);
        ServiceSliderSwitcher_Go(g,e);
        
    }

    
});
