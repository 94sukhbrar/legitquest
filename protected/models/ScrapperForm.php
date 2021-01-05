<?php

/**
 *@copyright :Amusoftech Pvt. Ltd. < www.amusoftech.com >
 *@author     : Ram mohamad Singh< er.amudeep@gmail.com >
 */

namespace app\models;

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

	function dateDiff ($d1, $d2) {

		// Return the number of days between the two dates:    
		return round(abs(strtotime($d1) - strtotime($d2))/86400);
	
	} 

	public function validateDates()
	{ 
		$days = $this->dateDiff($this->end_date,$this->start_date); 
		if(!isset($this->end_date) ){
			$this->addError('end_date', 'Please give correct  End date');
		}	
		if(!isset($this->start_date) ){
			$this->addError('start_date', 'Please give correct Start date');
		}		 
		if ($days  > Yii::$app->params['maxScrapDays']) {
			//$this->addError('start_date', 'Please give correct Start and End dates');
			$this->addError('end_date', 'End Date can not be grater then '.Yii::$app->params['maxScrapDays'].' days');
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
		return str_replace(" ", "", $stateName);
	}
	public function highCourtScraper($opt = [
		"state_name" => "AndhraPradesh",
		"start_date" => "YYYY-MM-DD",
		'end_date' => "YYYY-MM-DD",
		'court_code' => '1'
	])
	{

		$optinal = [
			'state_cd' => '2', // optional for now
			'dist_cd' => '1', // optional for now
		];


		$url =  Yii::$app->params['highCourtScraper'] . $this->senitizeParams(array_merge($opt, $optinal));
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_ENCODING, ""); // this will handle gzip content
		$result = curl_exec($ch);
		curl_close($ch); 
		return json_decode($result);
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
}
