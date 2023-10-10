<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Apple;

/**
 * AppleSearch represents the model behind the search form of `backend\models\Apple`.
 */
class AppleSearch extends Apple
{
  /*public function __construct($config = [])
  {
    parent::__construct('', $config);
  }*/

  /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_date', 'fallen_date', 'status'], 'integer'],
            [['color'], 'safe'],
            [['size'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = Apple::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'size' => $this->size,
            'created_date' => $this->created_date,
            'fallen_date' => $this->fallen_date,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'color', $this->color]);

        return $dataProvider;
    }
}
