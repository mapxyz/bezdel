<?php

namespace console\controllers;

use common\models\Orders;
use common\repository\OrderRepository;
use common\services\OrderLoadService;
use Yii;
use yii\base\InvalidParamException;
use yii\httpclient\Client;
use Exception;

class OrderController extends \yii\console\Controller
{

	public function actionUpdateNet(string $file)
	{
		$object = Yii::$container->get(OrderLoadService::class);
		try {
			$client = new Client([
				'parsers' => [
					Client::FORMAT_JSON => [
						'class' => 'yii\httpclient\JsonParser',
						'asArray' => true,
					]
				],
			]);
			$response = $client->createRequest()->setUrl($file)->send();
		} catch (Exception $e) {
			die($e->getMessage());
		}

		$object->setData($response->data['orders']);
		$object->load();

	}

	public function actionUpdateLocal(string $file)
	{
		$object = Yii::$container->get(OrderLoadService::class);
		try {
			 if(is_file(__DIR__.$file)){
				 $data = file_get_contents(__DIR__.$file);
				 if($data){
					 $data = json_decode($data,true);
				 }
			 }
			 if(!is_array($data) || !count($data['orders'])){
				 throw new Exception("wrong file");
			 }
		} catch (Exception $e) {
			die($e->getMessage());
		}

		$object->setData($data['orders']);
		$object->load();
	}

	public function actionInfo(int $id)
	{
		$model = Orders::find()->where(['order_id'=>$id])->one();
		if($model){
			$formatter = \Yii::$app->formatter;
			$data = $model->toArray();
			$data['created_at'] = $formatter->asDate($data['created_at']);
			$data['updated_at'] = $formatter->asDate($data['updated_at']);
			echo json_encode($data);
		}else{
			echo 'error';
		}


	}
}