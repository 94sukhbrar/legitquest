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
                            'data-index',
                            'log'
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

    public function actionLog()
    { 
        $this->layout = User::LAYOUT_LEGITQUEST;
        $model = new ScrapperForm();
        $modelData=  $model->getLogsFromApi();
        return $this->render('logs', [ 
            'model' => $modelData
        ]);


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
            ['target' => $target, 'count' => '1000']
        );
        // print_r($allData);die;

        $numRows = array_sum($allData);
        $resultData = [];
        
            foreach ($allData as $result) {
               /*  echo "<pre>";
                print_r($result);
                die; */

                $empRows = array();
                $empRows[] =  isset( $result->case_number)  ?  $result->case_number : "NA";
                $empRows[] =  isset(  $result->diary_number) ?   $result->diary_number : "NA";
                $empRows[] =  isset( $result->petitioner_name)  ?  $result->petitioner_name : "NA";
                $empRows[] =  isset( $result->respondent_name)  ?  $result->respondent_name : "NA";
                $empRows[] =  isset( $result->petitioner_advocate)  ?  $result->petitioner_advocate : "NA";
                $empRows[] =  isset( $result->respondent_advocate)  ?  $result->respondent_advocate : "NA";
                $empRows[] =  isset( $result->bench)  ?  $result->bench : "NA";
                $empRows[] =  isset( $result->judgement_by)  ?  $result->judgement_by : "NA";
                $empRows[] =  isset( $result->date)  ?  $result->date :  $result->order_date ;
                $empRows[] =  isset( $result->case_type)  ?  $result->case_type : "NA";
                $empRows[] =  isset( $result->case_year)  ?  $result->case_year : "NA";
                $empRows[] =  isset( $result->order_type)  ?  $result->order_type : "NA";

                $empRows[] = isset( $result->link )   ?   " <a href='$result->link' style='color:#3051d3'>PDF [Documents]</a>"  : "NA";

                //$empRows[] = '<a href=' . isset( $result->link ) ?  $result->link : "NA". ' style="color:#3051d3">PDF [Documents]</a>';
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
        $post = Yii::$app->request->post();
        $model = new ScrapperForm();
        if (Yii::$app->request->isAjax && $model->load($post)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return TActiveForm::validate($model);
        }
        if ($model->load($post)) {

            if ($model->court === ScrapperForm::SupreameCourt) {
                //COURT TYPE IS SUPREAME COURT
                if ($model->scrap_type  === ScrapperForm::Judgements) {
                    #scraping Judgements
                    $model->supremeCourtJudgementsApi([
                        'start_date' => $model->start_date,
                        'end_date' => $model->end_date
                    ]);
                } else {
                    #scraping Orders
                    $model->supremeCourtOrdersApi([
                        'start_date' => $model->start_date,
                        'end_date' => $model->end_date
                    ]);
                }
            } else
                {
                  

                    $model->highCourtScraper([
                    'state_name' =>   $model->cleanStateName(Yii::$app->params['stateList'][$model->court]),
                    'start_date' => $model->start_date,
                    'end_date' => $model->end_date,                     
                ]);

                Yii::$app->session->setFlash('info', "Your data is being scrapped for ".  $model->start_date." - ".$model->end_date );

            
            }

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
