<?php

    namespace backend\models;

    use Yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use common\models\RssSources;

    /**
     * RssSourcesSearch represents the model behind the search form about `common\models\RssSources`.
     */
    class RssSourcesSearch extends RssSources
    {
    /**
     * @inheritdoc
     */
        public function rules()
    {
        return [
            [ [ 'id', 'source_id', 'active', 'is_full', 'is_combine', 'category_id' ], 'integer' ],
            [ [ 'url', 'created_at', 'updated_at' ], 'safe' ],
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
            $query = RssSources::find();

            $dataProvider = new ActiveDataProvider( [
                'query' => $query,
            ] );

            $this->load( $params );

            if ( ! $this->validate()) {
                // uncomment the following line if you do not want to any records when validation fails
                // $query->where('0=1');
            return $dataProvider;
        }

            $query->andFilterWhere( [
                'id'          => $this->id,
                'source_id'   => $this->source_id,
                'active'      => $this->active,
                'is_full'     => $this->is_full,
                'is_combine'  => $this->is_combine,
                'created_at'  => $this->created_at,
                'updated_at'  => $this->updated_at,
                'category_id' => $this->category_id,
            ] );

            $query->andFilterWhere( [ 'like', 'url', $this->url ] );

            return $dataProvider;
    }
    }
