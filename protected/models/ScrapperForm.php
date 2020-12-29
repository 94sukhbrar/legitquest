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
			[['start_date','end_date'], 'date', 'format' => 'php:Y-m-d'],
			['start_date','validateDates'],
			
			/*
		 * // verifyCode needs to be entered correctly
		 * [
		 * 'verifyCode',
		 * 'captcha'
		 * ]
		 */
		];
	} 
	public function validateDates(){
		if(strtotime($this->end_date) <= strtotime($this->start_date)){
			$this->addError('start_date','Please give correct Start and End dates');
			$this->addError('end_date','Please give correct Start and End dates');
		}
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
