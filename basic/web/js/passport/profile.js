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
				
				if(curValue !== "" && validInputedQueries(0, index, curValue)){
					inputState = true;
					butState = "fa-edit";
					butStateDel = "fa-save";
					
					fetch('/passport/api/post?svc=profile', { method: 'POST', body: pudm })
						.then((response) => {
							if(response.status === 200){ alertify.success("Portal profile data updated!"); }
							else{ alertify.error("Portal profile data update error!"); }
						});
				}
				else{
					if(!validInputedQueries(0, index, curValue)){ alertify.error(validInputedQueriesError(0, index)); }
					else if(curValue === ""){ alertify.error(validInputedQueriesEmpty(0, index)); }
				}
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
				
				if(curValue !== "" && validInputedQueries(1, index, curValue)){
					inputStates = true;
					butStates = "fa-edit";
					butStateDels = "fa-save";
					
					fetch('/passport/api/post?svc=profile', { method: 'POST', body: pud })
					.then((response) => {
						if(response.status === 200){ alertify.success("Portal profile data updated!"); }
						else{ alertify.error("Portal profile data update error!"); }
					});
                
				}
				else{
					if(!validInputedQueries(1, index, curValue)){ alertify.error(validInputedQueriesError(1, index)); }
					else if(curValue === ""){ alertify.error(validInputedQueriesEmpty(1, index)); }
				}
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

function validInputedQueries(formType,index,query){
	let notErrorState = false;
	
	switch(index){
		case 0: 
			switch(index){
				case 0: if(/^[a-zA-Z0-9_.]{1,30}$/.test(query)){ notErrorState = true; } break;
				case 1: if(/^[a-zA-Z]+$/.test(query)){ notErrorState = true; } break;
				case 2: if(/^[a-zA-Z]+$/.test(query)){ notErrorState = true; } break;
				case 3: if(/^(\+)?((\d{2,3}) ?\d|\d)(([ -]?\d)|( ?(\d{2,3}) ?)){5,12}\d$/gm.test(query)){ notErrorState = true; } break;
			}
		break;
		case 1: 
			switch(index){
				case 0: if(approve.value(query, { email: true })){ notErrorState = true; } break;
				case 1: if(query !== ""){ notErrorState = true; } break;
			}
		break;
	}
	
	return notErrorState;
}
function validInputedQueriesEmpty(formType,index){
	let errorEState = "";
	
	switch(index){
		case 0: 
			switch(index){
				case 0: errorEState = "Login field this is required"; break;
				case 1: errorEState = "First name field this is required"; break;
				case 2: errorEState = "Surname field this is required"; break;
				case 3: errorEState = "Phone field this is required"; break;
			}
		break;
		case 1: 
			switch(index){
				case 0: errorEState = "Email field this is required"; break;
				case 1: errorEState = "Password field this is required"; break;
			}
		break;
	}
	
	return errorEState;
}
function validInputedQueriesError(formType,index){
	let errorState = "";
	
	switch(index){
		case 0: 
			switch(index){
				case 0: errorState = "Input valid login, please!(Example: investportal2021)"; break;
				case 1: errorState = "Input valid first name in English, please!(Example: John)"; break;
				case 2: errorState = "Input valid surname in English, please!(Example: Johnson)"; break;
				case 3: errorState = "Input valid phone, please!(Example: 79012345678)"; break;
			}
		break;
		case 1: 
			switch(index){
				case 0: errorState = "Input valid email, please!(Example: john@gmail.com)"; break;
				case 1: errorState = "Passwords don\'t match"; break;
			}
		break;
	}
	
	return errorState;
}
