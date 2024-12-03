<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property int|null $parent_id
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 */
class Comments extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'user_id', 'content'], 'required'],
            [['post_id', 'user_id', 'parent_id'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['content'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'parent_id' => 'Parent ID',
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Save the comment and set the author.
     *
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool
     */
    public function saveComment($runValidation = true, $attributeNames = null)
    {
        if ($this->isNewRecord) {
            // Set default user_id (author) when a new comment is saved
            $this->user_id = Yii::$app->user->id; // Current logged-in user
        }

        return parent::save($runValidation, $attributeNames);
    }
    // Add a relation for replies
    public function getReplies()
    {
        return $this->hasMany(Comments::class, ['parent_id' => 'id']);
    }

}
