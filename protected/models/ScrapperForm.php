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

	public function hitCurlApi($url)
	{

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
		//die( $url );
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_ENCODING, ""); // this will handle gzip content
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result);
	}
	public function asyncall($urls, $followLocation = false, $maxRedirects = 10)
	{   // Options
		$curlOptions = [
			CURLOPT_HEADER => false,
			CURLOPT_NOBODY => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_ENCODING => ""
		];

		if ($followLocation) {
			$curlOptions[CURLOPT_FOLLOWLOCATION] = true;
			$curlOptions[CURLOPT_MAXREDIRS] = $maxRedirects;
		}

		// Init multi-curl
		$mh = curl_multi_init();
		$chArray = [];

		$urls = !is_array($urls) ? [$urls] : $urls;
		foreach ($urls as $key => $url) {
			// Init of requests without executing
			$ch = curl_init($url);
			curl_setopt_array($ch, $curlOptions);

			$chArray[$key] = $ch;

			// Add the handle to multi-curl
			curl_multi_add_handle($mh, $ch);
		}

		// Execute all requests simultaneously
		$active = null;
		do {
			$mrc = curl_multi_exec($mh, $active);
		} while ($mrc == CURLM_CALL_MULTI_PERFORM);

		while ($active && $mrc == CURLM_OK) {
			// Wait for activity on any curl-connection
			if (curl_multi_select($mh) === -1) {
				usleep(100);
			}

			while (curl_multi_exec($mh, $active) == CURLM_CALL_MULTI_PERFORM);
		}

		// Close the resources
		foreach ($chArray as $ch) {
			curl_multi_remove_handle($mh, $ch);
		}
		curl_multi_close($mh);

		// Access the results
		$result = [];
		foreach ($chArray as $key => $ch) {

			// Get response
			$res = json_decode(curl_exec($ch));
			if (is_array($res))
				$result  = array_merge($result,   $res);  //  curl_multi_getcontent($ch);
		}

		return $result;
	}


	public function isLessThenAweek($dateRange)
	{
		#get diff in days, if more then 8 divide to week range 
		$date1 = date_create($dateRange['lower_date']);
		$date2 = date_create($dateRange['higher_date']);
		$diff = date_diff($date1, $date2);
		return  $diff; //$diff->format("%a") <= 6;
	}

	public function getByWeek($opt)
	{
		#DIVIDE INTO WEEK 
		$dateRanges = $this->weekRange($opt['lower_date'],   $opt['higher_date']);
		$overAllResults = [];
		$urls = [];
		$newDateRanges = [];
		$diff = $this->isLessThenAweek($opt);

		if ($diff->format("%a") <= 6) {

			$dateRanges = $this->splitDates($opt['lower_date'],   $opt['higher_date'], $diff->format("%a"));
			// print_r($dateRanges);
			$UPTO = count($dateRanges);
			for ($i = 0; $i < $UPTO; $i++) {

				array_push($newDateRanges, [
					"lower_date" => $dateRanges[$i],
					"higher_date" => $dateRanges[$i]
				]);
			}
		} else {
			foreach ($dateRanges as $key => $range) {
				$dateRanges = $this->splitDates($range['lower_date'],   $range['higher_date']);
				// print_r($dateRanges);
				$UPTO = count($dateRanges);
				for ($i = 0; $i < $UPTO; $i += 2) {
					if ($i < ($UPTO - 1)) {
						array_push($newDateRanges, [
							"lower_date" => $dateRanges[$i],
							"higher_date" => $dateRanges[$i + 1]
						]);
					}
				}
			}
		}

		foreach ($newDateRanges as $key => $date_params) {
			$urls[] =  Yii::$app->params['recordByCourtApiUrl'] . $this->senitizeParams(array_merge($opt, $date_params));
		}
		/* echo"<pre>";
		print_r($urls);
die; */
		$data =  $this->asyncall($urls);
		return   $data;


		#CALL API AGAINES EACH DAY
	}
	public function getDashboardRecordsFromApi($opt = ['target' => 'AP211', 'limit' => '100'])
	{

		//ini_set('memory_limit', '-1');
		$dateRanges = $this->weekRange($opt['lower_date'],   $opt['higher_date']);
		$overAllResults = [];
		$urls = [];

		foreach ($dateRanges as $key => $date_params) {
			$urls[] =  Yii::$app->params['recordByCourtApiUrl'] . $this->senitizeParams(array_merge($opt, $date_params));
			/* $url =  Yii::$app->params['recordByCourtApiUrl'] . $this->senitizeParams(array_merge($opt, $date_params)); 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_ENCODING, "");
			$result = curl_exec($ch);
			curl_close($ch);
			if ($this->hasError(json_decode($result))) {
				$overAllResults = array_merge($overAllResults, $this->recursivelyGetResults($date_params, $opt));
			}
			if (is_array(json_decode($result))) {
				$overAllResults = array_merge($overAllResults, json_decode($result));
			} */
		}
		echo "<pre>";
		print_r($urls);

		print_r($this->asyncall($urls));
		die;
		return  $overAllResults;
	}
	public function recursivelyGetResults($dateRange, $opt)
	{
		#get diff in days, if more then 8 divide to week range 
		$date1 = date_create($dateRange['lower_date']);
		$date2 = date_create($dateRange['higher_date']);
		$diff = date_diff($date1, $date2);
		$resultData = [];
		$newDateRanges = [];
		if ($diff->format("%a") <= 6) {
			$dateRanges = $this->splitDates($dateRange['lower_date'],   $dateRange['higher_date']);
			$UPTO = count($dateRanges);
			for ($i = 0; $i < $UPTO; $i += 2) {
				if ($i < ($UPTO - 1)) {
					array_push($newDateRanges, [
						"lower_date" => $dateRanges[$i],
						"higher_date" => $dateRanges[$i + 1]
					]);
				}
			}
			foreach ($newDateRanges as $key => $range) {
				$url =  Yii::$app->params['recordByCourtApiUrl'] . $this->senitizeParams(array_merge($opt, $range));
				$resultsFromApi =  $this->callApi($url);
				if ($this->hasError($resultsFromApi)) {
					#MAY CAUSE INFINITE LOOP
					$resultData = array_merge($resultData, $this->recursivelyGetResults($range, $opt));
				}
				if (is_array($resultsFromApi))
					$resultData = array_merge($resultData, $resultsFromApi);
			}
		} else {
			$dateRanges = $this->splitDates($dateRange['lower_date'],   $dateRange['higher_date'], 3);
			foreach ($dateRanges as $key => $range) {
				$url =  Yii::$app->params['recordByCourtApiUrl'] . $this->senitizeParams(array_merge($opt, $range));
				$resultsFromApi =  $this->callApi($url);
				if (is_array($resultsFromApi))
					$resultData = array_merge($resultData, $resultsFromApi);
			}
			//YET TO HANDLE
			//$dateRanges = $this->weekRange($dateRange['lower_date'],   $dateRange['higher_date']);

		}
		return $resultData;
		#other wise loop through all the days.
		//print_r($dateRange);
	}

	public function callApi($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_ENCODING, "");
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result);
	}

	public function splitDates($min, $max, $parts = 7, $output = "Y-m-d")
	{
		$dataCollection[] = date($output, strtotime($min));
		$diff = (strtotime($max) - strtotime($min)) / $parts;
		$convert = strtotime($min) + $diff;

		for ($i = 1; $i < $parts; $i++) {
			$dataCollection[] = date($output, $convert);
			$convert += $diff;
		}
		$dataCollection[] = date($output, strtotime($max));
		return $dataCollection;
	}

	public function hasError($jsonString)
	{
		return  isset($jsonString->errorMessage)  && isset($jsonString->errorMessage);
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
		/* echo "<pre>";
		print_r($result);
		die; */
		return json_decode($result);
	}

	public function apiUrlDecider($case)
	{

		switch ($case) {
			case "SUDO":
				return	['url' => Yii::$app->params['loadConetentOrders'], 'viewFile' => '_modal_judgements'];
			case "PU1111":
				return	['url' => Yii::$app->params['pdfContentExtract'], 'viewFile' => '_modal_punjab_haryana'];
			case "WB1611":
					return	['url' => Yii::$app->params['pdfContentExtractCalcutta'], 'viewFile' => '_modal_calcutta'];
			case "BB1111" :
			case "BB1112" :
			case "BB1113" :
			case "BB1114" :
			case "BB1115" :
			case "BB1116" :
			case "BB1117" :
						return	['url' => Yii::$app->params['pdfContentExtractBomby'], 'viewFile' => '_modal_bomby'];
			case "DL1112":
			case "DL1111":				
				return	['url' => Yii::$app->params['pdfContentExtractDelhi'], 'viewFile' => '_modal_delhi']; 
			case "GJ1111":				
					return	['url' => Yii::$app->params['pdfContentExtractGujarat'], 'viewFile' => '_modal_gujarat'];  
			case "TN1111":	 
			case "TN1112" :
			case "TN1113" : 
				return	['url' => Yii::$app->params['pdfContentExtractMadras'], 'viewFile' => '_modal_madras'];   
			case "MP1111" :	
				return	['url' => Yii::$app->params['pdfContentExtractMP'], 'viewFile' => '_modal_mp'];   
			default:
				return	['url' => Yii::$app->params['pdfSupremeCourt'], 'viewFile' => '_modal_order'];

				break;
		}
	}
	public function stateListFixer($addArr = [])
	{
		$items = Yii::$app->params['stateList'];
		unset($items["HIDO"]);
		$items = array_merge(["SUJU" => "Supreme Court Judgements ", "SUDO" => "Supreme Court Orders", 'JH711' => 'Jharkhand High Court', 'WB1611' => 'Calcutta High Court'], $items, $addArr);
		return $items;
	}
	/**
	 * @param target court
	 * will tell about the court orders, 
	 * @return `Orders` or `Judgements`
	 */
	public function getOrderType($target)
	{
		switch ($target) {
			case 'SUJU':
				return "Judgements";
				break;
			case 'SUDO':
				return "Orders";
				break;
			default:
				return "NA";
				break;
		}
		//return	$target === "SUJU"  ?  "Supreme Court Judgements " ? "SUDO" => "Supreme Court Orders "
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

		$start_date = date('Y-m-d', strtotime($start_date_ . '- 1 days'));
		$end_date = date('Y-m-d', strtotime($end_date_));
		$i = 1;
		$datas = [];
		for ($date = $start_date; $date <= $end_date; $date = date('Y-m-d', strtotime($date . ' + 7 days'))) {
			$wek =  $this->getWeekDates($date, $start_date, $end_date, $i);
			array_push($datas, $wek);
			$i++;
		}
		return $datas;
	}

	public function isOrderType($term, $query = "Order")
	{
		return	str_contains($term, $query);
	}

	public function isJudgementsType($term, $query = "Judgements")
	{
		return	str_contains($term, $query);
	}
}
