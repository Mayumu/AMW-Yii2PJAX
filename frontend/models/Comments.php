<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property integer $comment_id
 * @property integer $post_id
 * @property integer $comment_author
 * @property string $comment_text
 * @property integer $anonymous_author
 * @property string $anonymous_author_name
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'anonymous_author', 'anonymous_author_name'], 'required'],
            [['post_id', 'comment_author', 'anonymous_author'], 'integer'],
            [['comment_text'], 'string', 'max' => 1000],
            [['anonymous_author_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => 'Comment ID',
            'post_id' => 'Post ID',
            'comment_author' => 'Comment Author',
            'comment_text' => 'Comment Text',
            'anonymous_author' => 'Anonymous Author',
            'anonymous_author_name' => 'Anonymous Author Name',
        ];
    }

    /**
     * @inheritdoc
     * @return CommentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommentsQuery(get_called_class());
    }
}
