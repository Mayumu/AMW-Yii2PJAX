<?php

namespace common\components;

use common\models\User;

/**
 * Description of UserService
 *
 * @author Mayumu
 */
class UserService
{
    public static function getName($id)
    {
        $data = User::find()
                ->select('username')
                ->where(['id' => $id])
                ->one();
        return isset($data['username']) ? $data['username'] : false;
    }
    
    public static function getAvatar($id)
    {
        $data = User::find()
                ->select('avatar')
                ->where(['id' => $id])
                ->one();
        return isset($data['avatar']) ? $data['avatar'] : false;
    }
    
    public static function getLevel($id)
    {
        $data = User::find()
                ->select('type')
                ->where(['id' => $id])
                ->one();
        return isset($data['type']) ? $data['type'] : false;
    }
}
