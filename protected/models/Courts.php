<?php

 

/**
* This is the model class for table "tbl_courts".
*
    * @property integer $id
    * @property string $code
    * @property string $title
    * @property string $state_name
    * @property string $state_cd
    * @property string $dist_cd
    * @property string $court_code
    * @property string $created_on
    * @property string $updated_on
    * @property integer $created_by_id
*/

namespace app\models;

use Yii;

use yii\helpers\ArrayHelper;

class Courts extends \app\components\TActiveRecord
{

	const STATE_INACTIVE = 0;

    const STATE_ACTIVE = 1;

    const STATE_DELETED = 2;
	public  function __toString()
	{
		return (string)$this->title;
	}
	public function beforeValidate()
	{
		if($this->isNewRecord)
		{
				if ( !isset( $this->created_on )) $this->created_on = date( 'Y-m-d H:i:s');
				if ( !isset( $this->updated_on )) $this->updated_on = date( 'Y-m-d H:i:s');
				if ( !isset( $this->created_by_id )) $this->created_by_id = Yii::$app->user->id;
			}else{
					$this->updated_on = date( 'Y-m-d H:i:s');
			}
		return parent::beforeValidate();
	}


	/**
	* @inheritdoc
	*/
	public static function tableName()
	{
		return '{{%courts}}';
	}

	/**
	* @inheritdoc
	*/
	public function rules()
	{
		return [
            [['code', 'title', 'state_name', 'state_cd', 'dist_cd', 'court_code', 'created_on'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['created_by_id'], 'integer'],
            [['code', 'title', 'state_name', 'state_cd', 'dist_cd', 'court_code'], 'string', 'max' => 255],
            [['code', 'title', 'state_name', 'state_cd', 'dist_cd', 'court_code'], 'trim'],
            [['state_name'], 'app\components\TNameValidator' ]
        ];
	}

	/**
	* @inheritdoc
	*/


	public function attributeLabels()
	{
		return [
				    'id' => Yii::t('app', 'ID'),
				    'code' => Yii::t('app', 'Code'),
				    'title' => Yii::t('app', 'Title'),
				    'state_name' => Yii::t('app', 'State Name'),
				    'state_cd' => Yii::t('app', 'State Cd'),
				    'dist_cd' => Yii::t('app', 'Dist Cd'),
				    'court_code' => Yii::t('app', 'Court Code'),
				    'created_on' => Yii::t('app', 'Created On'),
				    'updated_on' => Yii::t('app', 'Updated On'),
				    'created_by_id' => Yii::t('app', 'Created By'),
				];
	}
    public static function getHasManyRelations()
    {
    	$relations = [];
		return $relations;
	}
    public static function getHasOneRelations()
    {
    	$relations = [];
		return $relations;
	}

	public function beforeDelete() {
		return parent::beforeDelete ();
	}

    public function asJson($with_relations=false)
	{
		$json = [];
			$json['id'] 	= $this->id;
			$json['code'] 	= $this->code;
			$json['title'] 	= $this->title;
			$json['state_name'] 	= $this->state_name;
			$json['state_cd'] 	= $this->state_cd;
			$json['dist_cd'] 	= $this->dist_cd;
			$json['court_code'] 	= $this->court_code;
			$json['created_on'] 	= $this->created_on;
			$json['created_by_id'] 	= $this->created_by_id;
			if ($with_relations)
		    {
			}
		return $json;
	}
	
	
}
