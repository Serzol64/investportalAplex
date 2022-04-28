$(document).ready(function () {
    const but = $('.settings-form > .form-wrapper button'),
          butCont = $('.settings-form > .form-wrapper button i.far'),
          put = $('.settings-form > .form-wrapper .input');

    for (let index = 0; index < $('.settings-form > .form-wrapper').length; index++) {
        but.eq(index).click(function (e,t) { 

            const curPut = put.eq(index),
                  curBC = butCont.eq(index);
            let inputState = false,
                butState = "",
                butStateDel = "";

            if (!curPut.prop('disabled')) {
                inputState = true;
                butState = "fa-edit";
                butStateDel = "fa-save";
            } 
            else { 
                butState = "fa-save"; 
                butStateDel = "fa-edit";
            }
            
            curPut.prop('disabled',inputState);

            curBC.addClass(butState);
            curBC.removeClass(butStateDel);
            
        });
        
    }

    const buts = $('.settings-form > .form-wrapper-special button'),
          butConts = $('.settings-form > .form-wrapper-special button i.far'),
          puts = $('.settings-form > .form-wrapper-special .input');

    for (let index = 0; index < $('.settings-form > .form-wrapper-special').length; index++) {
        buts.eq(index).click(function (e,t) { 

            const curPuts = puts.eq(index),
                  curBCs = butConts.eq(index);
            let inputStates = false,
                butStates = "",
                butStateDels = "",
                attrState = 'text';

            if (!curPuts.prop('disabled')) {
                inputStates = true;
                butStates = "fa-edit";
                butStateDels = "fa-save";

                if(index === 1){ attrState = 'password'; }
                else{ attrState = 'email'; }
            } 
            else { 
                butStates = "fa-save"; 
                butStateDels = "fa-edit";
            }
            
            curPuts.prop('disabled',inputStates);
            curPuts.attr('type',attrState);

            curBCs.addClass(butStates);
            curBCs.removeClass(butStateDels);
            
        });
        
    }
    
    $('').click(function(e,t){
		var pud = new FormData();
		let puq = {
			login: $('').val(),
			query: {
				fn: $('').val(),
				sn: $('').val(),
				newLogin: $('').val(),
				password: $('').val(),
				email: $('').val(),
				phone: $('').val()
			}
		};
		
		pud.append('svcQuery', JSON.stringify(puq));
		
		fetch('/passport/api/post?svc=profile', { method: 'POST', body: pud })
			.then((response) => {
				if(response.ok){ alertify.set({ delay: 5000 }).success("Portal profile updated!"); }
				else{ alertify.set({ delay: 5000 }).error("Portal profile update error!"); }
			})
			.catch(error => {
				alert('Response error!');
				console.log(error);
			});
			
		
	});

    
});
