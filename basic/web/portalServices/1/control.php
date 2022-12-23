<?php 

function formGenerator($container){
	$readyForm = [];
	
	if($container == 'header'){
		$readyForm = [
				[
					'stepN' => 1,
					'stepT' => 'Entering personal data about the object'
				],
				[
					'stepN' => 2,
					'stepT' => 'Selecting an object attribute'
				],
				[
					'stepN' => 3,
					'stepT' => 'Enter the country where this object is located'
				],
				[
					'stepN' => 4,
					'stepT' => 'Enter brief information about your investment object and its parameters'
				]
		];
	}
	else if($container == 'body'){
		$readyForm = [
			[
						'type' => 'default',
						'stepD' => 'Enter the name of the object and its value in dollars. If you are only interested in the currency of your region, it will be important for us that many investors are interested in your object. Depending on the currency that the user has chosen in the portal services, it automatically converts dollars into any currency, thanks to the technology of daily conversion. You can transfer the amount of any currency to the dollar <a href="https://fx-rate.net/EUR/USD/" target="_blank">here</a>.',
						'form' => [
							[
								'name' => 'Object title',
								'fieldName' => 'objectTitle',
								'dExample' => 'Hotel Reddison'
							],
							[
								'name' => 'Object cost(in USD)',
								'fieldName' => 'objectCost',
								'dExample' => '10000'
							]
							
						]
			],
			[
						'type' => 'search',
						'stepD' => 'Choose the attribute that your object is most likely to relate to!',
						'form' => [
							[
								'name' => 'Object attribute',
								'fieldName' => 'objectAttribute',
								'dExample' => 'SPA Centers',
								'dSource' => (!empty($_SERVER['HTTPS'])) ? 'https' : 'http' . '://' . $_SERVER['HTTP_HOST'] . '/objects/api/get?sheet=attribute'
							]
							
						]
			],
			[
						'type' => 'search',
						'stepD' => 'Enter the first letters and the autofill technology will give you an accurate list of countries on request, where you can quickly select the country of the world you need, for which information about the object is placed',
						'form' => [
							[
								'name' => 'Object country',
								'fieldName' => 'objectCountry',
								'dExample' => 'Spain',
								'dSource' => (!empty($_SERVER['HTTPS'])) ? 'https' : 'http' . '://' . $_SERVER['HTTP_HOST'] . '/services/api/0/get',
								'optionData' => ['needDataList' => 'title']
							],
							[
								'name' => 'Object region',
								'fieldName' => 'objectRegion',
								'dExample' => 'Madrid',
								'dSource' => (!empty($_SERVER['HTTPS'])) ? 'https' : 'http' . '://' . $_SERVER['HTTP_HOST'] . '/services/api/0/get?sheet=regions',
								'optionData' => ['needDataList' => 'region']
							]
							
						]
			],
			[
						'type' => 'queryContent',
						'stepD' => 'Describe your object and its features. Then specify the filters and parameters of your object in the "Filter - value" format in accordance with the data filtering standards set in the selected attribute',
						'form' => [
							[
								'name' => 'Object description',
								'fieldName' => 'description',
								'dExample' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sodales neque sodales ut etiam sit amet nisl. At lectus urna duis convallis convallis tellus. Risus pretium quam vulputate dignissim suspendisse. Neque laoreet suspendisse interdum consectetur libero. Odio pellentesque diam volutpat commodo sed. Sed pulvinar proin gravida hendrerit lectus. Volutpat lacus laoreet non curabitur. Arcu dui vivamus arcu felis bibendum ut tristique et egestas. Eu facilisis sed odio morbi quis. Malesuada fames ac turpis egestas.'
							],
							[
								'name' => 'Object parameters',
								'fieldName' => 'content',
								'dExample' => ''
							],
							
						]
			]
		];
	}
	else if($container == 'footer'){
		$readyForm = [
			[ 'isLast' => FALSE ],
			[ 'isLast' => FALSE ],
			[ 'isLast' => FALSE ],
			[ 'isLast' => TRUE ]
		];
	}
	
	return $readyForm;
}

if (!count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))){
    $readyResponse = [
		'steps' => [
			'header' => formGenerator('header'),
			'content' => formGenerator('body'),
			'footer' => formGenerator('footer')
		]
	];
	
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($readyResponse);
}
?>
