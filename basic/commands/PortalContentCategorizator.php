<?php

namespace app\commands;

use yii\console\Controller;

use app\models\News;
use app\models\Analytic;
use app\models\Event;

class PortalContentCategorizatorController extends Controller{
    public function actionNews(){
		$withoutMatherialCategories = News::find()->where(['category' => NULL])->all();
		$statusFinish = [[0,0],1];
		
		foreach($withoutMatherialCategories as $dataset){
			$currentTitle = $dataset->title;
			
			$readyContent = preg_replace("/<img[^>]+\>/i", "", $dataset->content);
			$readyContent = preg_replace('/\t+/', '', $readyContent);
			$readyContent = strip_tags($readyContent);
			
			$currentContent = $readyContent;
			$readyResponse = Yii::$app->cloudCategorizator->execute('news', [$currentTitle, $readyContent]);
			
			$currentMatherial = News::findOne(['id' => $dataset->id]);
			$currentMatherial->category = $readyResponse;
			
			if($currentMatherial->save()){ $statusFinish[0][0]++; }
			else{ $statusFinish[0][1]++; }
		}
		
		if(($statusFinish[0][0] > 1 || $statusFinish[0][0] == 1) && $statusFinish[0][1] == 0){ $statusFinish[1] = 0; }
		
		return $statusFinish[1];
	}
	public function actionAnalytics(){
		$withoutMatherialCategories = Analytic::find()->where(['category' => NULL])->all();
		$statusFinish = [[0,0],1];
		
		foreach($withoutMatherialCategories as $dataset){
			$currentTitle = $dataset->title;
			
			$readyContent = preg_replace("/<img[^>]+\>/i", "", $dataset->content);
			$readyContent = preg_replace('/\t+/', '', $readyContent);
			$readyContent = strip_tags($readyContent); 
			
			$currentContent = $readyContent;
			$readyResponse = Yii::$app->cloudCategorizator->execute('analytic', [$currentTitle, $readyContent]);
			
			$currentMatherial = Analytic::findOne(['id' => $dataset->id]);
			$currentMatherial->category = $readyResponse;
			
			if($currentMatherial->save()){ $statusFinish[0][0]++; }
			else{ $statusFinish[0][1]++; }
		}
		
		if(($statusFinish[0][0] > 1 || $statusFinish[0][0] == 1) && $statusFinish[0][1] == 0){ $statusFinish[1] = 0; }
		
		return $statusFinish[1];
	}
	public function actionEvents(){
		$withoutEventCategories = Event::find()->where(['tematic' => NULL, 'type' => NULL])->all();
		$statusFinish = [[0,0],1];
		
		foreach($withoutMatherialCategories as $dataset){
			$currentTitle = $dataset->title;
			
			$readyContent = preg_replace("/<img[^>]+\>/i", "", $dataset->content);
			$readyContent = preg_replace('/\t+/', '', $readyContent);
			$readyContent = strip_tags($readyContent); 
			
			$currentContent = $readyContent;
			$readyResponse = Yii::$app->cloudCategorizator->execute('event', [$currentTitle, $readyContent]);
			
			$currentMatherial = Event::findOne(['id' => $dataset->id]);
			$currentMatherial->tematic = $readyResponse[0];
			$currentMatherial->type = $readyResponse[1];
			
			if($currentMatherial->save()){ $statusFinish[0][0]++; }
			else{ $statusFinish[0][1]++; }
		}
		
		if(($statusFinish[0][0] > 1 || $statusFinish[0][0] == 1) && $statusFinish[0][1] == 0){ $statusFinish[1] = 0; }
		
		return $statusFinish[1];
	}
}
