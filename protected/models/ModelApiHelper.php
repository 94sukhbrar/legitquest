<?php

namespace app\models;

use Yii;

class ModelApiHelper   extends \app\components\TActiveRecord
{

    public $tableSelected = 'HighDevDOMain';
    public $columnToWhere = 'order_date';
    public $query;
    public function __construct()
    {
        ini_set('memory_limit', '-1');
    }
    public static function getDb()
    {
        return Yii::$app->dbLive;
    }

    public static function tableName()
    {
        return  'supremedevjudgement'; //'HighDevDOMain';
    }


    public function getDataByCourt($courtCode, $lowerDate, $higherDate)
    {

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '600');
        if ($courtCode == "SUJU") {
            $this->tableSelected = "SupremeDevJU";
            $this->columnToWhere = 'judgement_date';
            $this->query = "SELECT  * FROM  $this->tableSelected  where ($this->columnToWhere  BETWEEN '$lowerDate' AND '$higherDate' )  ";
        } else if ($courtCode == "SUDO") {
            $this->tableSelected = "SupremeDevDO";
            $this->columnToWhere = 'judgement_date';
            $this->query = "SELECT  * FROM  $this->tableSelected  where ($this->columnToWhere  BETWEEN '$lowerDate' AND '$higherDate' )  ";
        } else if ($courtCode == "SUJUNew") {

            $this->tableSelected = "supremedevjudgement";
            $this->columnToWhere = 'judgement_date';
            $this->query = "SELECT *  FROM  $this->tableSelected  where ($this->columnToWhere  BETWEEN '$lowerDate' AND '$higherDate' )  ";
        } else if ($courtCode == "PU1111New") {

            $this->tableSelected = "punjab_order_dev";
            $this->query = "SELECT  * FROM  $this->tableSelected  where ($this->columnToWhere  BETWEEN '$lowerDate' AND '$higherDate' )  ";
        } else {

            $this->query = "SELECT  * FROM  $this->tableSelected  where ($this->columnToWhere  BETWEEN '$lowerDate' AND '$higherDate' ) and state='$courtCode'";
        }

        $model = self::findBySql($this->query)->all();

        /* ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '600');  
        $connection = $this->getDb();
        $command = $connection->createCommand($this->query);
        $result = $command->queryAll();
        return  $result; */

        /*  echo "<pre>";
        print_r($model); */

        return $model;
    }
    public function readSome()
    {
        ini_set('memory_limit', '-1');
        return self::find()->all();
    }
}
