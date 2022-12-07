<?php 

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

$database = new mysqli($remoteConnect['ds'][0], $remoteConnect['u'], $remoteConnect['p'], $remoteConnect['ds'][1]);

function validData($label, $data){
	
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
				$listFilters = 'SELECT field, type FROM objectdata_filters WHERE name=$category';
				$listFilters .= $database->query($listFilters);
				
				$queryFilter = explode(' - ', $data);
				
				if(!count($queryFilters[0]) == $listFilters->num_rows){ $errorResponse[] = 'The number of parameters entered does not match the number of required parameters!'; }
				
				while($row = $listFilters->fetch_assoc()){
					for($i = 0; $i < count($queryFilters[0]); $i++){
						if($row["field"] == $queryFilters[0][$i]){
							switch($row["type"]){
								case 'int':
									if(!ctype_digit($queryFilters[1][$i])){ $errorResponse[] = 'Only numbers are accepted in this field'; }
								break;
								case 'precentable':
									if(!ctype_digit($queryFilters[1][$i])){ $errorResponse[] = 'Only numbers are accepted in this field'; }
									else{
										if($queryFilters[1][$i] >= 100){ $errorResponse[] = 'Numbers less than or equal to 100 are accepted here'; }
									}
								break;
								case 'cost':
									if(!ctype_digit($queryFilters[1][$i])){ $errorResponse[] = 'Either digits or floating-point digits are accepted in this field'; }
									else{
										if($queryFilters[1][$i] >= 67000000000000){ $errorResponse[] = 'Numbers are accepted here, or floating-point numbers! Condition: Data less than or equal to 67 trillion dollars'; }
									}
								break;
								case 'selecting':
									if(($queryFilters[1][$i] != 'Yes') || ($queryFilters[1][$i] != 'No')){ $errorResponse[] = 'In this field, enter either "Yes" or "No" without punctuation marks!'; }
								break;
								case 'default':
									if(!preg_match('/[^A-Za-z]/', $queryFilters[1][$i])){ $errorResponse[] = 'In this field, you most often use exclusively English characters!'; }
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
	if(!$database->connect_error){
		
		$galleryList = function($service){
			
			$readyData = [];
			
			
			
			if($service == 'content'){
				$param = [];
				
				$contentData = explode(PHP_EOL, $data['content']);
				$contentData .= explode('-', $contentData);
				
				for($i = 0; $i < count($contentData[0]); $i++){ $param[] = [$contentData[0][$i] => $contentData[1][$i]]; }
				
				$readyData = $param;
			}
			
			return $readyData;
		};
		
		$paramData = $galleryList('content');
		
		$contentQuery = [
				'meta' => [
					'description' => $data['description'],
					'region' => [
						'country' => $data['objectCountry'],
						'region' => $data['objectRegion']
					],
					'mediagallery' => []
				],
				'content' => [
					'parameters' => $paramData
				]
		];
		
		$metaTitle = $data['objectTitle'];
		$metaCategory = $data['objectAttribute'];
		
		$jsonContent = $contentQuery;
		
		$query = 'INSERT INTO objectData (title, category, content, creator) VALUES($metaTitle, $metaCategory, $jsonContent, $creator)';
		$queryTRUE = $database->query($query);
		
		return successSend($queryTRUE);
	}
}

function successSend($state){
	$finalResponse = [];
	
	if($state){
		$finalResponse = [
			'state' => 0,
			'message' => 'The object has been successfully added to the portal!'
		];
	}
	else{
		$finalResponse = [
			'state' => 1,
			'message' => 'The registration of this object failed'
		];
	}
	
	return $finalResponse;
	
}

if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))){
	$readyResponse = [];
	
    if(isset($_GET['command'])){
		if($_GET['command'] == 'submit'){
			if(isset($_POST['query'])){
				$query = json_decode($_POST['query'], true);
				$sendResponse = sendProccess($query['query']);
			}
			
			$readyResponse = $sendResponse;
		}
		else if($_GET['command'] == 'valid'){
			if(isset($_POST['query'])){
				$query = json_decode($_POST['query'], true);
				if($query['multivalidator']){
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
