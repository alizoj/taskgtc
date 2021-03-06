<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Application;

/**
 * ApplicationSearch represents the model behind the search form of `common\models\Application`.
 */
class ApplicationSearch extends Application
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status',], 'integer'],
            [['FIO', 'phone_number', 'message', 'created_at', 'updated_at', 'email'], 'safe'],
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
        $query = Application::find()->joinWith('user');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['id', 'FIO', 'phone_number', 'message', 'created_at', 'updated_at', 'email']]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'application.id' => $this->id,
            'application.status' => $this->status,
            'application.created_at' => $this->created_at,
            'application.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'FIO', $this->FIO])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'user.email', $this->email])
            ->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
