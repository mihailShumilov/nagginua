<?php

    namespace backend\models;

    use Yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use common\models\CategoryWords;

    /**
     * CategoryWordsSearch represents the model behind the search form about `common\models\CategoryWords`.
     */
    class CategoryWordsSearch extends CategoryWords
    {
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'id', 'category_id' ], 'integer' ],
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
            $query = CategoryWords::find();

            $dataProvider = new ActiveDataProvider( [
                'query' => $query,
            ] );

            if ( ! ( $this->load( $params ) && $this->validate() )) {
                return $dataProvider;
            }

            $query->andFilterWhere( [
                'id'          => $this->id,
                'category_id' => $this->category_id,
            ] );

            $query->andFilterWhere( [ 'like', 'word', $this->word ] );

            return $dataProvider;
        }
    }
