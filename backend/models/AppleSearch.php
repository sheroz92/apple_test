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
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'fell_at', 'status'], 'integer'],
            [['color'], 'safe'],
            [['size', 'spoiled'], 'number'],
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
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andWhere('size > 0');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'fell_at' => $this->fell_at,
            'status' => $this->status,
            'size' => $this->size,
            'spoiled' => $this->spoiled,
        ]);

        $query->andFilterWhere(['like', 'color', $this->color]);

        return $dataProvider;
    }
}
