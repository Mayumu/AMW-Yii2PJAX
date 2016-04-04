<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Jokes]].
 *
 * @see Jokes
 */
class JokesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Jokes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Jokes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
