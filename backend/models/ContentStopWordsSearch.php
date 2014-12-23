<?php

    namespace backend\models;

    use Yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use common\models\ContentStopWords;

    /**
     * ContentStopWordsSearch represents the model behind the search form about `common\models\ContentStopWords`.
     */
    class ContentStopWordsSearch extends ContentStopWords
    {
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'id', 'source_id' ], 'integer' ],
                [ [ 'word' ], 'safe' ],
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
            $query = ContentStopWords::find();

            $dataProvider = new ActiveDataProvider( [
                'query' => $query,
            ] );

            if ($this->load( $params ) && ! $this->validate()) {
                return $dataProvider;
            }

            $query->andFilterWhere( [
                'id'        => $this->id,
                'source_id' => $this->source_id,
            ] );

            $query->andFilterWhere( [ 'like', 'word', $this->word ] );

            return $dataProvider;
        }
    }
