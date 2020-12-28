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

    public function actionIndex($model = null)
    {
        $this->layout = User::LAYOUT_LEGITQUEST;
        if (!empty($model)) {

            return $this->render('index', [
                'model' => $model
            ]);
        } else {
            $url = "https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/lambda_query?lower_date=2020-01-01&higher_date=2020-12-31&limit=30&offset=80&target=JU";
            //$url = "http://example.com/feed/main";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_ENCODING, ""); // this will handle gzip content
            $result = curl_exec($ch);
            curl_close($ch);

            return $this->render('index', [
                'model' => json_decode($result)
            ]);
        }

        return $this->redirect('scrapper');
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

            $url = "https://ffdnw92kh1.execute-api.ap-south-1.amazonaws.com/default/lambda_query?lower_date=" . $model->start_date . "&higher_date=" . $model->end_date . "&limit=20&offset=80&target=JU";
            //$url = "http://example.com/feed/main";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_ENCODING, ""); // this will handle gzip content
            $result = curl_exec($ch);
            curl_close($ch);

            return $this->render('index', [
                'model' => json_decode($result)
            ]);
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
