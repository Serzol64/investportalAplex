function ForgotFormProcess(){
    let isOpenedStep = [
        $('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="0"]').css('display') != 'none',
        $('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="1"]').css('display') != 'none',
        $('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="2"]').css('display') != 'none'
    ];
    
    var fdf = new FormData();

    var errorMess = "",
        validData = [
			/^(\+)?((\d{2,3}) ?\d|\d)(([ -]?\d)|( ?(\d{2,3}) ?)){5,12}\d$/gm.test($('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="0"] form div input').val()),
			$('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="1"] form div input').val().length === 0 || $('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="1"] form div input').val().length < 4 ||  $('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="1"] form div input').val().length > 4,
            $('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="2"] form div input').eq(0).val() === $('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="2"] form div input').eq(1).val()
        ],
        notEmpty = [
            $('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="0"] form div input').val() !== '',
            $('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="1"] form div input').val() !== '',
            $('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="2"] form div input').eq(0).val() !== '',
            $('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="2"] form div input').eq(1).val() !== ''
        ];

    
    if(isOpenedStep[1]){
		new CodeSender('Forgot').valid({
			phone: $('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="0"] form div input').val(),
			code: $('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="1"] form div input').val()
		});
		
        if(notEmpty[1] && !validData[1] && sessionStorage.getItem('valid')){
            OpenStep('Forgot', 2);
            $('.module-page[data-screen="Forgot"] > main #reg-footer button#form-submit').html('Restore');
        }
        else{
            if(validData[1]){
                errorMess += "The entered code must have a four-digit format, or it is not entered!";
            }
        }
    }
    else if(isOpenedStep[2]){

        if((notEmpty[2] && notEmpty[3]) && validData[2]){

			var ForgotQuery = {
				fsq: {
					portalId: $('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="0"] form div input').val(),
					password: $('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="2"] form div input').eq(0).val(),
				}
			};
			
			fdf.append('serviceQuery', JSON.stringify(ForgotQuery));
			fetch('/accounts/forgot', { method: 'POST', body: fdf }).then((response) => {
				switch(response.status){
					case 200:
						$('.module-page[data-screen="Forgot"] > main #reg-content li form div input').val('');
						$('#auth-lightbox > .close').trigger('click');
						OpenStep('SignIn', 0);
						
						AutoSignIn($('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="0"] form div input').val());
						sleep(2000);
						location.reload(true);
					break;
					case 400:
						var errors = response.json();
						var eMess = '';

						for(let id in errors){ eMess += errors[id].validError + '\n'; }

						alert(eMess);
					break;
				}
			});
        }
        else{
            if(!notEmpty[2]){
                errorMess += "Password field this is required\n\n";
            }

            if(!notEmpty[3]){
                errorMess += "Confirm password field this is required\n\n";
            }

            if(!validData[2]){
                errorMess += "Passwords don't match\n\n";
            }
        }
    }
    else{
        if(notEmpty[0] && validData[0]){
            OpenStep('Forgot', 1);

             var q = $('.module-page[data-screen="Forgot"] main #reg-content li[data-signstep="0"] form div input').val();
			 
			 new CodeSender('Forgot').send(q);

			 console.log('SMS Send code success!');
        }
        else{
            if(!notEmpty[0]){
                errorMess += "Account data field is required!\n\n";
            }
            else if(!validData[0]){
                errorMess += "Input valid account data, please!(Example: 79012345678)\n\n";
            }
        }
    }

    if(errorMess){
        alert(errorMess);
    }
}
function ForgotPassService() { $('.module-page[data-screen="Forgot"] > main #reg-footer button#form-submit').click(ForgotFormProcess); }
