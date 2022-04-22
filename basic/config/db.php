<?php

$remoteConnect = [];
if($_SERVER['SERVER_NAME'] == 'investportal.aplex.ru'){
	$remoteConnect = [
		'ds' => 'mysql:host=localhost;dbname=zolotaryow_inv',
		'u' => 'zolotaryow_inv',
		'p' => 'pNtJCRTGEZ'
	];
}
else{ 
	$remoteConnect = [
		'ds' => 'mysql:host=database;dbname=aplex',
		'u' => 'developer',
		'p' => '19052000'
	];
}
return [
    'class' => 'yii\db\Connection',
    'dsn' => $remoteConnect['ds'],
    'username' => $remoteConnect['u'],
    'password' => $remoteConnect['p'],
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
