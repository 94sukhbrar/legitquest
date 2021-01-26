<?php
/**
 *@copyright : Amusoftech Pvt. Ltd. < www.amusoftech.com >
 *@author    : Amu < er.amu@live.com >
 */
namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Courts as CourtsModel;

/**
 * Courts represents the model behind the search form about `app\models\Courts`.
 */
class Courts extends CourtsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by_id'], 'integer'],
            [['code', 'title', 'state_name', 'state_cd', 'dist_cd', 'court_code', 'created_on', 'updated_on'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    public function beforeValidate(){
            return true;
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CourtsModel::find();

		        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
						'defaultOrder' => [
								'id' => SORT_DESC
						]
				]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_on' => $this->created_on,
            'updated_on' => $this->updated_on,
            'created_by_id' => $this->created_by_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'state_name', $this->state_name])
            ->andFilterWhere(['like', 'state_cd', $this->state_cd])
            ->andFilterWhere(['like', 'dist_cd', $this->dist_cd])
            ->andFilterWhere(['like', 'court_code', $this->court_code]);

        return $dataProvider;
    }
}
