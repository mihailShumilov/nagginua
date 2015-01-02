<?php

    namespace backend\models;

    use Yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use common\models\Npn;

    /**
     * NpnSearch represents the model behind the search form about `common\models\Npn`.
     */
    class NpnSearch extends Npn
    {
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'news_id', 'pending_news_id' ], 'integer' ],
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
            $query = Npn::find();

            $dataProvider = new ActiveDataProvider( [
                'query' => $query,
            ] );

            if ($this->load( $params ) && ! $this->validate()) {
                return $dataProvider;
            }

            $query->andFilterWhere( [
                'news_id'         => $this->news_id,
                'pending_news_id' => $this->pending_news_id,
            ] );

            return $dataProvider;
        }
    }
