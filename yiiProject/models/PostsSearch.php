<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Posts;

class PostsSearch extends Posts
{
    public $title;

    public function rules()
    {
        return [
            [['title'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Posts::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
