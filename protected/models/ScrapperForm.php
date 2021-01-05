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

			[
				[
					'court',
					'scrap_type',
					//'start_date',
					//'end_date'
				],
				'required'
			],
			[['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d'],
			//['start_date', 'validateDates'],
			['end_date', 'validateDays'],

			/*
		 * // verifyCode needs to be entered correctly
		 * [
		 * 'verifyCode',
		 * 'captcha'
		 * ]
		 */
		];
	}
	public function validateDates()
	{

		if (strtotime($this->end_date) <= strtotime($this->start_date)) {
			$this->addError('start_date', 'Please give correct Start and End dates');
			//	$this->addError('end_date', 'Please give correct Start and End dates');
		}
	}

	public function validateDays()
	{

		$end = strtotime($this->end_date);
		$start = strtotime($this->start_date);
		$diff = $end - $start;
		echo $days  = round($diff / 86400);
		if ($days > 28) {
			//$this->addError('start_date', 'You can only check the records of 28 days');
			$this->addError('end_date', 'You can only check the records of 28 days');
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

	public function getDashboardRecordsFromApi($opt = ['target' => 'AP211','limit' => '100'])
	{

		$url =  Yii::$app->params['checlApiUrl'] . $this->senitizeParams($opt);
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
