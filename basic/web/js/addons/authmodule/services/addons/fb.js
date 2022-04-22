function responseEvent(isLogin, s, q){
		if(isLogin){
			fetch('/accounts/fb', { method: 'POST', body: q }).then((response) => {
				switch(response.status){
					case 200: location.reload(true); break;
					case 404: new FacebookDataAccess('SignUp').proccess(); break;
				}
			});
		}
		else{
			if(s === 'SignUp'){
				fetch('/accounts/fb', { method: 'POST', body: q }).then((response) => {
					switch(response.status){
						case 200: location.reload(true); break;
						case 404: new FacebookDataAccess('SignIn').proccess(); break;
					}
				});
			}
		}
}
function newPasswordGenerate(){ 
	var chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var passwordLength = 12;
    var password = "";
	for (var i = 0; i <= passwordLength; i++) {
	   var randomNumber = Math.floor(Math.random() * chars.length);
	   password += chars.substring(randomNumber, randomNumber +1);
	}
	
	return password;
}
class FacebookDataAccess{
    constructor(service){ 
		this.service = service;
	}

    proccess(){  FB.getLoginStatus(this.__responseReader.bind(this)); }
    __responseReader(response){
		var isSIN = this.service === 'SignIn',
            isSUP = this.service === 'SignUp';
        var fd = [new FormData(), new FormData()];
		
		let fbQ;
		$('#auth-lightbox > .close').trigger('click');
		
		if(isSIN){
			FB.api('/me', {fields: 'name, email'}, function(response){
				fbQ = { 
					fbsvc: 'login',
					fbq: { login: response.email }
				};
				
				fd[1].append('serviceQuery', JSON.stringify(fbQ));
				responseEvent(true, 'SignIn', fd[1]);
			});
		}
		else if(isSUP){
			var modalAccept = [
				window.prompt('Input your login, please(Example: investportal.user2021):'),
				window.prompt('Input your mobile number and after registration final you receive an SMS to the phone number you entered with ready-made and provided access parameters to your account on the portal(Enter the phone number in this format: 79012345678):')
			];
			let newLogin, userPhone;
			
			if(/^[a-zA-Z0-9_.]{1,30}$/.test(modalAccept[0]) && /^(\+)?((\d{2,3}) ?\d|\d)(([ -]?\d)|( ?(\d{2,3}) ?)){5,12}\d$/gm.test(modalAccept[1])){
				newLogin = modalAccept[0];
				userPhone = modalAccept[1];
				
				FB.api('/me', {fields: 'first_name, last_name, email'}, function(response){
					fbQ = { 
						fbsvc: 'registration',
						fbq: {
							fn: response.first_name,
							sn: response.last_name,
							l:  newLogin,
							e: response.email,
							p: newPasswordGenerate(),
							m: userPhone
						}
					};
						
					fd[0].append('serviceQuery', JSON.stringify(fbQ));
					responseEvent(false, 'SignUp', fd[0]);
				});
			}
		}
	}
}
