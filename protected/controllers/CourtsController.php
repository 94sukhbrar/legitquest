<?php

/**
 *@copyright : Amusoftech Pvt. Ltd. < www.amusoftech.com >
 *@author	 : Amu < er.amu@live.com >
 */

namespace app\controllers;

use Yii;
use app\models\Courts;
use app\models\search\Courts as CourtsSearch;
use app\components\TController;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use app\models\User;
use yii\web\HttpException;
use app\components\TActiveForm;

/**
 * CourtsController implements the CRUD actions for Courts model.
 */
class CourtsController extends TController
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'ruleConfig' => [
					'class' => AccessRule::className()
				],
				'rules' => [
					[
						'actions' => [
							'index',
							'add',
							'view',
							'update',
							'delete',
							'ajax',
							'mass'
						],
						'allow' => true,
						'roles' => [
							'?',
							'*',
							'@'
						]
					],
					[
						'actions' => [

							'view',
						],
						'allow' => true,
						'roles' => [
							'?',
							'*'
						]
					]
				]
			],
			'verbs' => [
				'class' => \yii\filters\VerbFilter::className(),
				'actions' => [
					'delete' => [
						'post'
					],
				]
			]
		];
	}


	/**
	 * Lists all Courts models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new CourtsSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$this->updateMenuItems();
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Courts model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);
		$this->updateMenuItems($model);
		return $this->render('view', ['model' => $model]);
	}

	/**
	 * Creates a new Courts model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionAdd()
	{
		$model = new Courts();
		$model->loadDefaultValues();
		//$model->state_id = Courts::STATE_ACTIVE;
		$post = \yii::$app->request->post();
		if (\yii::$app->request->isAjax && $model->load($post)) {
			\yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return TActiveForm::validate($model);
		}
		if ($model->load($post) && $model->save()) {
			return $this->redirect($model->getUrl());
		}
		$this->updateMenuItems();
		return $this->render('add', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing Courts model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		$post = \yii::$app->request->post();
		if (\yii::$app->request->isAjax && $model->load($post)) {
			\yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return TActiveForm::validate($model);
		}
		if ($model->load($post) && $model->save()) {
			return $this->redirect($model->getUrl());
		}
		$this->updateMenuItems($model);
		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing Courts model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);

		$model->delete();
		return $this->redirect(['index']);
	}

	/**
	 * Finds the Courts model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Courts the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id, $accessCheck = true)
	{
		if (($model = Courts::findOne($id)) !== null) {

			if ($accessCheck && !($model->isAllowed()))
				throw new HttpException(403, Yii::t('app', 'You are not allowed to access this page.'));

			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
	protected function updateMenuItems($model = null)
	{

		switch (\Yii::$app->controller->action->id) {

			case 'add': {
					$this->menu['manage'] = [
						'label' => '<span class="glyphicon glyphicon-list"></span>',
						'title' => Yii::t('app', 'Manage'),
						'url' => [
							'index'
						],
						 	'visible' => true
					];
				}
				break;
			case 'index': {
					$this->menu['add'] = [
						'label' => '<span class="glyphicon glyphicon-plus"></span>',
						'title' => Yii::t('app', 'Add'),
						'url' => [
							'add'
						],
						'visible' => true
					];
				}
				break;
			case 'update': {
					$this->menu['add'] = [
						'label' => '<span class="glyphicon glyphicon-plus"></span>',
						'title' => Yii::t('app', 'add'),
						'url' => [
							'add'
						],
						'visible' => true
					];
					$this->menu['manage'] = [
						'label' => '<span class="glyphicon glyphicon-list"></span>',
						'title' => Yii::t('app', 'Manage'),
						'url' => [
							'index'
						],
						'visible' => true
					];
				}
				break;
			default:
			case 'view': {
					$this->menu['manage'] = [
						'label' => '<span class="glyphicon glyphicon-list"></span>',
						'title' => Yii::t('app', 'Manage'),
						'url' => [
							'index'
						],
						//	'visible' => User::isAdmin ()
					];
					if ($model != null) {
						$this->menu['update'] = [
							'label' => '<span class="glyphicon glyphicon-pencil"></span>',
							'title' => Yii::t('app', 'Update'),
							'url' => $model->getUrl(),
							//		'visible' => User::isAdmin ()
						];
						$this->menu['delete'] = [
							'label' => '<span class="glyphicon glyphicon-trash"></span>',
							'title' => Yii::t('app', 'Delete'),
							'url' => $model->getUrl()
							//	 'visible' => User::isAdmin ()
						];
					}
				}
		}
	}
}
