<?php

/**
 *@copyright :Amusoftech Pvt. Ltd. < www.amusoftech.com >
 *@author     : Ram mohamad Singh< er.amudeep@gmail.com >
 */

namespace app\controllers;

use app\components\TController;
use app\models\User;
use app\components\filters\AccessControl;
use app\models\ScrapperForm;
use app\models\Setting;
use Yii;

class DashboardController extends TController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'default-data',
                            'scrapper'
                        ],
                        'allow' => true,
                        'matchCallback' => function () {
                            return User::isAdmin();
                        }
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $this->layout = User::LAYOUT_LEGITQUEST;
        $this->updateMenuItems();
        $smtpConfig = isset(\Yii::$app->settings) ? \Yii::$app->settings->smtp : null;
        if (empty($smtpConfig)) {
            Setting::setDefaultConfig();
        }
        return $this->render('index');
    }

    public function actionScrapper()
    {
        $this->layout = User::LAYOUT_LEGITQUEST;
        // return $this->render('scrapper');
       /*  print_r(Yii::$app->request->post());
        die('ss'); */

        $model = new ScrapperForm;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return TActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
          
            $data = "https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/lambda_query?lower_date=".$model->start_date."&higher_date=".$model->end_date."&limit=20&offset=80&target=JU";
            echo"<pre>";
            print_r($data);die;
        }
        return $this->render('scrapper', [
            'model' => $model
        ]);
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
