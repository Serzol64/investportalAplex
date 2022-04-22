function SignUpFormProcess(){
    let isOpenedStep = [
        $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="0"]').css('display') != 'none',
        $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="1"]').css('display') != 'none',
        $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="2"]').css('display') != 'none',
        $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="3"]').css('display') != 'none'
    ];
    

    var errorMess = "",
        validData = [],
        notEmpty = [];
    
    if(isOpenedStep[1]){
        notEmpty = [
            $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="1"] form div input').eq(0).val() !== '',
            $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="1"] form div input').eq(1).val() !== '',
            $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="1"] form div input').eq(2).val() !== '',
            $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="1"] form div input').eq(3).val() !== ''
        ];

        validData = [
            approve.value($('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="1"] form div input').eq(0).val(), { required: true, email: true }),
           /^(\+)?((\d{2,3}) ?\d|\d)(([ -]?\d)|( ?(\d{2,3}) ?)){5,12}\d$/gm.test($('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="1"] form div input').eq(3).val())
        ];
        var isValidPassed = $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="1"] form div input').eq(2).val() === $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="1"] form div input').eq(1).val();

        if((notEmpty[0] && notEmpty[1] && notEmpty[2] && notEmpty[3]) && (validData[0] && validData[1]) && isValidPassed){
            OpenStep('SignUp', 2);
        }
        else{
                if(!notEmpty[0]){
                    errorMess += "Email field this is required\n\n";
                }
                else if(!validData[0]){
                    errorMess += "Input valid email, please!(Example: john@gmail.com)\n\n";
                }

                if(!notEmpty[1]){
                    errorMess += "Password field this is required\n\n";
                }

                if(!isValidPassed){
                    errorMess += "Passwords don't match\n\n";
                }
                else if(!notEmpty[2]){
                    errorMess += "Confirm password field this is required\n\n";
                }

                if(!notEmpty[3]){
                    errorMess += "Phone field this is required\n\n";
                }
                else if(!validData[3]){
                    errorMess += "Input valid phone, please!(Example: 79012345678)\n\n";
                }
        }
    }
    else if(isOpenedStep[2]){
       if($('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="2"] form div select#region').val() !== 'any'){ OpenStep('SignUp', 3); }
       else{ alert('You no selected country!'); }
       
       if($('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="2"] form div select#region').val() !== 'any'){
		   var q = $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="1"] form div input').eq(3).val();
		   new CodeSender('SignUp').send(q);

		   console.log('SMS Send code success!');

		   $('.module-page[data-screen="SignUp"] > main #reg-footer button#form-submit').html('Sign up');
	   }
    }
    else if(isOpenedStep[3]){
		let inputedCode = $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="3"] form div input').val();
		new CodeSender('SignUp').valid({
			login: $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="1"] form div input').eq(3).val(),
			code: inputedCode
		});
        if(inputedCode.length == 0 || inputedCode.length < 4 || inputedCode.length > 4){
            alert('The entered code must have a four-digit format, or it is not entered!');
        }
        else{
			var phoneNumber = $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="1"] form div input').eq(3).val();
			var fdu = new FormData();
		
			var UpQuery = {
				rsq: {
					fn: $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="0"] form div input').eq(0).val(),
					sn: $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="0"] form div input').eq(1).val(),
					login: $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="0"] form div input').eq(2).val(),
					password: $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="1"] form div input').eq(1).val(),
					email: $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="1"] form div input').eq(0).val(),
					phone: phoneNumber,
					country: $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="2"] form div select#region').val()
				}
			};
			
			fdu.append('serviceQuery', JSON.stringify(UpQuery));
			

			fetch('/accounts/signUp', { method: 'POST', body: fdu }).then((response) => {
				switch(response.status){
					case 200:
						$('.module-page[data-screen="SignUp"] > main #reg-content li form div input').val('');
						$('#auth-lightbox > .close').trigger('click');
						OpenStep('SignUp', 0);
						
						AutoSignIn($('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="0"] form div input').eq(2).val());
						sleep(2000);
						location.reload(true);
					break;
					case 400:
						var errors = response.json();
						var eMess = '';

						for(let id in errors){ eMess += errors[id].validError + '\n'; }

						alert(eMess);
						OpenStep('SignUp', 0);
					break;
				}
			});
        }
    }
    else{
        notEmpty = [
            $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="0"] form div input').eq(0).val() !== '',
            $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="0"] form div input').eq(1).val() !== '',
            $('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="0"] form div input').eq(2).val() !== ''
        ];

        validData = [
            /^[a-zA-Z]+$/.test($('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="0"] form div input').eq(0).val()),
            /^[a-zA-Z]+$/.test($('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="0"] form div input').eq(1).val()),
            /^[a-zA-Z0-9_.]{1,30}$/.test($('.module-page[data-screen="SignUp"] main #reg-content li[data-signstep="0"] form div input').eq(2).val())
        ];
        if((notEmpty[0] && notEmpty[1] && notEmpty[2]) && (validData[0] && validData[1] && validData[2])){
            OpenStep('SignUp', 1);
        }
        else{
            if(!notEmpty[0]){
                    errorMess += "First name field this is required\n\n";
            }
            else if(!validData[0]){
                    errorMess += "Input valid first name in English, please!(Example: John)\n\n";
            }

            if(!notEmpty[1]){
                    errorMess += "Surname field this is required\n\n";
            }
            else if(!validData[1]){
                    errorMess += "Input valid surname in English, please!(Example: Johnson)\n\n";
            }

            if(!notEmpty[2]){
                    errorMess += "Login field this is required\n\n";
            }
            else if(!validData[2]){
                    errorMess += "Input valid login, please!(Example: investportal2021)\n\n";
            }
            

        }
        
    }

    if(errorMess){
        alert(errorMess);
    }


}

function AutoSignIn (login) {
	var fda = new FormData();
	var autoInQuery = {fsq:{portalId:login}};
	
	fda.append('serviceQuery', JSON.stringify(autoInQuery));
	fetch('/accounts/autoAuth', { method: 'POST', body: fda}).then((response) => { if(response.ok){ console.log('Automatic authorization success!'); } });
}

const SignUpService = () => { $('.module-page[data-screen="SignUp"] > main #reg-footer button#form-submit').click(SignUpFormProcess);  }
