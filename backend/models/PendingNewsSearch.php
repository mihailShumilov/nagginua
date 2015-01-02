<?php

    namespace backend\models;

    use Yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use common\models\PendingNews;

    /**
     * PendingNewsSearch represents the model behind the search form about `common\models\PendingNews`.
     */
    class PendingNewsSearch extends PendingNews
    {
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'id', 'source_id', 'pq_id', 'processed' ], 'integer' ],
                [
                    [
                        'title',
                        'content',
                        'search_content',
                        'thumb_src',
                        'status',
                        'group_hash',
                        'created_at',
                        'update_at'
                    ],
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
            $query = PendingNews::find();

            $dataProvider = new ActiveDataProvider( [
                'query' => $query,
            ] );

            if ($this->load( $params ) && ! $this->validate()) {
                return $dataProvider;
            }

            $query->andFilterWhere( [
                'id'         => $this->id,
                'source_id'  => $this->source_id,
                'pq_id'      => $this->pq_id,
                'processed'  => $this->processed,
                'created_at' => $this->created_at,
                'update_at'  => $this->update_at,
            ] );

            $query->andFilterWhere( [ 'like', 'title', $this->title ] )
                  ->andFilterWhere( [ 'like', 'content', $this->content ] )
                  ->andFilterWhere( [ 'like', 'search_content', $this->search_content ] )
                  ->andFilterWhere( [ 'like', 'thumb_src', $this->thumb_src ] )
                  ->andFilterWhere( [ 'like', 'status', $this->status ] )
                  ->andFilterWhere( [ 'like', 'group_hash', $this->group_hash ] );

            return $dataProvider;
        }
    }
