<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jokes".
 *
 * @property integer $id
 * @property string $joke
 */
class Jokes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jokes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['joke'], 'required'],
            [['joke'], 'string', 'max' => 3000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'joke' => 'Joke',
        ];
    }

    /**
     * @inheritdoc
     * @return JokesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JokesQuery(get_called_class());
    }
}
