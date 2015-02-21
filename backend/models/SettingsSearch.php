<?php

    namespace backend\models;

    use Yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use common\models\Settings;

    /**
     * SettingsSearch represents the model behind the search form about `common\models\Settings`.
     */
    class SettingsSearch extends Settings
    {
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'name', 'value' ], 'safe' ],
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
            $query = Settings::find();

            $dataProvider = new ActiveDataProvider( [
                'query' => $query,
            ] );

            $this->load( $params );

            if ( ! $this->validate()) {
                // uncomment the following line if you do not want to any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            $query->andFilterWhere( [ 'like', 'name', $this->name ] )
                  ->andFilterWhere( [ 'like', 'value', $this->value ] );

            return $dataProvider;
        }
    }
