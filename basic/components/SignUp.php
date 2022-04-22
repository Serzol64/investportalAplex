<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\Json;
use app\models\User;


class SignUp extends Component{
	public $signQuery;
	
	public function init(){
		parent::init();

		$this->signQuery = [];
	}

	public function proccess($signQuery = null){
		if($signQuery != null){ $this->signQuery = $signQuery; }

		$upModel = [
			User::find(),
			new User()
		];

		$login = $this->signQuery['login'];
		$pass = sha1($this->signQuery['password']);
		$firstname = $this->signQuery['fn'];
		$surname = $this->signQuery['sn'];
		$mail = $this->signQuery['email'];
		$phone = $this->signQuery['phone'];
		$region = $this->signQuery['country'];

		$validLogin = $upModel[0]->where(['login' => $login])->all();
		$validEMail = $upModel[0]->where(['email' => $mail])->all();
		$validPassword = $upModel[0]->where(['password' => $pass])->all();
		$validPhone = $upModel[0]->where(['phone' => $phone])->all();

		if(!$validLogin && !$validEMail && !$validPassword && !$validPhone){
			$upModel[1]->firstname = $firstname;
			$upModel[1]->surname = $surname;
			$upModel[1]->login = $login;
			$upModel[1]->password = $pass;
			$upModel[1]->email = $mail;
			$upModel[1]->phone = $phone;
			$upModel[1]->country = $region;
						
						
			if($upModel[1]->save()){ return ['c' => 200, 'm' => 'Registration success!']; }
			else{ return ['c' => 409, 'm' => 'The portal accounting service is temporarily unavailable! Try again later;-(']; }
		}
		else{
			$validError = [];
					

			if($validLogin){ array_push($validError, ['validError' => 'The login you entered exists']); }
			if($validEMail){ array_push($validError, ['validError' => 'The e-mail you entered exists']); }
			if($validPassword){ array_push($validError, ['validError' => 'The password you entered exists']); }
			if($validPhone){ array_push($validError, ['validError' => 'The phone number you entered exists']); }
			return ['c' => 400, 'm' => $validError];
		}
		
	}
	
}
?>
