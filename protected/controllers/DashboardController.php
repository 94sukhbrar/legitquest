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
use app\models\ModelApiHelper;
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
                            'log',
                            'court',
                            'full-info',
                            'full-data-index'
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
        $modelData =  $model->getLogsFromApi();

        $provider = new ArrayDataProvider([
            'allModels' =>  $modelData,
            'sort' => [
                'attributes' => ['supreme_court', 'state_name', 'date_range', 'timestamp'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('_grid_view_log', [
            'dataProvider' => $provider,
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
            return $this->render(/* 'index' */'index_v2', [
                'dataProvider' => $provider,
                'model' => $result,
                'pages' => $pages,
                'form_model' => $form_model
            ]);
        }

        return $this->redirect('dashboard'/* 'scrapper' */, [
            'form_model' => $form_model
        ]);
    }
    public function actionCourt($court = null)
    {

        $mm = new ModelApiHelper();
        $columns = $mm->getTableSchema()->columns;

        $this->layout = User::LAYOUT_LEGITQUEST;
        Yii::$app->view->params['selectedCourt'] = $court;
        return $this->render('_dataTable', [
            'columns' => $columns
        ]);
    }
    public function actionFullInfo($court = null)
    {
        $this->layout = User::LAYOUT_LEGITQUEST;
        Yii::$app->view->params['selectedCourt'] = $court;
        return $this->render('_dataTable_full_info', []);
    }

    public function encodUrlForPdf($TEMP_LINK)
    {
        $lastIndex = strrpos($TEMP_LINK, "/", -1) + 1;
        $encoded = urlencode(substr($TEMP_LINK,  $lastIndex));
        $TEMP_LINK = substr($TEMP_LINK, 0, $lastIndex) .  $encoded;
        return  $TEMP_LINK;
    }
    public function actionDataIndex()
    {
        ini_set('memory_limit', '8192M');

        $target = $_REQUEST['court'];
        $lower_date = isset($_REQUEST['lower_date']) ?  $_REQUEST['lower_date'] :  date('Y-m-d', strtotime(date('Y-m-d') . ' - 15 days'));
        $higher_date = isset($_REQUEST['higher_date']) ?  $_REQUEST['higher_date'] : date('Y-m-d', strtotime(date('Y-m-d') . ' + 15 days'));
        $form_model = new ScrapperForm();

        $urlAndViewFile = $form_model->apiUrlDecider($target);
        /* print_r($urlAndViewFile);
        die($target); */
        $columnNames = Yii::$app->params['constants']['columnNames'];
        $allData = [];
        /*  echo $lower_date."< >". $higher_date;
        die; */
        $mm = new ModelApiHelper();
        $modelssss = $mm->getDataByCourt($target, $lower_date, $higher_date);

        //   echo "<pre>";

        /* try {
            $allData = $form_model->getByWeek(
                ['target' => $target,   'lower_date' => $lower_date, 'higher_date' =>  $higher_date]
            );
        } catch (\Throwable $th) {
        }

 */
        //echo "<pre>";
        $resultData = [];
        $numRows = array_sum(isset($modelssss) ? (array)$modelssss :  []);
        foreach ($modelssss as $key => $value) {
            $empRows = array();
            //  print_r($value->getTableSchema()->columns);
            foreach (/* $value->getTableSchema()->columns */Yii::$app->params['constants']['columns']  as $key_ => $columns) {


                $TEMP_LINK = "";
                if ($columns == "link") {
                    if (isset($value->{$columns}) && strpos($value->{$columns}, 'http') !== false) {

                        $TEMP_LINK =  $value->{$columns}   === "/No+data"  ? '#' : $value->{$columns};
                        if (in_array($target, Yii::$app->params['toEncodeUrls'])) {

                            $TEMP_LINK = $this->encodUrlForPdf($TEMP_LINK);
                        }
                        $empRows[]  = "<a href='  $TEMP_LINK   ' style='color:#3051d3'>PDF [Documents]</a>";
                    } else {
                        $empRows[]  = "<a href='#' style='color:#3051d3'>No Document</a>";
                    }
                } else {
                    if ($columns != "reportable_judgement")
                        $empRows[] = isset($value->{$columns}) ?  $value->{$columns} : "NA";
                }

                if ($columns == 'reportable_judgement') {

                    $contentUrl = $urlAndViewFile['url'] . $value->link;
                    $viewFile =  $urlAndViewFile['viewFile'];
                    $empRows[] =   $this->renderPartial($viewFile, ['id_num' => uniqid(), 'url' => $contentUrl, 'target' => $target]);
                }
            }
            /*  $contentUrl = $urlAndViewFile['url'] . $value->link;
            $viewFile =  $urlAndViewFile['viewFile'];
            $empRows[] =   $this->renderPartial($viewFile, ['id_num' => uniqid(), 'url' => $contentUrl, 'target' => $target]); */

            $resultData[] = $empRows;
        }
        /*   echo "<pre>";
           print_r( $resultData  );
       die;   
 */


        /* $numRows = array_sum(isset($allData) ? (array)$allData :  []);
        $resultData = [];
         if (isset($allData)) { 
            foreach ($allData as $result_) {
                $result = json_decode(json_encode($result_), true);
                 
                $empRows = array();
                $empRows[] =  isset($result[$columnNames['CaseNumber']])  ?  $result[$columnNames['CaseNumber']] : "NA";
                $empRows[] =  isset($result[$columnNames['DiaryNumber']]) ?   $result[$columnNames['DiaryNumber']] : "NA";
                $empRows[] =  isset($result[$columnNames['PetitionerName']])  ?  $result[$columnNames['PetitionerName']] : "NA";
                $empRows[] =  isset($result[$columnNames['RespondentName']])  ?  $result[$columnNames['RespondentName']] : "NA";
                $empRows[] =  isset($result[$columnNames['PetitionerAdvocate']])  ?  $result[$columnNames['PetitionerAdvocate']] : "NA";
                $empRows[] =  isset($result[$columnNames['RespondentAdvocate']])  ?  $result[$columnNames['RespondentAdvocate']] : "NA";
                $empRows[] =  isset($result[$columnNames['Bench']])  ?  $result[$columnNames['Bench']] : "NA";
                $empRows[] =  isset($result[$columnNames['JudgementBy']])  ?  $result[$columnNames['JudgementBy']] : "NA";

                $empRows[] =  isset($result[$columnNames['OrderDate']])  ?  $result[$columnNames['OrderDate']] : (isset($result[$columnNames['OrderDate']]) ? $result[$columnNames['OrderDate']] : "NA");

                $empRows[] =  isset($result[$columnNames['CaseType']])  ?  $result[$columnNames['CaseType']] : "NA";
                $empRows[] =  isset($result[$columnNames['CaseYear']])  ?  $result[$columnNames['CaseYear']] : "NA";
                $empRows[] =  isset($result[$columnNames['OrderType']])  ?  $result[$columnNames['OrderType']] :  $form_model->getOrderType($target);

                $empRows[] =  isset($result[$columnNames['PGNo']])  ?  $result[$columnNames['PGNo']] :  "NA";
                $empRows[] =  isset($result[$columnNames['Corrigendum']])  ?  $result[$columnNames['Corrigendum']] :  "NA";
                $empRows[] =  isset($result[$columnNames['CaseDescription']])  ?  $result[$columnNames['CaseDescription']] :  "NA";
                $empRows[] =  isset($result[$columnNames['CourtNumber']])  ?  $result[$columnNames['CourtNumber']] :  "NA";


                $TEMP_LINK = "";
                if (isset($result[$columnNames['Link']]) && strpos($result[$columnNames['Link']], 'http') !== false) {
                    $TEMP_LINK =   $result[$columnNames['Link']]  === "/No+data"  ? '#' : $result[$columnNames['Link']];
                    $empRows[]  = "<a href='$TEMP_LINK' style='color:#3051d3'>PDF [Documents]</a>";
                } else {
                    $empRows[]  = "<a href='#' style='color:#3051d3'>No Document</a>";
                }


                $contentUrl = $urlAndViewFile['url'] . $result[9];
                $viewFile =  $urlAndViewFile['viewFile']; 
                $empRows[] =   $this->renderPartial($viewFile, ['id_num' => uniqid(), 'url' => $contentUrl, 'target' => $target]);  //  "<a data-value='$result[9]' href='#' style='color:#3051d3' class='open_modal_for_file'>Click here to view</a>";
                $resultData[] = $empRows;
            }
        } */

        $output = array(
            "iTotalRecords"    =>     $numRows,
            "iTotalDisplayRecords"    =>  10,
            "data"    =>     $resultData
        );
        return json_encode($output);
    }


    public function actionFullDataIndex()
    {
        $target = $_REQUEST['court'];

        $lower_date = isset($_REQUEST['lower_date']) ?  $_REQUEST['lower_date'] :  date('Y-m-d', strtotime(date('Y-m-d') . ' - 15 days'));
        $higher_date = isset($_REQUEST['higher_date']) ?  $_REQUEST['higher_date'] : date('Y-m-d', strtotime(date('Y-m-d') . ' + 15 days'));
        $form_model = new ScrapperForm();

        $columnNames = Yii::$app->params['constants']['columnAddationalData'];
        $allData = $form_model->getByWeek(
            ['target' => $target,   'lower_date' => $lower_date, 'higher_date' =>  $higher_date]
        );
        $numRows = array_sum(isset($allData) ? (array)$allData :  []);
        $resultData = [];
        if (isset($allData)) {
            $TEMP_LINK = "";
            foreach ($allData as $result_) {
                $result = json_decode(json_encode($result_), true);
                $empRows = array();
                foreach ($result as $key => $value) {
                    if ($key == 6) { //Doc Link
                        if (strpos($value, 'http') !== false) {
                            $TEMP_LINK =   $value  === "/No+data"  ? '#' : $value;
                            $empRows[]  = "<a href='$TEMP_LINK' style='color:#3051d3'>PDF [Documents]</a>";
                        } else {
                            $empRows[]  = "<a href='#' style='color:#3051d3'>No Document</a>";
                        }
                    } else
                        $empRows[] = $value;
                }
                $resultData[] = $empRows;
            }
        }

        $output = array(
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
            /*  echo "<pre>";
            print_r($post);
            die; */
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
            } else {
                #handle the exceptional case like Delhi,
                if ($model->court === "DL1112DL1111") {
                    $model->court = $model->determineExceptionalCaseStateName($model->court, $model->scrap_type);
                }

                $model->highCourtScraper([  #state_name is being captures from params.php 
                    // 'state_name' =>$model->cleanStateName(Yii::$app->params['stateList'][$model->court]),
                    'start_date' => $model->start_date,
                    'end_date' => $model->end_date,
                ], $model->court);
                Yii::$app->session->setFlash('info', "Your data is being scrapped for " .  $model->start_date . " - " . $model->end_date);
            }


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
