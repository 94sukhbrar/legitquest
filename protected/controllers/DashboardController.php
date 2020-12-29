<?php

/**
 *@copyright :Amusoftech Pvt. Ltd. < www.amusoftech.com >
 *@author     : Ram mohamad Singh< er.amudeep@gmail.com >
 */

namespace app\controllers;

use app\components\TController;
use app\models\User;
use app\components\filters\AccessControl;
use app\components\TActiveForm;
use app\models\ScrapperForm;
use app\models\Setting;
use Yii;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use yii\web\Response;
 
class DashboardController extends TController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'default-data',
                            'scrapper',
                            'download-pdf'
                        ],
                        'allow' => true,
                        'matchCallback' => function () {
                            return User::isAdmin()||User::isGuest()||User::isUser();
                        }
                    ]
                ]
            ]
        ];
    }

    public function actionIndex($model = null)
    {
        $this->layout = User::LAYOUT_LEGITQUEST;
        $form_model = new ScrapperForm();
        if (!empty($model)) {

            return $this->render('index', [
                'model' => $model,
                'form_model'=> $form_model
            ]);
        } else {
           $result = $form_model->getRecordsFromApi(/*no argm mesna dfault  ['lower_date'=>'2020-01-01', 'higher_date'=>'2020-01-01'] */);             
            
          
            $provider = new ArrayDataProvider([
                'allModels' =>$result,
                'sort' => [
                    'attributes' => ['id', 'username', 'email'],
                ],
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
            $pages = new Pagination(['totalCount' => $provider->getTotalCount() ]);

            /* $cases = $provider->getModels();
            print_r($cases  ); 
            die;
 */
            /* return $this->render('_gridView', [
                'dataProvider' => $provider,
                'form_model'=> $form_model
            ]); */
            
             return $this->render('index', [
                 'dataProvider' => $provider,
                'model' => $result,
                'pages'=>$pages,
                'form_model'=> $form_model
            ]);  
        }

        return $this->redirect('scrapper',[
            'form_model'=> $form_model
        ]);
    }

    public function actionScrapper()
    {
        $this->layout = User::LAYOUT_LEGITQUEST;
        $model = new ScrapperForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;         
            return TActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $result = $model->getRecordsFromApi([
                'lower_date'=>$model->start_date,
                'higher_date'=>$model->end_date,
                'limit'=>$model->limit,
                'offset'=>$model->offset,
                'target'=>'JU'
            ]);                        
            
            return $this->render('index', [
                'model' => $result,
                'form_model' =>  $model
            ]);
        }
        return $this->render('scrapper', [
            'model' => $model,
            'form_model' =>  $model
        ]);
    }

    public function actionDownloadPdf($id,$target=null)
    {
        $model = new ScrapperForm();
        $result = $model->getPDFFromApi([
            'id_num'=>$id,
            'target'=>!empty($target)?$target:'DO'
        ]); 
        return $result[0]->link;
        //print_r($result);die;
    }



    public static function MonthlySignups()
    {
        $date = new \DateTime();
        $date->modify('-12  months');
        $count = array();
        for ($i = 1; $i <= 12; $i++) {
            $date->modify('+1 months');
            $month = $date->format('Y-m');

            $count[$month] = (int) User::find()->where([
                'like',
                'created_on',
                $month
            ])
                ->andWhere([
                    '!=',
                    'role_id',
                    User::ROLE_ADMIN
                ])
                ->count();
        }
        return $count;
    }

    public function actionDefaultData()
    {
        Setting::setDefaultConfig();
        $msg = 'Done !! Setting reset succefully!!!';
        \Yii::$app->session->setFlash('success', $msg);
        return $this->redirect(\Yii::$app->request->referrer);
    }
    
}
