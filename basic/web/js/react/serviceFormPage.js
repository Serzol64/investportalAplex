let currentService = $('#service-page-form > div[data-serviceForm-type="main"]').data('service');
let currentStep = 0, n;

$(document).ready(function(){
		$('#step > div#body label input#default-field, #step > div#body label input#search-field, #step > div#body label select#list-field').change(function(e,t){
			set_cookie($(this).attr('class'), $(this).val(), new Date().getFullYear(), new Date().getMonth() + 1, 0, location.pathname, location.hostname, location.hostname === 'investportal.aplex.ru' ? true : false);
		});
	
		
        $('#formUI > .formStep #step #body button#action').click(function(e,t){
            var message = $(this).text(),
                validCMD = new FormData();
            let formError = [],
                formValidQuery = {},
                errorContentForm = '';

            if(message === 'Countine'){
                var sllib = $('#formUI > .formStep #step');
                n = currentStep + 1;

                let validField = $('#formUI > .formStep #step.currentStep #body label');
                 
				let countineSelect = [[],[]];
					
				for(let i = 0; i < validField.length; i++){
					countineSelect[0].push(validField.eq(i).find('*').eq(1).attr('class'));
					countineSelect[1].push(validField.eq(i).find('*').eq(1).val());
				}
					
                formValidQuery = {
                        type: 'sender',
                        service: 'valid',
                        parameters: {
                            multiValidator: {
                                label: countineSelect[0],
                                value: countineSelect[1]
                            }
                        }
                 };
                 

                 validCMD.append('cmd', JSON.stringify(formValidQuery));

                 fetch('/services/api/2/post?id=' + currentService, {method: 'POST', body: validCMD})
                 .then(response => response.json())
                 .then((data) => {
                    if(data.length > 0){
                        for(var i = 0; i < data.length; i++){ formError.push(data[i]); }
                    }
                 });
                if(formError.length === 0){
                    sllib.removeClass('currentStep');
                    currentStep = (n+sllib.length)%sllib.length;
                    sllib.eq(currentStep).addClass('currentStep');
                    $('main#formUI > .formStep #step').eq(currentStep).addClass('currentStep');
                    $('footer#formUI > .formStep #step').eq(currentStep).addClass('currentStep');
                }
                else{
                    alertify.set('notifier','position', 'top-right');
			        alertify.set('notifier','delay', 10);

                    for(var i = 0; i < formError.length; i++){ errorContentForm += formError[i] + '\n\n'; }

                    alertify.error(errorContentForm);
                }
                
            }
            else{
               var cmd = new FormData();
               let cmdQuery = null, fi, fa, fields = $('#formUI > .formStep #step'), subFields;
               
               let validFinal = fields.eq($('#formUI > .formStep #step').length - 1).find('#body label');

               let finalSelect = [[],[]];
					
			   
				for(let i = 0; i < validFinal.length; i++){
						finalSelect[0].push(validFinal.eq(i).find('*').eq(1).attr('class'));
						finalSelect[1].push(validFinal.eq(i).find('*').eq(1).val());
				}
					
               formValidQuery = {
                        type: 'sender',
                        service: 'valid',
                        parameters: {
                            multiValidator: {
                                label: finalSelect[0],
                                value: finalSelect[1]
                            }
                        }
              };

               validCMD.append('cmd', JSON.stringify(formValidQuery));

               fetch('/services/api/2/post?id=' + currentService, {method: 'POST', body: validCMD})
                 .then(response => response.json())
                 .then((data) => {
                    if(data.length > 0){
                        for(var i = 0; i < data.length; i++){ formError.push(data[i]); }
                    }
                });
               
               if(formError.length === 0 && get_cookie('portalId')){
                   let authorizedQ = {
                    type: 'sender',
                    service: 'submit',
                    parameters: {}
                   };

                   for(fi = 0; fi < fields.length; fi++){
                        subFields = fields.eq(fi).find('div#body label');
						
						for(fa = 0; fa < subFields.length; fa++){ authorizedQ.parameters[subFields.eq(fa).find('*').eq(1).attr('class')] = subFields.eq(fa).find('*').eq(1).val(); }
                   }
                   cmdQuery = authorizedQ;
               }
               else if(formError.length === 0 && !get_cookie('portalId')){
                    let visitorQ = {
                        type: 'sender',
                        service: 'submit',
                        parameters: {}
                    };

                    
                    for(fi = 0; fi < fields.length; fi++){
                        subFields = fields.eq(fi).find('div#body label');
						
						for(fa = 0; fa < subFields.length; fa++){ authorizedQ.parameters[subFields.eq(fa).find('*').eq(1).attr('class')] = subFields.eq(fa).find('*').eq(1).val(); }
                   }

                    cmdQuery = visitorQ;
               }
               else{
                alertify.set('notifier','position', 'top-right');
                alertify.set('notifier','delay', 10);

                for(var i = 0; i < formError.length; i++){ errorContentForm += formError[i] + '\n\n'; }
                alertify.error(errorContentForm);
              }

               if(formError.length === 0){
                cmd.append('cmd', JSON.stringify(cmdQuery));

                alertify.set('notifier','position', 'top-right');
                alertify.set('notifier','delay', 10);
 
                fetch('/services/api/2/post?id=' + currentService, {method: 'POST', body: cmd})
                 .then(response => response.json())
                 .then(SuccessServiceResponse)
                 .catch(FailServiceResponse);
               }
            }
       
			document.body.scrollTop = document.documentElement.scrollTop = 0;
        });
});

function SuccessServiceResponse(data){
        $('header#formUI > .formStep').html('<div class="finish-message success">Your request is in the queue for its consideration!</div>');
        $('main#formUI > .formStep').html('<div class="finish-message success"><img src="/images/icons/services-status/success.svg" /><p>After 10 seconds, you will be automatically redirected to the information page about the service from which you came to this page. During this time, you will see a block on the upper right corner with a notification about the successful sending of the request.</p></div>');
        $('footer#formUI > .formStep').remove();

        alertify.success(data.message);
        window.setTimeout(function(){ window.location.assign('/services/' + currentService); }, 10000);
}
function FailServiceResponse(error){
        $('header#formUI > .formStep').html('<div class="finish-message error">An error occurred in sending the request</div>');
        $('main#formUI .formStep').html('<div class="finish-message error"><img src="/images/icons/services-status/error.svg" /><p>Within 10 seconds, you will see a window with the essence of the error in the upper right corner. Check your Internet connection and if the connection is stable, then disable the VPN if it is available on your network or device. With a stable connection, these are temporary problems in the infrastructure of the portal and its services, which are instantly eliminated. Try to enter and send the data again after a while by clicking on the button under this message that you are reading!</p></div>');
        $('footer#formUI > .formStep').html('<div class="finish-message error"><button>Input query again</button></div>');

        alertify.error('Service send error:\n' + error + '\n Retry proccess again!');

        $('#formUI > .formStep .finish-message button').click(function(){ location.reload(true); });
}
