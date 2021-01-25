<?php

/**
 *@copyright :Amusoftech Pvt. Ltd. < www.amusoftech.com >
 *@author     : Ram mohamad Singh< er.amudeep@gmail.com >
 */

namespace app\models;

use DateTime;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ScrapperForm extends Model
{
	public $court;
	public $scrap_type;
	public $start_date;
	public $end_date;
	public $limit = 30;
	public $offset = 0;
	const SupreameCourt = "HIDO";
	const  Judgements = "JU";
	const DailyOrders = "DO";
	/**
	 *
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			// name, email, subject and body are required
			[
				[
					'court',
					'scrap_type',
					'start_date',
					'end_date'
				],
				'required'
			],
			[['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d'],
			['start_date', 'validateDates'],

			/*
		 * // verifyCode needs to be entered correctly
		 * [
		 * 'verifyCode',
		 * 'captcha'
		 * ]
		 */
		];
	}

	function dateDiff($d1, $d2)
	{

		// Return the number of days between the two dates:    
		return round(abs(strtotime($d1) - strtotime($d2)) / 86400);
	}

	public function validateDates()
	{
		$days = $this->dateDiff($this->end_date, $this->start_date);
		if (!isset($this->end_date)) {
			$this->addError('end_date', 'Please give correct  End date');
		}
		if (!isset($this->start_date)) {
			$this->addError('start_date', 'Please give correct Start date');
		}
		if ($days  > Yii::$app->params['maxScrapDays']) {
			$this->addError('end_date', 'End Date can not be grater then ' . Yii::$app->params['maxScrapDays'] . ' days');
		}
	}


	public function senitizeParams($parm)
	{
		$params = "";
		foreach ($parm as $key => $value) {
			$params .= "$key=$value&";
		}
		return substr($params, 0, -1);
	}
	/**
	 * @description $opt=[ 'lower_date'=>'2020-01-01', 'higher_date'=>'2020-01-01',
	 *   'limit'=>'30','offset'=>80,'target'=>'JU' ]
	 */

	public function getRecordsFromApi($opt = ['lower_date' => '2020-01-01', 'higher_date' => '2020-12-11', 	'limit' => '30', 'offset' => '0', 'target' => 'JU'])
	{

		$url =  Yii::$app->params['apiUrl'] . $this->senitizeParams($opt);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_ENCODING, ""); // this will handle gzip content
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result);
	}

	public function cleanStateName($stateName)
	{

		$cleanedString = str_replace(" ", "", $stateName);
		if (strpos($cleanedString, 'HighCourt') !== false) {

			$cleanedString = substr($cleanedString, 0, strpos($cleanedString, 'HighCourt'));
		}

		return str_replace(" ", "", $cleanedString);
	}

	public function removeSpaces($cleanedString)
	{
		return str_replace(" ", "", $cleanedString);
	}

	/**
	 * @param []  start_date,end_date  
	 */
	public function supremeCourtJudgementsApi($opt = [])
	{
		$url =  Yii::$app->params['supremeCourtJudgementsApiUrl'] . $this->senitizeParams($opt);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_ENCODING, ""); // this will handle gzip content
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result);
	}


	public function getLogsFromApi()
	{
		$url =  Yii::$app->params['logsApi'];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_ENCODING, ""); // this will handle gzip content
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result);
	}


	public function determineExceptionalCaseStateName($code, $scrapeType)
	{


		return array_search("DL" . $scrapeType, Yii::$app->params['expeptionalCases']);
	}
	/**
	 * @param []  start_date,end_date  
	 */
	public function supremeCourtOrdersApi($opt = [])
	{
		$url =  Yii::$app->params['supremeCourtOrdersApiUrl'] . $this->senitizeParams($opt);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_ENCODING, ""); // this will handle gzip content
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result);
	}
	public function highCourtScraper($opt = [
		"state_name" => "AndhraPradesh",
		"start_date" => "YYYY-MM-DD",
		'end_date' => "YYYY-MM-DD"
	], $courtCode = null)
	{
		/**MERGING ADDATIONAL PARAMS */
		$optinal  =   Yii::$app->params['stateCodes'];
		$optinal = $optinal[$courtCode];
		$url =  Yii::$app->params['highCourtScraper'] . $this->senitizeParams(array_merge($opt, $optinal));
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_ENCODING, ""); // this will handle gzip content
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result);
	}
	public function asyncall($urls )
	{ 
		// Setando opção padrão para todas url e adicionando a fila para processamento
		$mh = curl_multi_init();
		foreach ($urls as $key => $value) {
			$ch[$key] = curl_init($value);
			curl_setopt($ch[$key], CURLOPT_NOBODY, true);
			curl_setopt($ch[$key], CURLOPT_HEADER, true);
			curl_setopt($ch[$key], CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch[$key], CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch[$key], CURLOPT_SSL_VERIFYHOST, false);
 

			curl_multi_add_handle($mh, $ch[$key]);
		}

		// Executando consulta
		do {
		 	curl_multi_exec($mh, $running);
	 
			curl_multi_select($mh);
		} while ($running > 0);

		// Obtendo dados de todas as consultas e retirando da fila
		foreach (array_keys($ch) as $key) {
			echo curl_getinfo($ch[$key], CURLINFO_HTTP_CODE);
			echo curl_getinfo($ch[$key], CURLINFO_EFFECTIVE_URL);
			echo "\n";

			curl_multi_remove_handle($mh, $ch[$key]);
		}
 
		// Finalizando
		curl_multi_close($mh);
	}
	public function getDashboardRecordsFromApi($opt = ['target' => 'AP211', 'limit' => '100'])
	{

		$dateRanges = $this->weekRange($opt['lower_date'],   $opt['higher_date']);
		$overAllResults = [];
		$urls =[];
		foreach ($dateRanges as $key => $date_params) {
			//$urls [] =  Yii::$app->params['recordByCourtApiUrl'] . $this->senitizeParams(array_merge($opt, $date_params));
			$url =  Yii::$app->params['recordByCourtApiUrl'] . $this->senitizeParams(array_merge($opt, $date_params));
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_ENCODING, "");
			$result = curl_exec($ch);
			curl_close($ch);
			$overAllResults = array_merge($overAllResults, json_decode($result));
		}
	 
		return  $overAllResults;


		/* $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_ENCODING, ""); 
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result); */
	}


	public function getPDFFromApi($opt = ['id_num' => '2020-01-01', 'target' => 'DO'])
	{

		$url =  Yii::$app->params['getPDFdocURL'] . $this->senitizeParams($opt);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_ENCODING, ""); // this will handle gzip content
		$result = curl_exec($ch);
		curl_close($ch);

		return json_decode($result);
	}

	public function getDataCountForCourt($target)
	{

		$url =  Yii::$app->params['countApiUrl'] . "?target=" . array_search($target, $this->stateListFixer());
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_ENCODING, ""); // this will handle gzip content
		$result = curl_exec($ch);
		curl_close($ch);

		return json_decode($result)[0][0];
	}


	public function stateListFixer($addArr = [])
	{
		$items = Yii::$app->params['stateList'];
		unset($items["HIDO"]);
		$items = array_merge(["SUJU" => "Supreme Court Judgements ", "SUDO" => "Supreme Court Orders "], $items, $addArr);
		return $items;
	}
	/**
	 *
	 * @return array customized attribute labels
	 */
	public function attributeLabels()
	{
		return [
			'verifyCode' => 'Verification Code',
			'body' => \yii::t('app', 'Message')
		];
	}

	/**
	 * Sends an email to the specified email address using the information collected by this model.
	 *
	 * @param string $email
	 *        	the target email address
	 * @return boolean whether the model passes validation
	 */
	public function contact($email)
	{
		if ($this->validate()) {
			EmailQueue::add([
				'from' => $this->email,
				'to' => $email,
				'subject' => $this->subject,
				'html' => $this->body
			]);
			return true;
		}
		return false;
	}

	function array_chunks_fixed($input_array, $chunks = 3)
	{
		if (sizeof($input_array) > 0) {
			//$chunks = 3;
			return array_chunk($input_array, intval(ceil(sizeof($input_array) / $chunks)));
		}

		return array();
	}
	public function renderModal($id_num, $data_id)
	{
		return "  <a data-toggle='modal' data-target='#myModal_$id_num' style='color:#3051d3'>PDF [Documents]</a> 
					<div class='modal fade' id='myModal_$id_num' role='dialog'>
						<div class='modal-dialog'> 
						<div class='modal-content'>
							<div class='modal-header'>
							<button type='button' class='close' data-dismiss='modal'>&times;</button>
							
							</div>
							<div class='modal-body'>
							<p><button class='downloadDoc' id='$id_num'  data-id='$data_id' style='background: none;border: none;color: blue;' >Click here </button>to Download Document.</p>
							<div id='loading_$id_num'  class='spinner-border text-info invisible' style='color: #3051d3;'></div>

							<div class='document_$id_num'></div>
							</div>
							<div class='modal-footer'>
							<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
							</div>
						</div> 
						</div>
					</div>
		 ";
	}

	function getWeekDates($date, $start_date, $end_date, $i)
	{

		$week =  date('W', strtotime($date));
		$year =  date('Y', strtotime($date));
		$from = date("Y-m-d", strtotime("{$year}-W{$week}+1")); //Returns the date of monday in week
		if ($from < $start_date) $from = $start_date;
		$to = date("Y-m-d", strtotime("{$year}-W{$week}-7"));   //Returns the date of sunday in week
		if ($to > $end_date) $to = $end_date;
		return ['lower_date' => $from, 'higher_date' => $to];
		//echo "$i th ".$from." to ".$to.'<br>';

	}

	public function weekRange($start_date_, $end_date_)
	{

		$start_date = date('Y-m-d', strtotime($start_date_));
		$end_date = date('Y-m-d', strtotime($end_date_));
		$i = 1;
		$datas = [];
		for ($date = $start_date; $date <= $end_date; $date = date('Y-m-d', strtotime($date . ' + 7 days'))) {
			$wek =  $this->getWeekDates($date, $start_date, $end_date, $i);
			array_push($datas, $wek);
			//echo "\n";
			$i++;
		}
		return $datas;
	}
}
