<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\Html;

class PortalServiceKernel extends Component{
	public function init(){ parent::init(); }
	public function formGenerator($block, $newField){
		$formResponse = NULL;
		
		if($block == 'header'){ $formResponse = 'Step ' . $newField['stepN'] . ': ' . $newField['stepT']; }
		else if($block == 'content'){
			$formContent = NULL;
			
			if($newField['type'] == 'upload'){
				$ufld = '';
				
				foreach($newField['form'] as $generator){
					
					$labelContent = Html::tag('span', $generator['name']);
					$labelContent .= Html::fileInput($generator['fieldName'], '', ['class' => $generator['fieldName'], 'placeholder' => $generator['dExample'], 'id' => 'upload-field', 'multiple' => $generator['isMultiple'] ? TRUE : FALSE]);
					$labelContent .= Html::hiddenInput($generator['fieldName'], '', ['class' => $generator['fieldName'], 'id' => 'hidden-field']);
					
					$ufld .= Html::label($labelContent, $generator['fieldName']);
				}
				
				$formContent = Html::tag('div', $newField['stepD'], ['id' => 'header']);
				$formContent .= Html::tag('div', $ufld, ['id' => 'body']);
			}
			else if($newField['type'] == 'default'){
				$dfld = '';
				
				foreach($newField['form'] as $generator){
					$labelContent = Html::tag('span', $generator['name']);
					$labelContent .= Html::input('text', $generator['fieldName'], '', ['class' => $generator['fieldName'], 'placeholder' => $generator['dExample'], 'id' => 'default-field']);
					
					$dfld .= Html::label($labelContent);
				}
				
				$formContent = Html::tag('div', $newField['stepD'], ['id' => 'header']);
				$formContent .= Html::tag('div', $dfld, ['id' => 'body']);
			}
			else if($newField['type'] == 'search'){
				$sfld = '';
				$searchres = '';
				
				foreach($newField['form'] as $generator){
					
					$dataSource = file_get_contents($generator['dSource']);
					$list = json_decode($dataSource, true);
					
					if($generator['optionData']['needDataList']){ for($i = 0; $i < count($list); $i++){ $searchres .= '<option value="' . $list[$i][$generator['optionData']['needDataList']] . '">'; } }
					else{ for($i = 0; $i < count($list); $i++){ $searchres .= '<option value="' . $list[$i]['name'] . '">'; } }
					
					
					$labelContent = Html::tag('span', $generator['name']);
					$labelContent .= Html::input('search', $generator['fieldName'], '', ['class' => $generator['fieldName'], 'list' => $generator['fieldName'], 'placeholder' => $generator['dExample'], 'id' => 'search-field']);
					$labelContent .= '<datalist id="' . $generator['fieldName'] . '">'. $searchres . '</datalist>';
					
					$sfld .= Html::label($labelContent);
					
				}
				
				$formContent = Html::tag('div', $newField['stepD'], ['id' => 'header']);
				$formContent .= Html::tag('div', $sfld, ['id' => 'body']);
			}
			else if($newField['type'] == 'queryContent'){
				$sfld = '';
				
				foreach($newField['form'] as $generator){
					$labelContent = Html::tag('span', $generator['name']);
					$labelContent .= Html::textarea($generator['fieldName'], '', ['class' => $generator['fieldName'], 'wrap' => 'soft', 'placeholder' => $generator['dExample'], 'id' => 'content-field']);
					$sfld .= Html::label($labelContent);
				}
				
				$formContent = Html::tag('div', $newField['stepD'], ['id' => 'header']);
				$formContent .= Html::tag('div', $sfld, ['id' => 'body']);
			}
			
			$formResponse = $formContent;
		}
		else if($block == 'footer'){
			$buttonData = $newField['isLast'] ? 'Send query' : 'Countine';
			$formResponse = Html::tag('div', Html::button($buttonData, ['id' => 'action']), ['id' => 'body']);
		}
		
		return Html::decode($formResponse);
	}
}
