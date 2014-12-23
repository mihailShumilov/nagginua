<?php

    namespace backend\models;

    use Yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use common\models\Sources;

    /**
     * SourcesSearch represents the model behind the search form about `common\models\Sources`.
     */
    class SourcesSearch extends Sources
    {
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'id', 'active' ], 'integer' ],
                [
                    [ 'label', 'url', 'category_pattern', 'news_pattern', 'thumb_pattern', 'created_at', 'updated_at' ],
                    'safe'
                ],
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
            $query = Sources::find();

            $dataProvider = new ActiveDataProvider( [
                'query' => $query,
            ] );

            if ($this->load( $params ) && ! $this->validate()) {
                return $dataProvider;
            }

            $query->andFilterWhere( [
                'id'         => $this->id,
                'active'     => $this->active,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ] );

            $query->andFilterWhere( [ 'like', 'label', $this->label ] )
                  ->andFilterWhere( [ 'like', 'url', $this->url ] )
                  ->andFilterWhere( [ 'like', 'category_pattern', $this->category_pattern ] )
                  ->andFilterWhere( [ 'like', 'news_pattern', $this->news_pattern ] )
                  ->andFilterWhere( [ 'like', 'thumb_pattern', $this->thumb_pattern ] );

            return $dataProvider;
        }
    }
