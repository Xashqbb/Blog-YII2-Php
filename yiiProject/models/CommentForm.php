<?php
namespace app\models;

use Yii;
use yii\base\Model;

class CommentForm extends Model
{
    public $comment;

    public function rules()
    {
        return [
            [['comment'], 'required']
        ];
    }

    public function saveComment($post_id, $comment_id = null)
    {
        $comment = new Comments;
        $comment->text = $this->comment;
        $comment->user_id = Yii::$app->user->id;
        $comment->post_id = $post_id;  // Замінено на post_id
        if ($comment_id != null) {
            $comment->comment_id = $comment_id;
        }
        $comment->date = date('Y-m-d');
        return $comment->save();
    }
}
?>
