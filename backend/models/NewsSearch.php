<?php

    namespace backend\models;

    use Yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use common\models\News;

    /**
     * NewsSearch represents the model behind the search form about `common\models\News`.
     */
    class NewsSearch extends News
    {
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'id', 'cnt' ], 'integer' ],
                [ [ 'title', 'thumb', 'status', 'created_at', 'updated_at' ], 'safe' ],
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

        /**
         * Creates data provider instance with search query applied
         *
         * @param array $params
         *
         * @return ActiveDataProvider
         */
        public function search( $params )
        {
            $query = News::find();

            $dataProvider = new ActiveDataProvider( [
                'query' => $query,
            ] );

            if ($this->load( $params ) && ! $this->validate()) {
                return $dataProvider;
            }

            $query->andFilterWhere( [
                'id'         => $this->id,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'cnt'        => $this->cnt,
            ] );

            $query->andFilterWhere( [ 'like', 'title', $this->title ] )
                  ->andFilterWhere( [ 'like', 'thumb', $this->thumb ] )
                  ->andFilterWhere( [ 'like', 'status', $this->status ] );

            return $dataProvider;
        }
    }
