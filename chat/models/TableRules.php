<?php

namespace app\models;

use yii\db\ActiveRecord;


class TableRules extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%auth_assignment}}';
    }


    public function changeStatus($status_user){
        $result = explode('_',$status_user);
        $change = self::findOne(['user_id' => $result[0]]);
        if($change){
            $change->item_name = $result[1];
            $change->save();
            return true;
        }
        return false;
    }


}