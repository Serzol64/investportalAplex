class CodeSender{

    constructor(service){
        this.service = service;
    }

    send(query){
        var isSUP = this.service === 'SignUp',
            isRST = this.service === 'Forgot';
            
        var ws;
        let svcQuery;


        if(isRST){
			svcQuery = {
				fsq: {
					service: 'Inbox',
					phone: query
				}
			};
			
			this.__CCService('forgot',svcQuery); //Code sender and generation service call
			ws = sessionStorage.getItem('sender');
			
			console.log('SMS Send: ' + ws);
        }
        else if(isSUP){
			let phoneNumber = query;

			svcQuery = {
				rsq: {
					service: 'Inbox',
					phone: phoneNumber
				}
			};

			this.__CCService('signUp',svcQuery);
			ws = sessionStorage.getItem('sender');
			
			console.log('SMS Send: ' + ws);
        }

    }

    valid(query){
        var isSUP = this.service === 'SignUp',
            isRST = this.service === 'Forgot';

		var ws;
        let svcQuery;
		
        if(isRST){

			   svcQuery = {
					fsq: {
						service: 'Valid',
						code: query.code,
						phone: query.phone
					}
				};	

               this.__CVCService('forgot',svcQuery); //Inputed code validation service call
			   ws = sessionStorage.getItem('valid');
			   
               console.log('Phone Valid: ' + ws);
       }
       else if(isSUP){
			   let phoneNumber = query.login;
			   
			   
			   svcQuery = {
					rsq: {
						service: 'Valid',
						code: query.code,
						phone: phoneNumber
					}
				};	
				
               this.__CVCService('signUp',svcQuery);
			   ws = sessionStorage.getItem('valid');
			   
               console.log('Phone Valid: ' + ws);
            }

        
    }
    __CCService(s,q){
		var fdcc = new FormData();
		fdcc.append('serviceQuery', JSON.stringify(q));
		let sQ = {
			method: 'POST',
			body: fdcc
		};
		
		fetch('accounts/accept/' + s, sQ).then((response) => {
			if(response.ok){ sessionStorage.setItem('sender', true); }
			else{ sessionStorage.setItem('sender', null); }
		});
	}
	__CVCService(s,q){
		var fdcvc = new FormData();
		fdcvc.append('serviceQuery', JSON.stringify(q));
		let sQ = {
			method: 'POST',
			body: fdcvc
		};
		
		fetch('accounts/accept/' + s, sQ).then((response) => {
			if(response.ok){ sessionStorage.setItem('valid', true); }
			else if(response.status === 400){ sessionStorage.setItem('valid', false); }
			else{ sessionStorage.setItem('valid', null); }
		});	
	}
}
