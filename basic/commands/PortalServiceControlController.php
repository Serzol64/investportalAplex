<?php

namespace app\commands;

use yii\console\Controller;

use app\models\PortalServices;

class PortalServiceControlController extends Controller{
    public function actionIndex($serviceId, $query, $userAuthType){
        $ec = 0;
        
        $currentServiceCmd = PortalServices::findAll(['id' => $serviceId])->select('JSON_EXTRACTS(proc, \'$.control\') as command')->one();
        $proccessCMD = `python` . __DIR__ . `/automatization/controls/` . $serviceId . `/` . $currentServiceCmd->command;
        if($userAuthType){ $operationCMD = $proccessCMD . ` --userQuery=` . $query .  `--fastMode`; }
        else{ $operationCMD = $proccessCMD . ` --userQuery=` . $query; }

        echo $operationCMD;
        return $ec;
    }
}

?>
