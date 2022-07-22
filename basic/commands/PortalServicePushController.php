<?php

namespace app\commands;

use yii\console\Controller;
use app\models\PortalServices;

class PortalServicePushController extends Controller{
    public function actionIndex($serviceId, $userAuthType){
        $ec = 0;
        
        $currentServiceCmd = PortalServices::findAll(['id' => $serviceId])->select('JSON_EXTRACTS(proc, \'$.push\') as command')->one();
        $proccessCMD = `python` . __DIR__ . `/automatization/push/` . $serviceId . `/` . $currentServiceCmd->command;
        if($userAuthType){ $operationCMD = $proccessCMD .  ` --fastMode`; }
        else{ $operationCMD = $proccessCMD; }
        
        echo $operationCMD;
        return $ec;
    }
}

?>
