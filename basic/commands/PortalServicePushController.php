<?php

namespace app\commands;

use yii\console\Controller;

class PortalServicePushController extends Controller{
    public function actionIndex($serviceId, $userAuthType){
        $currentServiceCmd = PortalServices::findAll(['id' => $serviceId])->select('JSON_EXTRACTS(proc, \'$.push\') as command')->one();
        $proccessCMD = `python` . __DIR__ . `/automatization/controls/` . $serviceId . `/` . $currentServiceCmd->command;
        if($userAuthType){ $operationCMD = $proccessCMD .  `--fastMode`; }
        else{ $operationCMD = $proccessCMD; }
    }
}

?>
