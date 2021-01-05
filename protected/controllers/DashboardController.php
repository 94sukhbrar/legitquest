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
                            'download-pdf',
                            'data-index'
                        ],
                        'allow' => true,
                        'matchCallback' => function () {
                            return User::isAdmin() || User::isGuest() || User::isUser();
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
                'form_model' => $form_model
            ]);
        } else {
            //OFFSET IS NOT CORRET, NEEDS TO FIX AND TEST 
            $result = $form_model->getRecordsFromApi(
                ['lower_date' => '2020-01-01', 'higher_date' => '2020-12-11',     'limit' => '30', 'offset' => $form_model->limit * isset(Yii::$app->request->queryParams['page'])  ? Yii::$app->request->queryParams['page'] : 0, 'target' => 'JU']
            );
            //  die("xxx");

            $provider = new ArrayDataProvider([
                'allModels' => $result,
                'sort' => [
                    'attributes' => ['id', 'username', 'email'],
                ],
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
            $pages = new Pagination(['totalCount' => $provider->getTotalCount()]);

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
                'pages' => $pages,
                'form_model' => $form_model
            ]);
        }

        return $this->redirect('scrapper', [
            'form_model' => $form_model
        ]);
    }

    public function actionDataIndex()
    {
        $target = $_REQUEST['court'];
        $form_model = new ScrapperForm();
        $allData = $form_model->getDashboardRecordsFromApi(
            ['target' =>$target,'count'=>'100']
        );
     // print_r($allData);die;

        $numRows = array_sum($allData);
        $resultData=[];
       
        foreach($allData as $result){
            $empRows = array();
            $empRows[] = $result->id_num;         
            $empRows[] = $result->case_number;
            $empRows[] = $result->case_type;
            $empRows[] = $result->case_year;
            $empRows[] = $result->order_type;
            $empRows[] = '<a href='.$result->link.' style="color:#3051d3">PDF [Documents]</a>';
           $resultData[] = $empRows;
        }
        $output = array(
            //"draw"    =>    intval($_POST["draw"]),
            "iTotalRecords"    =>     $numRows,
            "iTotalDisplayRecords"    =>  10,
            "data"    =>     $resultData
        );
        return json_encode($output);
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
            $result = $model->highCourtScraper([
                'state_name' =>   $model->cleanStateName ( Yii::$app->params['stateList'][$model->court]) ,
                'start_date' => $model->start_date,
                'end_date' => $model->end_date,                
                'target' => $model->scrap_type,
                'court_code' => $model->court
            ]); 

            /* $provider = new ArrayDataProvider([
                'allModels' => $result,
                'sort' => [
                    'attributes' => ['id', 'username', 'email'],
                ],
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
            $pages = new Pagination(['totalCount' => $provider->getTotalCount()]);

            return $this->render('index', [
                'dataProvider' => $provider,
                'pages' => $pages,
                'model' => $result,
                'form_model' =>  $model
            ]);  */

            return $this->redirect([
                '/dashboard/index'
            ]);


        }
        return $this->render('scrapper', [
            'model' => $model,
            'form_model' =>  $model
        ]);
    }

    public function actionDownloadPdf($id, $target = null)
    {

        $model = new ScrapperForm();
        $result = $model->getPDFFromApi([
            'id_num' => $id,
            'target' => !empty($target) ? $target : 'DO'
        ]);

        if (!empty($result)) {
            $data = '';
            foreach ($result as $key => $val) {
                $data .= "<a href=" . $val->link . ">PDF [Documents " . $key . "] </a><br />";
            }
            print_r($data);
            die;

            $response = [
                'status' => true,
                'message' => 'success',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Document not exist!'
            ];
        }

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
