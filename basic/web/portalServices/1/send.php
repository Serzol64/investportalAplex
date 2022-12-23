<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function connectorParam(){
	if($_SERVER['SERVER_NAME'] == 'investportal.aplex.ru'){
		$remoteConnect = [
			'ds' => ['localhost', 'zolotaryow_inv'],
			'u' => 'zolotaryow_inv',
			'p' => 'pNtJCRTGEZ'
		];
	}
	else{ 
		$remoteConnect = [
			'ds' => ['database', 'aplex'],
			'u' => 'developer',
			'p' => '19052000'
		];
	}
	
	return $remoteConnect;
}


function connector(){ return new PDO('mysql:host=' . connectorParam()['ds'][0] . ';port=3306;dbname=' . connectorParam()['ds'][1], connectorParam()['u'], connectorParam()['p']); }

function validData($label, $data){
	
	$database = connector();
	$errorResponse = [];
	
	if($label == 'objectTitle'){
		if(!preg_match('/[^A-Za-z]/', $data)){ $errorResponse[] = 'In this field, you most often use exclusively English characters!'; }
	}
	else if($label == 'objectCost'){
		if(!ctype_digit($data)){ $errorResponse[] = 'Either digits or floating-point digits are accepted in this field'; }
		else{
			if($data >= 67000000000000){ $errorResponse[] = 'Numbers are accepted here, or floating-point numbers! Condition: Data less than or equal to 67 trillion dollars'; }
		}
	}
	else if($label == 'objectAttribute'){
		
		if(!preg_match('/[^A-Za-z]/', $data)){ $errorResponse[] = 'In this field, you most often use exclusively English characters!'; }
	}
	else if($label == 'objectCountry' || $label == 'objectRegion'){
		if($data == ''){
			if($label == 'objectRegion'){ $errorResponse[] = 'No region entered!'; }
			else{ $errorResponse[] = 'No country entered!'; }
		}
	}
	else if($label == 'description'){
		if(!preg_match('/[^A-Za-z]/', $string)){ $errorResponse[] = 'In this field, you most often use exclusively English characters!'; }
	}
	else if($label == 'content'){
		if(isset($_COOKIE['objectAttribute'])){
			$category = $_COOKIE['objectAttribute'];
			
			if($database->connect_error){
				$listFilters = 'SELECT field, type FROM objectdata_filters WHERE name=:c';
				$listFilters .= $database->prepare($listFilters)->execute(['c' => $category]);
				
				$queryFilter = explode(PHP_EOL, $data);
				
				if(!count($queryFilters) == $listFilters->num_rows){ $errorResponse[] = 'The number of parameters entered does not match the number of required parameters!'; }
				
				while($row = $listFilters->fetch_assoc()){
					for($i = 0; $i < count($queryFilters); $i++){
						$queryField = explode(' - ', $queryFilters[$i]);
						if($row["field"] == $queryField[0]){
							switch($row["type"]){
								case 'int':
									if(!ctype_digit($queryField[1])){ $errorResponse[] = 'Only numbers are accepted in this field'; }
								break;
								case 'precentable':
									if(!ctype_digit($queryField[1])){ $errorResponse[] = 'Only numbers are accepted in this field'; }
									else{
										if($queryField[1] >= 100){ $errorResponse[] = 'Numbers less than or equal to 100 are accepted here'; }
									}
								break;
								case 'cost':
									if(!ctype_digit($queryField[1])){ $errorResponse[] = 'Either digits or floating-point digits are accepted in this field'; }
									else{
										if($queryField[1] >= 67000000000000){ $errorResponse[] = 'Numbers are accepted here, or floating-point numbers! Condition: Data less than or equal to 67 trillion dollars'; }
									}
								break;
								case 'selecting':
									if(($queryField[1] != 'Yes') || ($queryField[1] != 'No')){ $errorResponse[] = 'In this field, enter either "Yes" or "No" without punctuation marks!'; }
								break;
								case 'default':
									if(!preg_match('/[^A-Za-z]/', $queryField[1])){ $errorResponse[] = 'In this field, you most often use exclusively English characters!'; }
								break;
							}
						}
					}
				}
				
				
				
			}
		}
	}
	
	return $errorResponse;
}

function sendProccess($data){
		$database = connector();
		$galleryList = function($service, $q){
			
			$readyData = [];
			
			if($service == 'content'){
				$param = [];
				
				$contentData = explode(PHP_EOL, $q['content']);
				
				for($i = 0; $i < count($contentData); $i++){ 
					$dataResult = explode(' - ', $contentData[$i]);
					$param[] = [$dataResult[0] => $dataResult[1]]; 
				}
				
				$readyData = $param;
			}
			
			return $readyData;
		};
		
		$paramData = $galleryList('content', $data);
		
		$contentQuery = [
				'meta' => [
					'description' => $data['description'],
					'region' => [
						'country' => $data['objectCountry'],
						'region' => $data['objectRegion']
					]
				],
				'content' => [
					'parameters' => $paramData,
					'cost' => $data['objectCost']
				]
		];
		
		$metaTitle = $data['objectTitle'];
		$metaCategory = $data['objectAttribute'];
		
		$jsonContent = $contentQuery;
		
		
		$queryParam = [
			't' => $metaTitle,
			'c' => $metaCategory,
			'j' => json_encode($jsonContent, JSON_UNESCAPED_SLASHES),
			'user' => $_COOKIE['portalId']
		];
		$query = 'INSERT INTO objectData (title, category, content, creator) VALUES(:t, :c, :j, :user)';
		$queryTRUE = $database->prepare($query);
		$executeData = $queryTRUE;
		
		return $executeData ? ['message' => 'The object has been successfully added to the portal!', 'error' => $executeData->errorInfo(), 'source' => $queryParam, 'query' => $data['content']] : ['message' => 'The registration of this object failed', 'error' => $executeData->errorInfo()];
}

if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))){
	$readyResponse = [];
	
    if(isset($_GET['command'])){
		if($_GET['command'] == 'submit'){
			if(isset($_POST['query'])){
				$queryResponse = json_decode($_POST['query'], true);
				$readyResponse = sendProccess($queryResponse);
			}
		}
		else if($_GET['command'] == 'valid'){
			if(isset($_POST['query'])){
				$query = json_decode($_POST['query'], true);
				if(isset($query['multivalidator'])){
					$multivalid = [];
					for($i = 0; $i < count($query['multivalidator']['label']); $i++){ $multiValid[] = validData($query['multivalidator']['label'][$i], $query['multivalidator']['value'][$i]); }
					$validResponse = $multiValid;
				}
				else{
					$validResponse = validData($query['label'], $query['value']);
				}
			}
			
			$readyResponse = $validResponse;
		}
	}
	
	header('Content-Type: application/json; charset=utf-8');
    echo json_encode($readyResponse);
}
?>
