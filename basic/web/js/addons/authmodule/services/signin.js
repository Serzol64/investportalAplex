function SignInFormProcess() {

    var notEmpty = [
        $('#auth-lightbox > .module-page[data-screen="SignIn"] main .module-form form input').eq(0).val() !== '',
        $('#auth-lightbox > .module-page[data-screen="SignIn"] main .module-form form input').eq(1).val() !== ''
    ],
        isValid =  /^[a-zA-Z0-9_.]{1,30}$/.test($('#auth-lightbox > .module-page[data-screen="SignIn"] main .module-form form input').eq(0).val()) || approve.value($('#auth-lightbox > .module-page[data-screen="SignIn"] main .module-form form input').eq(0).val(), { required: true, email: true }) || /^(\+)?((\d{2,3}) ?\d|\d)(([ -]?\d)|( ?(\d{2,3}) ?)){5,12}\d$/gm.test($('#auth-lightbox > .module-page[data-screen="SignIn"] main .module-form form input').eq(0).val());
        errorMessage = "";

        
    if ((notEmpty[0] && notEmpty[1]) && isValid) {
		var ld = $('#auth-lightbox > .module-page[data-screen="SignIn"] main .module-form form input').eq(0).val();
		var fdl = new FormData();



	    var InQuery = {
				asq: {
					portalId: ld,
					password: $('#auth-lightbox > .module-page[data-screen="SignIn"] main .module-form form input').eq(1).val(),
				}
		};
		
		fdl.append('serviceQuery', JSON.stringify(InQuery));

		fetch('/accounts/signIn', { method: 'POST', body: fdl }).then((response) => {
			switch(response.status){
				case 200:
					$('#auth-lightbox > .module-page[data-screen="SignIn"] main .module-form form input').val('');
					$('#auth-lightbox > .close').trigger('click');

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
    else {
        if (!isValid) {
            errorMessage += "Input valid account data, please!(Examples: john@gmail.com, investportal2021 or 79012345678)\n\n";
        }

        if (!notEmpty[0]) {
            errorMessage += "Account data field is required!\n\n";
        }

        if (!notEmpty[1]) {
            errorMessage += "Password field is required!\n\n";
        }
    }

    if(errorMessage){
        alert(errorMessage);
    }
}

const SignInService = () => { $('#auth-lightbox > .module-page[data-screen="SignIn"] main .module-form button#form-submit:nth-last-child(1)').click(SignInFormProcess); }
