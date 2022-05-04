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
                
				
				var pudm = new FormData(),
					curValue = curPut.val();
				
				let puqm = {
					login: get_cookie('portalId'),
					query: {}
				};
					
				if(index === 1){ puqm.query = { fn: curValue }; }
				else if(index === 2){ puqm.query = { sn: curValue }; }
				else if(index === 3){ puqm.query = { phone: curValue }; }
				else{ puqm.query = { newLogin: curValue }; }
				
				pudm.append('svcQuery', JSON.stringify(puqm));
				
				alertify.set('notifier','position', 'top-right');
				alertify.set('notifier','delay', 5);
				
				
				fetch('/passport/api/post?svc=profile', { method: 'POST', body: pudm })
					.then((response) => {
						if(response.status === 200){ alertify.success("Portal profile data updated!"); }
						else{ alertify.error("Portal profile data update error!"); }
					});
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
                butStateDels = "";

            if (!curPuts.prop('disabled')) {
                inputStates = true;
                butStates = "fa-edit";
                butStateDels = "fa-save";
                
				
				var pud = new FormData(),
					currentValue = curPuts.val();
				
				let puq = {
					login: get_cookie('portalId'),
					query: {}
				};
					
				if(index === 1){ puq.query = { password: currentValue }; }
				else{ puq.query = { email: currentValue }; }
				
				pud.append('svcQuery', JSON.stringify(puq));
				
				alertify.set('notifier','position', 'top-right');
				alertify.set('notifier','delay', 5);
				
				
				fetch('/passport/api/post?svc=profile', { method: 'POST', body: pud })
					.then((response) => {
						if(response.status === 200){ alertify.success("Portal profile data updated!"); }
						else{ alertify.error("Portal profile data update error!"); }
					});
            } 
            else { 
                butStates = "fa-save"; 
                butStateDels = "fa-edit";
            }
            
            curPuts.prop('disabled',inputStates);

            curBCs.addClass(butStates);
            curBCs.removeClass(butStateDels);
            
        });
        
    }

    
});
