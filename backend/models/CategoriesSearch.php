<?php

    namespace backend\models;

    use Yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use common\models\Categories;

    /**
     * CategoriesSearch represents the model behind the search form about `common\models\Categories`.
     */
    class CategoriesSearch extends Categories
    {
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'id' ], 'integer' ],
                [ [ 'name', 'slug' ], 'safe' ],
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
            $query = Categories::find();

            $dataProvider = new ActiveDataProvider( [
                'query' => $query,
            ] );

            if ( ! ( $this->load( $params ) && $this->validate() )) {
                return $dataProvider;
            }

            $query->andFilterWhere( [
                'id' => $this->id,
            ] );

            $query->andFilterWhere( [ 'like', 'name', $this->name ] )
                  ->andFilterWhere( [ 'like', 'slug', $this->slug ] );

            return $dataProvider;
        }
    }
