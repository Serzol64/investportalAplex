<?php

namespace app\commands;

use yii\console\Controller;

use app\models\PortalServices;

class PortalServiceRealtimeController extends Controller{
    public function actionIndex($serviceId, $userAuthType){
        $ec = 0;
        
        $currentServiceCmd = PortalServices::findAll(['id' => $serviceId])->select('JSON_EXTRACTS(proc, \'$.realtime\') as command')->one();
        $proccessCMD = `python` . __DIR__ . `/automatization/realtime/` . $serviceId . `/` . $currentServiceCmd->command;
        if($userAuthType){ $operationCMD = $proccessCMD .  `--fastMode`; }
        else{ $operationCMD = $proccessCMD; }
        
        echo $operationCMD;
        return $ec;
    }
}

?>
