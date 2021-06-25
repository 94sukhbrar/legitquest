<?php

namespace app\models;

use Yii;

class ModelApiHelper   extends \app\components\TActiveRecord
{

    public $tableSelected = 'HighDevDOMain';
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
        return 'HighDevDOMain';
    }


    public function getDataByCourt($courtCode, $lowerDate, $higherDate)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '600');
        if ($courtCode == "SUJU") {
            $this->tableSelected = "SupremeDevJU";
        }
        if ($courtCode == "SUDO") {
            $this->tableSelected = "SupremeDevDO";
        }
        /* $query = "SELECT id,case_type,case_number,case_year,COALESCE(case_no,'N/A'),DATE_FORMAT(order_date,'%d/%m/%Y'),
                    COALESCE(filing_type,'N/A'),COALESCE(filing_year,'N/A'),link,COALESCE(order_type,'N/A'),
                    COALESCE(order_no,'N/A'),COALESCE(petitioner_name,'N/A'),COALESCE(respondent_name,'N/A'),
                    COALESCE(petitioner_advocate,'N/A'), COALESCE(respondent_advocate,'N/A'),COALESCE(judgement_by,'N/A'),
                    COALESCE(reportable_judgement,'N/A'),COALESCE(filing_no,'N/A'),COALESCE(ci_no,'N/A'),
                    COALESCE(pg_number,'N/A'),COALESCE(corrigendum,'N/A'),COALESCE(case_description,'N/A'),
                    COALESCE(bench,'N/A'), COALESCE(case_status,'N/A'),COALESCE(court_number,'N/A') FROM HighDevDOMain 
                    where (order_date BETWEEN $lowerDate AND $higherDate ) and state='$courtCode'"; */
        $query = "SELECT  * FROM  $this->tableSelected  where (order_date BETWEEN '$lowerDate' AND '$higherDate' ) and state='$courtCode'";
        $model = self::findBySql($query)->all();
          
        return $model;
    }
    public function readSome()
    {
        ini_set('memory_limit', '-1');
        return self::find()->all();
    }
}
